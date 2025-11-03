<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Recommender Debug - User {{ $userId }}</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; }
    pre { background:#f6f8fa; padding:12px; border:1px solid #ddd; overflow:auto }
    .col { display:inline-block; vertical-align:top; width:48%; margin-right:2% }
    .full { width:100% }
  </style>
</head>
<body>
  <h1>Recommender debug @if($userId) for user {{ $userId }} @endif</h1>

  @if(!$userId)
    <p>No user selected. Enter a numeric user id to call the recommender service:</p>
    <form method="get" action="/recommender/debug">
      <input name="userId" placeholder="e.g. 1" style="padding:6px;margin-right:8px">
      <button type="submit">Run</button>
    </form>
    <p style="margin-top:12px">Example endpoint: <code>{{ $endpoint }}</code></p>
  @else
    <p>Endpoint: <code>{{ $endpoint }}</code></p>

    @if($error)
      <div style="padding:12px;background:#ffe8e8;border:1px solid #f5c2c2;margin-bottom:12px">Error: {{ $error }}</div>
    @endif
  @endif

  <div class="col">
    <h2>Parsed JSON</h2>
    @if($response)
      <pre>{{ json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) }}</pre>
    @else
      <pre>(no parsed JSON available)</pre>
    @endif
  </div>

  <div class="col">
    <h2>Raw response</h2>
    <pre>{{ $raw ?? '(no raw response)' }}</pre>
  </div>

  <div class="full" style="margin-top:20px">
    <a href="/">Back to home</a>
  </div>
</body>
</html>
