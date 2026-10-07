<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($title) ?></title>
    <link rel="stylesheet" href="<?= adminlte_asset('css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-body-tertiary">
    <main class="container py-5">
        <div class="card mx-auto" style="max-width: 640px">
            <div class="card-header"><h1 class="h4 mb-0">Migraciones de base de datos</h1></div>
            <div class="card-body">
                <p>Esta acción aplica las migraciones pendientes de la base de datos. Ejecutala solo cuando estés actualizando el proyecto.</p>
                <?= form_open('migrate') ?>
                    <button class="btn btn-primary" type="submit" onclick="return confirm('¿Aplicar las migraciones pendientes?')">
                        <i class="bi bi-database-gear"></i> Aplicar migraciones
                    </button>
                    <a class="btn btn-outline-secondary" href="<?= site_url('admin') ?>">Cancelar</a>
                <?= form_close() ?>
            </div>
        </div>
    </main>
</body>
</html>
