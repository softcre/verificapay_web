<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main class="vp-main">
    <section id="hero" class="vp-hero">
        <div class="vp-hero-grid" aria-hidden="true"></div>
        <div class="vp-hero-copy">
            <span class="vp-eyebrow"><span class="vp-status-dot"></span> CLARIDAD EN CADA TRANSACCIÓN</span>
            <h1>La certeza de un pago.<br><em>En tiempo real.</em></h1>
            <p>Pagá. Verificá. Entregá. VerificaPay está diseñado para<br class="vp-desktop-break">
                simplificar la verificación de pagos de tu negocio.</p>
            <div class="vp-hero-actions">
                <a href="<?= site_url('contacto') ?>" class="vp-button vp-button-mint">Conocé VerificaPay <i class="bi bi-arrow-up-right"></i></a>
                <a href="#como-funciona" class="vp-text-link">Descubrí cómo funciona <i class="bi bi-arrow-down"></i></a>
            </div>
        </div>

        <div class="vp-product-stage" data-screenshot-carousel role="group" aria-label="Capturas de VerificaPay">
            <div class="vp-screenshot-frame" aria-live="off">
                <img
                    class="vp-screenshot is-active"
                    src="<?= asset_url('img/landing/screenshots/' . rawurlencode('example using page.jpeg')) ?>"
                    alt="VerificaPay en modo claro"
                    width="1600"
                    height="531">
                <img
                    class="vp-screenshot"
                    src="<?= asset_url('img/landing/screenshots/' . rawurlencode('example using page on dark mode.jpeg')) ?>"
                    alt="VerificaPay en modo oscuro"
                    width="1600"
                    height="529"
                    aria-hidden="true">
            </div>
            <div class="vp-screenshot-controls" role="group" aria-label="Elegir tema de la captura">
                <button type="button" data-screenshot-target="0" aria-pressed="true">
                    <i class="bi bi-sun" aria-hidden="true"></i> Modo claro
                </button>
                <button type="button" data-screenshot-target="1" aria-pressed="false">
                    <i class="bi bi-moon-stars" aria-hidden="true"></i> Modo oscuro
                </button>
            </div>
        </div>

        <div class="vp-hero-trust">
            <span><i class="bi bi-broadcast"></i> Visibilidad de movimientos</span>
            <span><i class="bi bi-lock"></i> Acceso de solo lectura</span>
            <span><i class="bi bi-shield-check"></i> Confianza en cada paso</span>
        </div>
    </section>

    <section id="solucion" class="vp-solution vp-rail">
        <div class="vp-section-intro">
            <span class="vp-eyebrow vp-dark-eyebrow">01 / LA SOLUCIÓN</span>
            <h2>Tu tiempo es para crecer.<br><span>No para perseguir pagos.</span></h2>
            <p>Una forma más simple de saber qué pasó con cada pago, sin perder de vista lo importante.</p>
        </div>
        <div class="vp-benefits">
            <article>
                <i class="bi bi-upc-scan"></i>
                <h3>Verificá sin complicaciones</h3>
                <p>Consultá los movimientos recientes para comprobar si una transferencia se acreditó.</p>
                <span>Menos tareas repetitivas <i class="bi bi-arrow-up-right"></i></span>
            </article>
            <article>
                <i class="bi bi-activity"></i>
                <h3>Enterate con claridad</h3>
                <p>Revisá el estado de los pagos recibidos y reducí el riesgo de aceptar pagos no acreditados.</p>
                <span>Más visibilidad para tu equipo <i class="bi bi-arrow-up-right"></i></span>
            </article>
            <article>
                <i class="bi bi-layers"></i>
                <h3>Todo bajo una misma mirada</h3>
                <p>Un punto de referencia para mantener el seguimiento de tu operación en cuestión de segundos.</p>
                <span>Más control para tu negocio <i class="bi bi-arrow-up-right"></i></span>
            </article>
        </div>
    </section>

    <section id="como-funciona" class="vp-process">
        <div class="vp-rail vp-process-layout">
            <div>
                <span class="vp-eyebrow vp-dark-eyebrow">02 / ASÍ DE SIMPLE</span>
                <h2>Un pago.<br>Un estado claro.<br><em>Un paso adelante.</em></h2>
                <p>Del movimiento a la información que necesitás.<br>Sin vueltas innecesarias.</p>
                <a href="<?= site_url('contacto') ?>" class="vp-text-link vp-dark-link">Quiero conocer VerificaPay <i class="bi bi-arrow-up-right"></i></a>
            </div>
            <div class="vp-steps">
                <article><span>01</span><div><h3>Recibís un pago</h3><p>Tu cliente realiza una transferencia.</p></div></article>
                <article><span>02</span><div><h3>Consultás el movimiento</h3><p>Revisás si la transferencia aparece entre los últimos movimientos de la cuenta.</p></div></article>
                <article><span>03</span><div><h3>Continuás con confianza</h3><p>Con el estado del pago claro, podés seguir con lo que realmente importa.</p></div></article>
                <p class="vp-development-note">Producto en desarrollo. Las funcionalidades e integraciones se comunicarán antes del lanzamiento.</p>
            </div>
        </div>
    </section>

    <section id="contacto" class="vp-contact vp-rail">
        <div class="vp-contact-panel">
            <div class="vp-contact-copy">
                <span class="vp-eyebrow">03 / EMPEZÁ CON VERIFICAPAY</span>
                <h2>Llevá la verificación<br>de pagos a<br><em>tu negocio.</em></h2>
                <p>Conocé cómo VerificaPay puede ayudar a tu equipo a consultar pagos con un acceso pensado para solo lectura.</p>
                <span class="vp-contact-promise"><i class="bi bi-shield-check"></i> Sin permisos para transferir ni mover dinero.</span>
            </div>
            <div class="vp-contact-card">
                <span class="vp-contact-icon"><i class="bi bi-envelope-paper"></i></span>
                <h3>Hablemos de tu negocio.</h3>
                <p>Dejanos tus datos y nuestro equipo se pondrá en contacto para contarte más sobre VerificaPay.</p>
                <a class="vp-button vp-button-forest" href="<?= site_url('contacto') ?>">
                    Completar formulario <i class="bi bi-arrow-up-right"></i>
                </a>
                <small>Nombre · negocio · email · teléfono</small>
            </div>
        </div>
    </section>
</main>
