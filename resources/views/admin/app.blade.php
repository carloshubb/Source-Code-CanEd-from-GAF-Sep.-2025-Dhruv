<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if (Auth::check())
    <meta name="user" content="{{ Auth::user() }}">
    @endif
    <link rel="icon" href="/assets/fevicon.png">
    {{-- <link rel="icon" href="https://proximastudy.com/img/frontend/logo.png" /> --}}
    <title>Proxima Study</title>
    {{-- <link rel="icon" href="https://proximastudy.com/img/frontend/logo.png"/> --}}
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <script src="{{asset('js/app.js')}}" defer></script>
</head>

<body class="h-screen">

    <div id="app">
        <router-view />
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    {{-- <script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script> --}}
    <script src="{{ asset('ckeditor/ckeditor.js')}}"></script>
</body>
<script>
    // window.onload = function() {
    //     let currentURL = window.location.href;
    //     if (!currentURL.includes("/login") && !currentURL.includes("/logout")) {
    //         localStorage.setItem("return_url", currentURL); // Store current URL
    //     }
    // };
//     if (!window.location.pathname.includes('login')) {
//     localStorage.setItem('lastPage', window.location.href);
// }
// window.onload = function() {
//         if (!window.location.pathname.includes('login') && !window.location.pathname.includes('logout')) {
//             let currentURL = window.location.href;
//             console.log('Storing last page URL:', currentURL); // Log the URL being stored
//             localStorage.setItem('lastPage', currentURL);
//         }
//     };
</script>

</html>