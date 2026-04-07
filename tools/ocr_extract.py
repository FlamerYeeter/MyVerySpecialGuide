#!/usr/bin/env python3
"""
Lightweight OCR extraction script.

Usage:
  python tools/ocr_extract.py --input public/uploads/ocr --output docs/ocr_personal_table.csv

Notes:
- Requires Tesseract and Python packages listed in requirements.txt
- This script uses simple heuristics to extract: name, DOB, PWD detection, medical dates,
  fit-to-work verdict, education cert names/dates/issuers, and safety/work cert info.
"""
import argparse
import csv
import os
import re
from glob import glob
from datetime import datetime

try:
    from PIL import Image
    import pytesseract
except Exception:
    print("Missing Python dependencies. Install with: pip install -r tools/requirements.txt")
    raise


DATE_PATTERNS = [
    r"(January|Jan|February|Feb|March|Mar|April|Apr|May|June|Jun|July|Jul|August|Aug|September|Sep|October|Oct|November|Nov|December|Dec)\s+\d{1,2},?\s+\d{4}",
    r"\d{1,2}/\d{1,2}/\d{2,4}",
    r"\d{4}-\d{2}-\d{2}",
]


def find_dates(text):
    dates = []
    for p in DATE_PATTERNS:
        for m in re.findall(p, text, flags=re.IGNORECASE):
            # m may be tuple when groups are present
            if isinstance(m, tuple):
                m = ' '.join(m)
            dates.append(m.strip())
    return dates


def normalize_date(s):
    try:
        # Try common formats
        s = s.replace('.', '').strip()
        dt = None
        for fmt in ("%B %d, %Y", "%b %d, %Y", "%Y-%m-%d", "%m/%d/%Y", "%m/%d/%y", "%d/%m/%Y"):
            try:
                dt = datetime.strptime(s, fmt)
                break
            except Exception:
                continue
        if dt:
            return dt.strftime('%Y-%m-%d')
    except Exception:
        pass
    return s


def extract_fields_from_text(text, known_users=None):
    data = {}
    text_l = text.lower()

    # Name: try to match known users first
    name = None
    if known_users:
        for uid, info in known_users.items():
            n = info.get('name')
            if n and n.lower() in text_l:
                name = n
                data['user_id'] = uid
                break

    # fallback: look for a full-caps name line (simple heuristic)
    if not name:
        m = re.search(r"\n([A-Z][A-Za-z]+(?: [A-Z][A-Za-z]+){1,3})\n", text)
        if m:
            name = m.group(1).strip()

    data['name'] = name or ''

    # DOB
    dob = ''
    m = re.search(r"(Date of Birth|DOB|Birth)[:\s]*([A-Za-z0-9, /-]+)", text, flags=re.IGNORECASE)
    if m:
        dob = normalize_date(m.group(2).strip())
    else:
        # search for any date that could be birthdate (year <= 2008 assume DOB)
        for d in find_dates(text):
            norm = normalize_date(d)
            try:
                y = int(norm[:4])
                if y <= datetime.now().year - 14:  # rough age filter
                    dob = norm
                    break
            except Exception:
                continue

    data['dob'] = dob

    # PWD / ID detection
    pwd = False
    if re.search(r"\bPWD\b|person with disability|type of disability|id no|philippine", text, flags=re.IGNORECASE):
        pwd = True
    data['pwd'] = pwd

    # Medical dates & fit-to-work
    med_dates = []
    med_dates += find_dates(text)
    data['medical_dates'] = ';'.join([normalize_date(d) for d in med_dates])

    fit = ''
    if re.search(r"not fit to perform|not fit to work|not fit", text, flags=re.IGNORECASE):
        fit = 'not fit'
    elif re.search(r"fit to work|fit for work|fit to work under", text, flags=re.IGNORECASE):
        fit = 'fit (conditional)'
    data['fit'] = fit

    # Certificates (education/work/safety)
    certs = []
    issuer = None
    # simple heuristics
    if 'tesda' in text_l:
        issuer = 'TESDA'
    if 'certificate of completion' in text_l or 'certificate of completion' in text:
        # pull nearby lines for course name and date
        for line in text.splitlines():
            if 'certificate' in line.lower():
                continue
            if re.search(r"\b(Preparing|Fundamentals|Course|Training|Safety)\b", line, flags=re.IGNORECASE):
                certs.append(line.strip())
    # safety training
    if 'safety' in text_l or 'health training' in text_l or 'osh' in text_l:
        certs.append('Safety/OSH training')

    data['certs'] = certs
    data['issuer'] = issuer or ''

    return data


