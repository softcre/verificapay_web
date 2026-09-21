<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        <?= isset($title) ? html_escape($title) : 'Admin Panel' ?>
    </title>

    <link rel="icon"
          href="<?= adminlte_asset('img/favicon.png') ?>">

    <link rel="stylesheet"
          href="<?= adminlte_asset('css/adminlte.min.css') ?>">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">