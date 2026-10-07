<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$uri = isset($current_uri) ? trim($current_uri, '/') : '';
$active = function ($prefix) use ($uri) {
    return $uri === trim($prefix, '/') || strpos($uri, trim($prefix, '/') . '/') === 0
        ? ' active'
        : '';
};
$dashboard_active = in_array($uri, ['admin', 'admin/dashboard'], TRUE) ? ' active' : '';
?>
<aside class="app-sidebar shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= site_url('admin') ?>" class="brand-link vp-admin-brand" aria-label="VerificaPay, panel de administración">
            <img src="<?= base_url('assets/arsha/img/hero-img-sinfondo.png') ?>"
                 alt="VerificaPay"
                 class="vp-admin-brand-logo">
            <span class="vp-admin-brand-label">Panel de administración</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                <li class="nav-item">
                    <a href="<?= site_url('admin') ?>" class="nav-link<?= $dashboard_active ?>">
                        <i class="nav-icon bi bi-speedometer2"></i><p>Resumen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/leads') ?>" class="nav-link<?= $active('admin/leads') ?>">
                        <i class="nav-icon bi bi-person-lines-fill"></i><p>Solicitudes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/email-queue') ?>" class="nav-link<?= $active('admin/email-queue') ?>">
                        <i class="nav-icon bi bi-envelope-check"></i><p>Cola de correo</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/users') ?>" class="nav-link<?= $active('admin/users') ?>">
                        <i class="nav-icon bi bi-people"></i><p>Usuarios y accesos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/audit') ?>" class="nav-link<?= $active('admin/audit') ?>">
                        <i class="nav-icon bi bi-clock-history"></i><p>Actividad</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
