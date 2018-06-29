<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Eternal City Tools</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="pushable">
@component('menu')
@endcomponent
<div class="pusher" id="app">
    <div class="ui container" style="margin-top: 1rem; margin-bottom: 3rem;">
        <site-header></site-header>
        <main-content view-prop="{{ $view }}" route-id="{{ $routeId }}"></main-content>
        <site-footer></site-footer>
        <report-modal></report-modal>
    </div>
</div>
</body>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</html>
