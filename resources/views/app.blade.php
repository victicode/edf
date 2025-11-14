<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EDF-APP</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <!-- Styles / Scripts -->
         <style>
            .hiddenx{
                display: none;
            }
            .blockx{
                display: block;
            }
            .flexX{
                display: flex;
            }
            @media (min-width: 768px){
                .md\:justify-end{
                    justify-content: end!important;
                }
                .md\:hiddenx{
                    display: none!important;
                }
                .md\:block {
                    display: block!important;
                }
                .md\:flex {
                    display: flex!important;
                }
                .md\:justify-start{
                    justify-content: start!important;
                }
            }

            * {
                    font-family: "Roboto", sans-serif;
                    font-optical-sizing: auto;
                    font-weight: 400;
                    font-style: normal;
                }
         </style>
       
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50" style="overflow: hidden;">
        <!-- <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 h-screen" id="app">
                
        </div> -->
        bienvenido al backend
    </body>
</html>
