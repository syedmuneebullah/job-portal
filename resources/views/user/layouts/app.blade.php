<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>JobPortal · header</title>
    <!-- Tailwind via CDN + custom layer -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome (optional but adds flavour) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @include('user.includes.styles')
</head>
<body class="bg-slate-50/60 font-sans antialiased">

    <!-- header container – fully responsive, custom design -->
    @include('user.includes.header')

    

    <!-- page dummy content – to show header in context, scrollable -->
    @yield('content')

    @include('user.includes.footer')


    <!-- JS to toggle mobile menu -->
    @include('user.includes.scripts')
    
</body>
</html>