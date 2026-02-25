@php
    $ogImage = ($announcement->og_image ?? null)
        ? rtrim(config('app.url'), '/') . '/' . ltrim($announcement->og_image, '/')
        : asset('images/og-default.jpg');
    $ogTitle = ($announcement->design_settings['heading'] ?? null) ?: $announcement->title;
    $ogDesc  = Str::limit(strip_tags($announcement->body), 150);
    $ogUrl   = url()->current();
@endphp
<meta property="og:title"        content="{{ $ogTitle }}">
<meta property="og:description"  content="{{ $ogDesc }}">
<meta property="og:type"         content="website">
<meta property="og:url"          content="{{ $ogUrl }}">
<meta property="og:image"        content="{{ $ogImage }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDesc }}">
<meta name="twitter:image"       content="{{ $ogImage }}">
