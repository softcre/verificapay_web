<!DOCTYPE html>
<html lang="es">

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
            --vp-green-dark: #007f74;
            --vp-ink: #18324b;
            --vp-muted: #5d7185;
            --vp-canvas: #f2f6fa;
            --vp-border: #dce5ed;
            --bs-primary: var(--vp-blue);
            --bs-primary-rgb: 1, 37, 73;
            --bs-link-color: var(--vp-blue);
            --bs-link-hover-color: var(--vp-green);
            --bs-body-color: var(--vp-ink);
            --bs-body-bg: var(--vp-canvas);
            --bs-btn-primary-bg: var(--vp-blue);
            --bs-btn-primary-border-color: var(--vp-blue);
            --bs-btn-primary-hover-bg: #021d37;
            --bs-btn-primary-hover-border-color: #021d37;
            --bs-success: var(--vp-green-dark);
        }

        body,
        .app-wrapper,
        .app-main,
        .app-content-header,
        .app-content {
            color: var(--vp-ink);
            background-color: var(--vp-canvas) !important;
        }

        .app-header,
        .main-header,
        .app-header.navbar,
        .brand-link,
        .brand-text {
            background-color: var(--vp-blue) !important;
            color: #ffffff !important;
        }

        .app-header .nav-link,
        .app-header .text-body-secondary {
            color: #ffffff !important;
        }

        .app-sidebar,
        .app-sidebar .sidebar-wrapper,
        .app-sidebar .sidebar-brand,
        .app-sidebar .nav-sidebar,
        .app-sidebar .nav-item {
            background-color: var(--vp-blue) !important;
        }

        .app-sidebar .sidebar-brand .vp-admin-brand {
            display: flex;
            min-height: 88px;
            flex-direction: column;
            justify-content: center;
            gap: 0.25rem;
            padding: 0.5rem 0.75rem !important;
            background-color: #ffffff !important;
            text-align: center;
        }

        .app-sidebar .vp-admin-brand-logo {
            display: block;
            width: min(100%, 132px);
            height: 60px;
            margin: 0 auto;
            object-fit: contain;
        }

        .app-sidebar .vp-admin-brand-label {
            color: var(--vp-blue);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .app-sidebar .nav-link,
        .app-sidebar .nav-link p,
        .app-sidebar .nav-link .nav-icon {
            color: #e4edf6 !important;
        }

        .app-sidebar .nav-link:hover {
            background-color: #123b60 !important;
            color: #ffffff !important;
        }

        .app-sidebar .nav-link.active {
            background-color: var(--vp-green) !important;
            color: var(--vp-blue) !important;
        }

        .app-sidebar .nav-link.active p,
        .app-sidebar .nav-link.active .nav-icon {
            color: var(--vp-blue) !important;
        }

        .card,
        .card-header,
        .card-body,
        .card-footer {
            color: var(--vp-ink);
            background-color: #ffffff;
        }

        .card {
            border: 1px solid var(--vp-border);
            box-shadow: 0 2px 10px rgba(1, 37, 73, 0.05);
        }

        .card-header,
        .card-footer {
            border-color: var(--vp-border);
        }

        .card-title,
        .app-content-header h1,
        .app-content-header h2,
        .app-content-header h3,
        .app-content-header h4,
        .app-content-header h5 {
            color: var(--vp-blue);
        }

        .table {
            --bs-table-color: var(--vp-ink);
            --bs-table-bg: #ffffff;
            --bs-table-border-color: var(--vp-border);
            --bs-table-hover-color: var(--vp-ink);
            --bs-table-hover-bg: #f3f8fb;
        }

        .text-body-secondary,
        .form-text {
            color: var(--vp-muted) !important;
        }

        .form-control,
        .form-select {
            color: var(--vp-ink);
            background-color: #ffffff;
            border-color: #cbd8e3;
        }

        .form-control::placeholder {
            color: #77899a;
            opacity: 1;
        }

        .form-control:focus,
        .form-select:focus {
            color: var(--vp-ink);
            background-color: #ffffff;
            border-color: var(--vp-green);
            box-shadow: 0 0 0 0.2rem rgba(0, 184, 164, 0.18);
        }

        .app-footer {
            color: var(--vp-muted);
            background-color: #ffffff;
            border-top: 1px solid var(--vp-border);
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
            background-color: var(--vp-green-dark) !important;
            border-color: var(--vp-green-dark) !important;
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