<!DOCTYPE html>
<html style='height: 100%' lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
       <div>
          <h1> Hello, {{$name}}!</h1>
          <p>
           Click in the link below to reset your password:
          </p>
          <a href={{$link}}>
            {{$link}}
          </a>
       </div>
    </body>
</html>
