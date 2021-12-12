<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <title>E-Commerce</title>
    </head>
    <body class="font-robo">
        <div id="app">
            @yield('content')
            @yield('navbar')
            <footer class="flex flex-col md:flex-row text-center md:justify-between text-white bg-gray-bg py-6 px-10 md:px-52 text-lg">
                    <div>Created by <span class="font-bold">Mohamed Elsayed</span>.</div>
                    <ul class="flex justify-center xl:justify-between  xl:w-2/12">
                        <li class="mr-3 xl:mr-0">My socials</li>
                        <li class="hover:text-white mr-3 xl:mr-0"><a href="#"><i class="fa fa-globe"></i></a></li>
                        <li class="hover:text-white mr-3 xl:mr-0"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li class="hover:text-white"><a href="#"><i class="fa fa-github"></i></a></li>
                    </ul>
            </footer>
        </div>
        @yield('extra-js')
    </body>
</html>
