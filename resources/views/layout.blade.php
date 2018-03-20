<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Eternal City Tools</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="pushable">
{{-- Should be a component: Navigation --}}
<div class="ui left vertical inverted menu sidebar" id="main-navigation">
    <div class="header item">
        <h2 class="ui header">Maps</h2>
    </div>
    <div class="item" data-page="map-creator">
        Map Creator
    </div>
    <div class="header item">
        <h2 class="ui header">Skills</h2>
    </div>
    <div class="header item">
        <h2 class="ui header">Characters</h2>
    </div>
    <div class="item" data-page="backstory-generator">
        Back-story Generator
    </div>
</div>
<div class="ui black big launch fixed right attached button"
     style="padding: 0.75em; position: fixed; top: 2.5em; left: 0;">
    <i class="content icon" style="margin: 0;"></i>
</div>
{{-- End Component: Navigation --}}
<div class="pusher" id="app">
    <div class="ui container" style="margin-top: 1rem; margin-bottom: 3rem;">
        <site-header></site-header>
        <main-content view-prop="{{ $view }}"></main-content>
        <site-footer></site-footer>
    </div>
</div>
</body>
<script src="{{ asset('/js/app.js') }}"></script>
</html>
