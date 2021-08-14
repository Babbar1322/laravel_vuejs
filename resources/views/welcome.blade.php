<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="http://unpkg.com/view-design/dist/styles/iview.css">
        <script type="text/javascript" src="http://vuejs.org/js/vue.min.js"></script>
        <script type="text/javascript" src="http://unpkg.com/view-design/dist/iview.min.js"></script>
        <link rel="stylesheet" href="/css/all.css">
        <title>FullStack</title>
<script>
    (function(){
        window.Laravel = {
            csrfToken :'{{csrf_token()}}'
        };
    })();
</script>
      
    </head>
    <body>
        <div id="app">
            @if (Auth::check())
                
            <mainapp :user="{{Auth::user()}}"></mainapp>
            @else
                
            <mainapp :user="false"></mainapp>
            @endif
        </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>
