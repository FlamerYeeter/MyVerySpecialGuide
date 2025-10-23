<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Job Load Debug</title>
  <style>body{font-family:system-ui,Segoe UI,Roboto,Arial;margin:18px;color:#111} pre{background:#f6f8fa;padding:12px;border-radius:6px;overflow:auto} .k{font-weight:600}</style>
</head>
<body>
  <h1>Job Load Debug Information</h1>
  <p>If you're seeing this page the application was unable to load the requested job or required dataset. Below are diagnostics to help you debug.</p>

  <h2>Request</h2>
  <p><span class="k">job_id:</span> {{ $jobId ?? '(none)' }}<br>
  <span class="k">route:</span> {{ request()->getPathInfo() }}</p>

  <h2>Files</h2>
  <ul>
    <li><span class="k">postings.csv exists:</span> {{ $files['postings_exists'] ? 'yes' : 'no' }}
      @if($files['postings_exists']) - size {{ $files['postings_size'] }} bytes, mtime: {{ $files['postings_mtime'] }} @endif</li>
    <li><span class="k">recommendations.json exists:</span> {{ $files['reco_exists'] ? 'yes' : 'no' }}
      @if($files['reco_exists']) - size {{ $files['reco_size'] }} bytes, mtime: {{ $files['reco_mtime'] }} @endif</li>
    <li><span class="k">guardian approvals file exists:</span> {{ $files['approvals_exists'] ? 'yes' : 'no' }}</li>
  </ul>

  <h2>Parser result</h2>
  <p><span class="k">assoc result:</span></p>
  <pre>{{ var_export($assoc, true) }}</pre>

  <h2>Laravel log (tail)</h2>
  <p>Last {{ count($logTail) }} lines from <code>storage/logs/laravel.log</code> (newest last):</p>
  <pre>@foreach($logTail as $ln){{ $ln }}@endforeach</pre>

  <h2>Helpful next steps</h2>
  <ol>
    <li>Confirm `public/postings.csv` is present and well-formed (headers on first row).</li>
    <li>If you're using `recommendations.json`, ensure `public/recommendations.json` exists and is valid JSON.</li>
    <li>Check `storage/logs/laravel.log` for errors (the tail above may help).</li>
    <li>Locally run the JobCsvParser unit test: <code>vendor\bin\phpunit --filter JobCsvParserTest</code></li>
  </ol>

  <p><a href="/job-application-review1?job_id={{ urlencode($jobId) }}&recheck=1">Recheck now</a> · <a href="/job-application-review1?job_id={{ urlencode($jobId) }}&force_view=1">Force proceed to review (not recommended)</a></p>
</body>
</html>
