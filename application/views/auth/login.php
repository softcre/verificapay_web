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


    <!-- AdminLTE -->

    <link rel="stylesheet"
          href="<?= adminlte_asset('css/adminlte.min.css') ?>">


    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>


<body class="login-page bg-body-secondary">


<div class="login-box">

    <div class="card card-outline card-primary">


        <!-- Logo -->

        <div class="card-header text-center">

            <a href="<?= site_url('/') ?>"
               class="h1 text-decoration-none">

                <b>Verifica</b>Pay

            </a>

        </div>


        <div class="card-body">


            <p class="login-box-msg">
                Iniciar sesión
            </p>


            <!-- Login form -->

            <form id="form-login"
                  method="post"
                  autocomplete="off">


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

                <a href="<?= site_url('/') ?>">
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