def process_files(input_dir, users):
    records = []
    patterns = ['*.png', '*.jpg', '*.jpeg', '*.tif', '*.tiff', '*.pdf']
    files = []
    for p in patterns:
        files.extend(glob(os.path.join(input_dir, p)))

    for f in sorted(files):
        print('Processing', f)
        text = ''
        if f.lower().endswith('.pdf'):
            # try to convert first page using PIL/fitz if available (skipping heavy deps)
            try:
                from pdf2image import convert_from_path
                pages = convert_from_path(f, first_page=1, last_page=1)
                if pages:
                    text = pytesseract.image_to_string(pages[0])
            except Exception:
                print('pdf2image not available or failed for', f)
                continue
        else:
            try:
                img = Image.open(f)
                text = pytesseract.image_to_string(img)
            except Exception as e:
                print('Failed to open/process', f, e)
                continue

        fields = extract_fields_from_text(text, known_users=users)
        rec = {
            'file': os.path.basename(f),
            'text_snippet': (text[:200].replace('\n', ' ')),
            'name': fields.get('name', ''),
            'dob': fields.get('dob', ''),
            'pwd': 'valid' if fields.get('pwd') else 'not found',
            'medical_dates': fields.get('medical_dates', ''),
            'fit': fields.get('fit', ''),
            'certs': ';'.join(fields.get('certs', [])),
            'issuer': fields.get('issuer', ''),
        }
        records.append(rec)

    return records


def read_users_from_mixed_csv(path):
    """Parse the 'Table,Users' section from the mixed CSV file."""
    users = {}
    if not os.path.exists(path):
        return users
    with open(path, 'r', encoding='utf-8') as fh:
        lines = fh.read().splitlines()

    try:
        start = lines.index('Table,Users')
    except ValueError:
        return users

    # header is next line
    hdr = lines[start+1]
    cols = hdr.split(',')
    i = start+2
    while i < len(lines):
        line = lines[i]
        if line.startswith('Table,'):
            break
        if not line.strip():
            i += 1
            continue
        vals = line.split(',')
        row = dict(zip(cols, vals))
        uid = row.get('user_id')
        if uid:
            users[uid] = {'name': row.get('name', '').strip(), 'age': row.get('age', '').strip(), 'guardian_id': row.get('guardian_id', '').strip()}
        i += 1

    return users


