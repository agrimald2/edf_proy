<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-5ZN6FMF25G"></script> <script>   window.dataLayer = window.dataLayer || [];   function gtag(){dataLayer.push(arguments);}   gtag('js', new Date());   gtag('config', 'G-5ZN6FMF25G'); </script>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="application-name" content="AC Equipos" />
        <meta name="apple-mobile-web-app-title" content="AC Equipos" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="red" />
        <link rel="apple-touch-icon" href="https://nedfac.com/logo.png" />

        <link rel="icon" href="https://nedfac.com/logo.png" type="image/png">
        <link rel="shortcut icon" href="https://nedfac.com/logo.png" type="image/png">
        <link rel="apple-touch-icon" href="https://nedfac.com/logo.png">
        <link rel="manifest" href="app.webmanifest" />


        <!-- Primary Meta Tags -->
        <meta name="title" content="NEF - Negociación Equipos de Frío" />
        <meta name="description" content="Negociación Equipos de Frío Arca Continental Lindley" />

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website" />
        <meta property="og:title" content="NEF - Negociación Equipos de Frío" />
        <meta property="og:description" content="Negociación Equipos de Frío Arca Continental Lindley" />
        <meta property="og:image" content="https://nedfac.com/logo.png" />

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image" />
        <meta property="twitter:title" content="NEF - Negociación Equipos de Frío" />
        <meta property="twitter:description" content="Negociación Equipos de Frío Arca Continental Lindley" />
        <meta property="twitter:image" content="https://nedfac.com/logo.png" />
        <meta name="description" content="Proyecto EDF">
        <meta name="author" content="Latech">

        <!-- Favicon -->
        <link rel="icon" href="https://nedfac.com/logo.png" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <script src="https://kit.fontawesome.com/2780e63ff4.js" crossorigin="anonymous"></script>
    
        <!-- Hotjar Tracking Code for https://nedfac.com/ -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:4938418,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    
    </head>
    <body class="font-sans antialiased">
        
    @inertia
    </body>
</html>
