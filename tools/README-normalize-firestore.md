# Firestore filename normalization

This small script normalizes filename fields in your Firestore `users` collection.

What it does
- Strips any directory path or browser fakepath (e.g. `C:\fakepath\file.pdf`) and stores only the basename (`file.pdf`).
- Normalizes `schoolWorkInfo.cert_file` and writes it back normalized.
- Ensures top-level `proofFilename` and `personalInfo.proofFilename` are present by copying from the (normalized) cert file when missing.

Safety
- The script supports `--dry-run` which only prints planned changes.
- Always run with `--dry-run` first and review the planned updates.

Usage (PowerShell on Windows)
1. Create a Firebase service account key JSON and save it somewhere (e.g. `C:\keys\serviceAccountKey.json`).
2. From project root run:

```powershell
# dry run (no writes)
node .\tools\normalize_firestore_filenames.js C:\keys\serviceAccountKey.json --dry-run

# apply changes
node .\tools\normalize_firestore_filenames.js C:\keys\serviceAccountKey.json
```

Notes
- The script requires `firebase-admin` to be installed. If you don't have it installed in your project, run:

```powershell
npm install firebase-admin
```

- The script assumes your `users` collection is named `users`. If you use a different collection name, edit the script accordingly.

If you'd like, I can also prepare a more conservative migration that writes changes to a separate collection or adds an `migratedAt` timestamp to each updated document.