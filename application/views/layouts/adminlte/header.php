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

    <style>
        :root {
            --vp-blue: #012549;
            --vp-green: #00b8a4;
            --bs-primary: var(--vp-blue);
            --bs-primary-rgb: 1, 37, 73;
            --bs-link-color: var(--vp-blue);
            --bs-link-hover-color: var(--vp-green);
            --bs-btn-primary-bg: var(--vp-blue);
            --bs-btn-primary-border-color: var(--vp-blue);
            --bs-btn-primary-hover-bg: #021d37;
            --bs-btn-primary-hover-border-color: #021d37;
            --bs-success: var(--vp-green);
        }

        body,
        .content-wrapper,
        .app-content,
        .card,
        .card-body,
        .main-sidebar,
        .sidebar {
            background-color: #ffffff;
        }

        .app-header,
        .main-header,
        .navbar,
        .sidebar-dark-primary,
        .main-sidebar,
        .brand-link,
        .brand-text {
            background-color: var(--vp-blue) !important;
            color: #ffffff !important;
        }

        .btn-primary,
        .bg-primary,
        .text-bg-primary,
        .card-primary > .card-header,
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link,
        .page-item.active .page-link,
        .page-link.active {
            background-color: var(--vp-blue) !important;
            border-color: var(--vp-blue) !important;
            color: #ffffff !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:not(:disabled):not(.disabled):active,
        .btn-primary:not(:disabled):not(.disabled):focus {
            background-color: var(--vp-green) !important;
            border-color: var(--vp-green) !important;
            color: #ffffff !important;
        }

        .nav-sidebar .nav-link.active,
        .nav-sidebar > .nav-item > .nav-link.active {
            background-color: var(--vp-green) !important;
            color: #ffffff !important;
        }

        a {
            color: var(--vp-blue);
        }

        a:hover,
        a:focus {
            color: var(--vp-green);
        }
    </style>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">