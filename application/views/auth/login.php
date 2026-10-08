<?php

defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        <?= isset($title) ? html_escape($title) : 'Acceso' ?>
        | VerificaPay
    </title>

    <link rel="icon"
          type="image/png"
          href="<?= base_url('assets/arsha/img/favicon-vp.png?v=1') ?>">

    <!-- AdminLTE -->

    <link rel="stylesheet"
          href="<?= adminlte_asset('css/adminlte.min.css') ?>">


    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --vp-blue: #012549;
            --vp-green: #00b8a4;
            --vp-green-dark: #008f82;
            --vp-ink: #18324b;
            --vp-muted: #617589;
            --vp-border: #dce5ed;
            --bs-primary: var(--vp-blue);
            --bs-primary-rgb: 1, 37, 73;
            --bs-link-color: var(--vp-blue);
            --bs-link-hover-color: var(--vp-green-dark);
            --bs-btn-primary-bg: var(--vp-blue);
            --bs-btn-primary-border-color: var(--vp-blue);
            --bs-btn-primary-hover-bg: #021d37;
            --bs-btn-primary-hover-border-color: #021d37;
        }

        body {
            min-height: 100vh;
            color: var(--vp-ink);
            background:
                radial-gradient(ellipse at 12% 10%, rgba(0, 184, 164, 0.11), transparent 34rem),
                linear-gradient(145deg, #eef4f8 0%, #f7fafc 55%, #e8f0f5 100%);
        }

        .login-box {
            width: min(100% - 2rem, 440px);
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .login-box .card {
            overflow: hidden;
            border: 1px solid rgba(1, 37, 73, 0.09);
            border-top: 4px solid var(--vp-green);
            border-radius: 1rem;
            background-color: #ffffff;
            box-shadow: 0 1.25rem 3.5rem rgba(1, 37, 73, 0.13);
        }

        .login-brand {
            padding: 2rem 1.5rem 1.5rem;
            border-bottom: 1px solid #edf2f6;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdfe 100%);
        }

        .login-brand img {
            display: block;
            width: min(100%, 250px);
            height: auto;
            margin: 0 auto 0.75rem;
        }

        .login-brand p {
            margin: 0;
            color: var(--vp-muted);
            font-size: 0.92rem;
        }

        .login-box-msg {
            padding: 0.25rem 0 1.25rem;
            color: var(--vp-blue);
            font-size: 1.2rem;
            font-weight: 700;
        }

        .login-box .card-body {
            padding: 1.75rem 2rem 2rem;
        }

        .login-box .input-group {
            margin-bottom: 1rem !important;
        }

        .login-box .form-control,
        .login-box .input-group-text {
            min-height: 3rem;
            color: var(--vp-blue) !important;
            border-color: #cbd8e3;
            background-color: #ffffff;
        }

        .login-box .form-control {
            font-weight: 500;
            caret-color: var(--vp-green-dark);
        }

        .login-box .input-group:focus-within .form-control,
        .login-box .input-group:focus-within .input-group-text {
            border-color: var(--vp-green);
            box-shadow: 0 0 0 0.15rem rgba(0, 184, 164, 0.15);
        }

        .login-box .input-group-text {
            color: var(--vp-muted);
            border-left: 0;
        }

        .login-box .form-control:focus {
            color: var(--vp-blue) !important;
            border-color: var(--vp-green);
            box-shadow: none;
        }

        .login-box .form-control::placeholder {
            color: #52677a;
            opacity: 1;
        }

        .login-box .form-control:-webkit-autofill,
        .login-box .form-control:-webkit-autofill:hover,
        .login-box .form-control:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--vp-blue);
            box-shadow: 0 0 0 1000px #ffffff inset;
        }

        .login-box .btn-primary {
            min-height: 3rem;
            border: 0;
            border-radius: 0.55rem;
            background-color: var(--vp-blue);
            font-weight: 600;
            letter-spacing: 0.01em;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .login-box .btn-primary:hover,
        .login-box .btn-primary:focus,
        .login-box .btn-primary:active {
            background-color: var(--vp-green-dark);
            color: #ffffff;
        }

        .login-box .btn-primary:hover {
            transform: translateY(-1px);
        }

        .login-back-link {
            color: var(--vp-muted);
            font-size: 0.92rem;
        }

        a {
            color: var(--vp-blue);
        }

        a:hover,
        a:focus {
            color: var(--vp-green-dark);
        }

        @media (max-width: 480px) {
            .login-box .card-body {
                padding: 1.5rem;
            }

            .login-brand {
                padding-top: 1.75rem;
            }
        }
    </style>

</head>


<body class="login-page bg-body-secondary">


<div class="login-box">

    <div class="card">


        <!-- Logo -->

        <div class="login-brand text-center">

            <a href="<?= site_url('/') ?>"
               aria-label="VerificaPay, inicio">
                <img src="<?= base_url('assets/arsha/img/hero-img-sinfondo.png') ?>"
                     alt="VerificaPay"
                     width="250"
                     height="150">
            </a>
            <p>Claridad y confianza para tu negocio.</p>
        </div>


        <div class="card-body">


            <p class="login-box-msg">
                Iniciar sesión
            </p>


            <!-- Login form -->

            <form id="form-login"
                  method="post"
                  autocomplete="off">

                <input type="hidden"
                       name="<?= html_escape($csrf_name) ?>"
                       value="<?= html_escape($csrf_hash) ?>">

                <!-- Email -->

                <div class="input-group mb-3">

                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control"
                           placeholder="E-mail"
                           autocomplete="username">

                    <div class="input-group-text">

                        <i class="bi bi-envelope"></i>

                    </div>

                </div>


                <!-- Password -->

                <div class="input-group mb-3">

                    <input type="password"
                           name="pass"
                           id="pass"
                           class="form-control"
                           placeholder="Contraseña"
                           autocomplete="current-password">

                    <div class="input-group-text">

                        <i class="bi bi-lock"></i>

                    </div>

                </div>


                <!-- Error -->

                <div id="login-error"
                     class="alert alert-danger d-none"
                     role="alert">
                </div>


                <!-- Button -->

                <div class="row">

                    <div class="col-12">

                        <button type="submit"
                                id="btn-login"
                                class="btn btn-primary w-100">

                            <span id="btn-login-text">
                                Ingresar
                            </span>

                            <span id="btn-login-loading"
                                  class="d-none">

                                <span class="spinner-border spinner-border-sm me-1"
                                      role="status"
                                      aria-hidden="true">
                                </span>

                                Ingresando...

                            </span>

                        </button>

                    </div>

                </div>


            </form>


            <div class="text-center mt-4">

                <a href="<?= site_url('/') ?>"
                   class="login-back-link text-decoration-none">
                    Volver al sitio
                </a>

            </div>


        </div>

    </div>

</div>


<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- AdminLTE -->

<script src="<?= adminlte_asset('js/adminlte.min.js') ?>"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-login');

    if (!form) {
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const button = document.getElementById('btn-login');
        const text = document.getElementById('btn-login-text');
        const loading = document.getElementById('btn-login-loading');
        const error = document.getElementById('login-error');

        error.classList.add('d-none');
        error.innerHTML = '';

        button.disabled = true;
        text.classList.add('d-none');
        loading.classList.remove('d-none');

        const formData = new FormData(form);

        fetch('<?= site_url('login/auth') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async function (response) {
            const contentType = response.headers.get('content-type') || '';
            const isJson = contentType.includes('application/json');
            const data = isJson ? await response.json() : null;

            if (data && data.status === 'success') {
                window.location.href = data.url;
                return;
            }

            let message = (data && data.message) || 'No se pudo iniciar sesión.';

            if (data && data.errors) {
                message = Object.values(data.errors).join('<br>');
            }

            if (!message) {
                message = 'No se pudo iniciar sesión.';
            }

            error.innerHTML = message;
            error.classList.remove('d-none');

            button.disabled = false;
            text.classList.remove('d-none');
            loading.classList.add('d-none');
        })
        .catch(function (xhr) {
            console.error(xhr);
            error.innerHTML = 'Se produjo un error al intentar iniciar sesión.';
            error.classList.remove('d-none');

            button.disabled = false;
            text.classList.remove('d-none');
            loading.classList.add('d-none');
        });
    });
});
</script>


</body>

</html>