def main():
    p = argparse.ArgumentParser()
    p.add_argument('--input', default='public/uploads/ocr', help='Input folder with images/PDFs')
    p.add_argument('--output', default='docs/ocr_personal_table.csv', help='Output CSV')
    p.add_argument('--users-file', default='docs/chapter4_hybrid_ocr_results.csv', help='Mixed CSV with Users table')
    args = p.parse_args()

    users = read_users_from_mixed_csv(args.users_file)
    records = process_files(args.input, users)

    # Also write a per-document detailed CSV for thesis-ready rows
    docs_header = [
        'file_name','document_id','extracted_text_snippet','personal_name','personal_dob','ID_pwd_validation',
        'ID_autofill_name','Medical_cert_date_validation','Fit_to_Work_validation','Education_cert_name',
        'Education_cert_issued_by','Education_cert_date_completed','Work_cert_job_title','Work_cert_company','Work_cert_location','Work_cert_description'
    ]
    docs_out = os.path.join(os.path.dirname(args.output), 'ocr_documents_table.csv')
    os.makedirs(os.path.dirname(docs_out) or '.', exist_ok=True)
    with open(docs_out, 'w', newline='', encoding='utf-8') as dfh:
        writer = csv.DictWriter(dfh, fieldnames=docs_header)
        writer.writeheader()
        for rec in records:
            writer.writerow({
                'file_name': rec.get('file',''),
                'document_id': '',
                'extracted_text_snippet': rec.get('text_snippet',''),
                'personal_name': rec.get('name',''),
                'personal_dob': rec.get('dob',''),
                'ID_pwd_validation': rec.get('pwd','not found'),
                'ID_autofill_name': rec.get('name','') if rec.get('pwd')=='valid' else '',
                'Medical_cert_date_validation': rec.get('medical_dates',''),
                'Fit_to_Work_validation': rec.get('fit',''),
                'Education_cert_name': rec.get('certs',''),
                'Education_cert_issued_by': rec.get('issuer',''),
                'Education_cert_date_completed': '',
                'Work_cert_job_title': '',
                'Work_cert_company': rec.get('issuer',''),
                'Work_cert_location': '',
                'Work_cert_description': rec.get('certs',''),
            })
    print('Wrote', docs_out)

    # Build output CSV header matching requested strict schema
    header = [
        'user_id','document_id','char_accuracy','word_accuracy','OCR','personal_name','personal_age','guardian_id',
        'ID_pwd_validation','ID_autofill_name','ID_autofill_birthdate','Medical_cert_date_validation','Fit_to_Work_validation',
        'Education_cert_name','Education_cert_issued_by','Education_cert_date_completed','Work_cert_job_title','Work_cert_company',
        'Work_cert_location','Work_cert_period','Work_cert_description'
    ]

    # Start from known users
    rows = []
    for uid, info in users.items():
        rows.append({
            'user_id': uid,
            'document_id': '',
            'char_accuracy': '',
            'word_accuracy': '',
            'OCR': '',
            'personal_name': info.get('name',''),
            'personal_age': info.get('age',''),
            'guardian_id': info.get('guardian_id',''),
            'ID_pwd_validation': 'not found',
            'ID_autofill_name': '',
            'ID_autofill_birthdate': '',
            'Medical_cert_date_validation': '',
            'Fit_to_Work_validation': '',
            'Education_cert_name': '',
            'Education_cert_issued_by': '',
            'Education_cert_date_completed': '',
            'Work_cert_job_title': '',
            'Work_cert_company': '',
            'Work_cert_location': '',
            'Work_cert_period': '',
            'Work_cert_description': '',
        })

    # Merge extracted records by name (simple matching)
    for rec in records:
        name = rec.get('name','')
        matched = None
        for r in rows:
            if r['personal_name'] and name and name.lower() in r['personal_name'].lower():
                matched = r
                break
        if not matched:
            # append as new row
            matched = {k: '' for k in header}
            matched['personal_name'] = name
            rows.append(matched)

        matched['OCR'] = rec.get('text_snippet','')
        if rec.get('pwd') == 'valid':
            matched['ID_pwd_validation'] = 'valid'
            matched['ID_autofill_name'] = rec.get('name','')
            matched['ID_autofill_birthdate'] = rec.get('dob','')
        if rec.get('medical_dates'):
            matched['Medical_cert_date_validation'] = rec.get('medical_dates')
        if rec.get('fit'):
            matched['Fit_to_Work_validation'] = rec.get('fit')
        if rec.get('certs'):
            # heuristics: TESDA course names vs safety
            certs = rec.get('certs')
            if 'TESDA' in rec.get('issuer','') or 'Preparing' in certs or 'Fundamentals' in certs:
                matched['Education_cert_name'] = certs
                matched['Education_cert_issued_by'] = rec.get('issuer','') or 'TESDA'
            if 'Safety' in certs:
                matched['Work_cert_job_title'] = 'Safety Training'
                matched['Work_cert_company'] = rec.get('issuer','')
                matched['Work_cert_description'] = certs

    # Write CSV
    os.makedirs(os.path.dirname(args.output) or '.', exist_ok=True)
    with open(args.output, 'w', newline='', encoding='utf-8') as fh:
        writer = csv.DictWriter(fh, fieldnames=header)
        writer.writeheader()
        for r in rows:
            writer.writerow({k: r.get(k,'') for k in header})

    print('Wrote', args.output)


if __name__ == '__main__':
    main()
