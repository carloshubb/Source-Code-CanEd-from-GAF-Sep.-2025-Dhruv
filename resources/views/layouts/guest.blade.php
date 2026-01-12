<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="https://proximastudy.com/img/frontend/logo.png" />
        <title>Proxima Study</title>
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <style>
            
.tooltiptext::after {
  content: "";
  border-width: 10px;
  border-style: solid;
  /* border-color: #181717 transparent transparent transparent; */
  border-color: transparent transparent #b1040e transparent;
  position: absolute;
  top: -20px;
  left: 15px;
  z-index: 10;
}
.tooltiptext::before {
  content: "";
  border-width: 10px;
  border-style: solid;
  /* border-color: #181717 transparent transparent transparent; */
  border-color: transparent transparent #fee2e2 transparent;
  position: absolute;
  top: -18px;
  left: 15px;
  z-index: 20;
}
        </style>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
