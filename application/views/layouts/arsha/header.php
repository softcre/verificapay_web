<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="es-AR">

<head>

    <meta charset="utf-8">

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        <?= isset($title) ? html_escape($title) : 'VerificaPay' ?>
    </title>

    <meta name="description"
          content="<?= isset($meta_description) ? html_escape($meta_description) : '' ?>">

    <meta name="keywords"
          content="<?= isset($meta_keywords) ? html_escape($meta_keywords) : '' ?>">


    <!-- Favicons -->

    <link href="<?= arsha_asset('img/favicon.png') ?>" rel="icon">

    <link href="<?= arsha_asset('img/apple-touch-icon.png') ?>"
          rel="apple-touch-icon">


    <!-- Fonts -->

    <link href="https://fonts.googleapis.com" rel="preconnect">

    <link href="https://fonts.gstatic.com"
          rel="preconnect"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">


    <!-- Vendor CSS Files -->

    <link href="<?= arsha_asset('vendor/bootstrap/css/bootstrap.min.css') ?>"
          rel="stylesheet">

    <link href="<?= arsha_asset('vendor/bootstrap-icons/bootstrap-icons.css') ?>"
          rel="stylesheet">

    <link href="<?= arsha_asset('vendor/aos/aos.css') ?>"
          rel="stylesheet">

    <link href="<?= arsha_asset('vendor/glightbox/css/glightbox.min.css') ?>"
          rel="stylesheet">

    <link href="<?= arsha_asset('vendor/swiper/swiper-bundle.min.css') ?>"
          rel="stylesheet">


    <!-- Main CSS File -->

    <link href="<?= arsha_asset('css/main.css') ?>"
          rel="stylesheet">

    <link href="<?= arsha_asset('css/landing.css') ?>"
          rel="stylesheet">
  <!-- =======================================================
  * Template Name: Arsha
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Updated: Feb 22 2025 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body class="index-page">