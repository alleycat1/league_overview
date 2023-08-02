<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png" href="./favicon16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="./favicon32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="./favicon96x96.png" sizes="96x96">
        
        
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style><?php foreach(glob('./files/assets/styles/*.css') as $css) require $css; ?></style> 
        <script><?php foreach(glob('./files/assets/scripts/*.js') as $js) require $js; ?></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
        
        
        
        <!--FONT AWESOME-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!--GOOGLE FONTS-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 
        <title><?=$title?></title>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <!-- <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0"/> -->
        <meta name="keywords" content="latestscore, livescore, soccer, premier league, football, local fixtures, all fixtures, live scores today, fixtures today">
        <meta name="description" content="<?=$description?>">
        <meta name="copyright" content="Copyright (c) 2023 Monexapps">
        <meta name="robots" content="index,follow">

        <link rel="canonical" href="https://www.latestscore.net<?=$_SERVER['REQUEST_URI']?>" />
        
   

        
    </head>
    
   
    <style>
        header {
            position: relative;
            overflow: hidden;
        }

        .stores {
            position: absolute;
            height: 80%;
            display: flex;
            right: 10%;
            top: 13px;
            z-index: 100;
        }

        .stores img {
            height: 50px;
            margin-right: 10px;
        }

        @media only screen and (max-width: 1000px) {
            
            header{
                display: none;
            }
        
             html,body {
                 
                  width: 100% !important;
                  
            }
            
            
            .stores {
                width: 150px;
                right: 10%;
                top: 40%;
            }
            .store > a {
                width: 50%;
            }
            .stores img {
                height: initial;
                width: 100%;
            }
        }
        @media only screen and (max-width: 420px) {
            .stores {
                top: 70%;
                right: 10px;
            }
        }
    </style>

    <body class="theme-dark">
        <?php
        require 'loader.php';
        require 'cookie-consent.php';
        ?>
        <header style="max-height: 100px;" class= "opacity: 0;" class="hidden md:block flex items-center block">
            <img src="./files/assets/img/header1.jpeg">
            <div class="stores">
                <a href="https://apps.apple.com/us/app/latestscore-net-livescores/id1600671292" class="def" target="_blank"><img src="./files/assets/img/latest-scores-appstore-final.png"/></a>
                <a href="https://play.google.com/store/apps/details?id=com.monexapps.latestscore&hl=en_GB&gl=US" class="def" target="_blank"><img src="./files/assets/img/latest-scores-play-store-final.png"/></a>
            </div>
        </header>
        <div class="main" style="opacity: 0;"> <!-- this tag will close in the footer  -->
