<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<footer id="nosotros" class="vp-footer">
    <div class="vp-footer-top vp-rail">
        <div>
            <a href="<?= site_url('/') ?>" class="vp-brand" aria-label="VerificaPay, inicio">
                <img src="<?= arsha_asset('img/hero-img-sinfondo.png') ?>" alt="VerificaPay">
            </a>
            <p>Creemos que la confianza empieza con información clara.<br>
                Construimos VerificaPay para acercarla a cada negocio.</p>
        </div>
        <a class="vp-text-link" href="<?= site_url('contacto') ?>">
            Conectemos <i class="bi bi-arrow-up-right"></i>
        </a>
    </div>
    <div class="vp-footer-bottom vp-rail">
        <span>© <?= date('Y') ?> VerificaPay by Softcre. Todos los derechos reservados.</span>
        <span>Claridad que mueve tu negocio.</span>
        <a href="<?= site_url('contacto') ?>">Contactanos <i class="bi bi-arrow-up-right"></i></a>
    </div>
</footer>

<a href="#hero"
   id="scroll-top"
   class="scroll-top d-flex align-items-center justify-content-center">

    <i class="bi bi-arrow-up-short"></i>

</a>

<div id="preloader"></div>