<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<header id="header" class="header vp-site-header d-flex align-items-center fixed-top">

    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="<?= site_url('/') ?>"
           class="vp-brand me-auto"
           aria-label="VerificaPay, inicio">
            <img src="<?= arsha_asset('img/hero-img-sinfondo.png') ?>" alt="VerificaPay">
        </a>

        <nav id="navmenu" class="navmenu">

            <ul>

                <li>
                    <a href="<?= isset($is_contact_page) && $is_contact_page ? site_url('/#solucion') : '#solucion' ?>">La solución</a>
                </li>
                <li>
                    <a href="<?= isset($is_contact_page) && $is_contact_page ? site_url('/#como-funciona') : '#como-funciona' ?>">Cómo funciona</a>
                </li>
                <li>
                    <a href="<?= isset($is_contact_page) && $is_contact_page ? site_url('/#nosotros') : '#nosotros' ?>">Nosotros</a>
                </li>

            </ul>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

        </nav>

        <a class="btn-getstarted" href="<?= site_url('contacto') ?>">
            Contactanos <i class="bi bi-arrow-up-right"></i>
        </a>

    </div>

</header>