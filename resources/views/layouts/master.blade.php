<!DOCTYPE HTML>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>@yield('title') | {{ config('app.name') }}</title>
            <meta name="description" content="@yield('description')">
            
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <link rel="stylesheet" href="//cdn.metalab.csun.edu/metaphor/css/metaphor.css">

        {{-- APP SCRIPTS --}}
        <script src="//cdn.metalab.csun.edu/metaphor/js/metaphor.js"></script>
    </head>
    <body>

        {{-- APP CONTENT BEGINS --}}
        @include('layouts.partials.header')
        <div class="main">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            @include('layouts.partials.sidebar')
                            <br>
                        </div>
                        <div class="col-md-9">
                            <h1>@yield('title')</h1>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
            {{-- MODALS --}}
            @yield('modal')
        @include('layouts.partials.footer')
        {{-- APP CONTENT ENDS --}}
    </body>
</html>