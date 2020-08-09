<!DOCTYPE html>
<html style='height: 100%' lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Watch&Learn</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body style='height: 100%'>
        <div id="app"/>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
