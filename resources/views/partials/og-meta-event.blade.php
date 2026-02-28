@php
    $appUrl   = rtrim(config('app.url'), '/');
    $ogImage  = $event->banner_image
        ? $appUrl . '/storage/' . ltrim(str_replace('\\', '/', $event->banner_image), '/')
        : ($event->cover_image
            ? $appUrl . '/storage/' . ltrim(str_replace('\\', '/', $event->cover_image), '/')
            : $appUrl . '/images/og-default.jpg');
    $ogTitle  = $event->title;
    $ogDesc   = trim(($event->location ?? '') . ($event->event_date ? ' — ' . $event->event_date->translatedFormat('d F Y') : ''));
    $ogUrl    = url()->current();
@endphp
<meta property="og:title"        content="{{ $ogTitle }}" />
<meta property="og:description"  content="{{ $ogDesc }}" />
<meta property="og:type"         content="website" />
<meta property="og:url"          content="{{ $ogUrl }}" />
<meta property="og:image"        content="{{ $ogImage }}" />
<meta property="og:image:width"  content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:site_name"    content="Undangan Digital" />
<meta name="twitter:card"        content="summary_large_image" />
<meta name="twitter:title"       content="{{ $ogTitle }}" />
<meta name="twitter:description" content="{{ $ogDesc }}" />
<meta name="twitter:image"       content="{{ $ogImage }}" />
