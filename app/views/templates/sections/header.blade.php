<title>@dispatchFilter('page_title', $sitename)</title>

<meta name="description" content="{{ $sitename }}">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="theme-color" content="{{ $primaryColor }}">
<meta name="color-scheme" content="{{ $theme }}">
<meta name="identifier-URL" content="{!! BASE_URL !!}">
<meta name="leantime-version" content="{{ $version }}">

@dispatchEvent('afterMetaTags')

<link rel="shortcut icon" href="{!! BASE_URL !!}/dist/images/favicon.png"/>
<link rel="apple-touch-icon" href="{!! BASE_URL !!}/dist/images/apple-touch-icon.png">

<link rel="stylesheet" href="{!! BASE_URL !!}/dist/css/main.{!! $version !!}.min.css"/>

@dispatchEvent('afterLinkTags')

<script src="{!! BASE_URL !!}/api/i18n"></script>

<!-- libs -->
<script src="{!! BASE_URL !!}/dist/js/compiled-base-libs.{!! $version !!}.min.js"></script>
<script src="{!! BASE_URL !!}/dist/js/compiled-extended-libs.{!! $version !!}.min.js"></script>
@dispatchEvent('afterScriptLibTags')

<!-- app -->
<script src="{!! BASE_URL !!}/dist/js/compiled-app.{!! $version !!}.min.js"></script>
@dispatchEvent('afterMainScriptTag')

<!-- theme & custom -->
@foreach ($themeScripts as $script)
    <script src="{!! $script !!}"></script>
@endforeach

@foreach ($themeStyles as $style)
    <link rel="stylesheet" @isset($style['id']) id="{{{ $style['id'] }}}" @endisset href="{!! $style['url'] !!}" />
@endforeach

@dispatchEvent('afterScriptsAndStyles')

<!-- Replace main theme colors -->
@foreach ($accents as $accent)
    <style>:root { --accent{{ $loop->iteration }}: {{{ $accent }}}; }</style>
@endforeach

@dispatchEvent('afterThemeColors')
