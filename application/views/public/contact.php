<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$form_values = isset($form_values) && is_array($form_values) ? $form_values : [];
$form_errors = isset($form_errors) && is_array($form_errors) ? $form_errors : [];
?>

<main id="hero" class="vp-main vp-contact-page">
    <section class="vp-contact vp-rail">
        <div class="vp-contact-panel">
            <div class="vp-contact-copy">
                <span class="vp-eyebrow">CONTACTO / HABLEMOS</span>
                <h1>Conversemos sobre<br>tu negocio y<br><em>VerificaPay.</em></h1>
                <p>Completá tus datos y nuestro equipo se pondrá en contacto para contarte más sobre el servicio.</p>
                <span class="vp-contact-promise"><i class="bi bi-shield-check"></i> Tus datos se usarán para responder tu consulta.</span>
                <a href="<?= site_url('/') ?>" class="vp-contact-back"><i class="bi bi-arrow-left"></i> Volver al inicio</a>
            </div>

            <div class="vp-form-panel">
                <?php if (!empty($form_success)): ?>
                    <div class="vp-form-success" role="status">
                        <span><i class="bi bi-check2-circle"></i></span>
                        <h2>Solicitud recibida.</h2>
                        <p><?= html_escape($form_success) ?></p>
                        <a class="vp-button vp-button-forest" href="<?= site_url('/') ?>">Volver al inicio</a>
                    </div>
                <?php else: ?>
                    <h2>Dejanos tus datos.</h2>
                    <p class="vp-form-intro">Todos los campos son obligatorios.</p>

                    <?php if (!empty($form_error)): ?>
                        <div class="vp-form-alert" role="alert"><?= html_escape($form_error) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($form_errors)): ?>
                        <div class="vp-form-alert" role="alert">
                            Revisá los datos del formulario:
                            <ul>
                                <?php foreach ($form_errors as $field => $message): ?>
                                    <?php if ($message !== ''): ?>
                                        <li><?= html_escape($message) ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?= form_open('contacto/enviar', ['class' => 'vp-contact-form', 'id' => 'contact-form']) ?>
                        <div class="vp-form-field">
                            <label for="full_name">Nombre y apellido <span>*</span></label>
                            <input
                                id="full_name"
                                name="full_name"
                                type="text"
                                value="<?= html_escape(isset($form_values['full_name']) ? $form_values['full_name'] : '') ?>"
                                placeholder="Tu nombre completo"
                                autocomplete="name"
                                minlength="2"
                                maxlength="160"
                                required
                                aria-invalid="<?= !empty($form_errors['full_name']) ? 'true' : 'false' ?>"
                            >
                            <?php if (!empty($form_errors['full_name'])): ?>
                                <small class="vp-field-error"><?= html_escape($form_errors['full_name']) ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="vp-form-field">
                            <label for="business_name">Nombre del negocio o empresa <span>*</span></label>
                            <input
                                id="business_name"
                                name="business_name"
                                type="text"
                                value="<?= html_escape(isset($form_values['business_name']) ? $form_values['business_name'] : '') ?>"
                                placeholder="Tu comercio o empresa"
                                autocomplete="organization"
                                minlength="2"
                                maxlength="160"
                                required
                                aria-invalid="<?= !empty($form_errors['business_name']) ? 'true' : 'false' ?>"
                            >
                            <?php if (!empty($form_errors['business_name'])): ?>
                                <small class="vp-field-error"><?= html_escape($form_errors['business_name']) ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="vp-form-field">
                            <label for="email">Correo electrónico <span>*</span></label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="<?= html_escape(isset($form_values['email']) ? $form_values['email'] : '') ?>"
                                placeholder="tu@empresa.com"
                                autocomplete="email"
                                maxlength="254"
                                required
                                aria-invalid="<?= !empty($form_errors['email']) ? 'true' : 'false' ?>"
                            >
                            <?php if (!empty($form_errors['email'])): ?>
                                <small class="vp-field-error"><?= html_escape($form_errors['email']) ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="vp-form-field">
                            <label for="phone">Celular o número de contacto <span>*</span></label>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                value="<?= html_escape(isset($form_values['phone']) ? $form_values['phone'] : '') ?>"
                                placeholder="Ej.: +54 9 11 1234-5678"
                                autocomplete="tel"
                                minlength="6"
                                maxlength="30"
                                required
                                aria-invalid="<?= !empty($form_errors['phone']) ? 'true' : 'false' ?>"
                            >
                            <?php if (!empty($form_errors['phone'])): ?>
                                <small class="vp-field-error"><?= html_escape($form_errors['phone']) ?></small>
                            <?php endif; ?>
                        </div>

                        <button class="vp-button vp-button-forest" type="submit">
                            Enviar mis datos <i class="bi bi-arrow-up-right"></i>
                        </button>
                        <small class="vp-form-note">Nos comunicaremos con vos para responder tu consulta.</small>
                    <?= form_close() ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
