<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$cards = [
    ['label' => 'Solicitudes nuevas', 'value' => $summary['new_leads'], 'icon' => 'bi-person-plus', 'color' => 'primary', 'url' => 'admin/leads?status=new'],
    ['label' => 'En seguimiento', 'value' => $summary['follow_up_leads'], 'icon' => 'bi-chat-dots', 'color' => 'info', 'url' => 'admin/leads'],
    ['label' => 'Correos pendientes', 'value' => $summary['pending_emails'], 'icon' => 'bi-envelope', 'color' => 'warning', 'url' => 'admin/email-queue?status=pending'],
    ['label' => 'Correos fallidos', 'value' => $summary['failed_emails'], 'icon' => 'bi-exclamation-circle', 'color' => 'danger', 'url' => 'admin/email-queue?status=failed']
];
?>
<div class="row">
    <?php foreach ($cards as $card): ?>
        <div class="col-xl-3 col-sm-6">
            <a class="text-decoration-none" href="<?= site_url($card['url']) ?>">
                <div class="small-box text-bg-<?= $card['color'] ?>">
                    <div class="inner"><h3><?= number_format((int) $card['value']) ?></h3><p><?= html_escape($card['label']) ?></p></div>
                    <div class="small-box-icon"><i class="bi <?= $card['icon'] ?>"></i></div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Solicitudes recientes</h3><a class="btn btn-sm btn-outline-primary float-end" href="<?= site_url('admin/leads') ?>">Ver todas</a></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Persona / negocio</th><th>Correo</th><th>Estado</th><th>Fecha</th><th></th></tr></thead>
                    <tbody>
                    <?php if (!$recent_leads): ?>
                        <tr><td colspan="5" class="text-center text-body-secondary py-4">Todavía no hay solicitudes.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($recent_leads as $lead): ?>
                        <tr>
                            <td><?= html_escape($lead->full_name) ?><br><small class="text-body-secondary"><?= html_escape($lead->business_name) ?></small></td>
                            <td><?= html_escape($lead->email) ?></td>
                            <td><?= html_escape(ucfirst(str_replace('_', ' ', $lead->status))) ?></td>
                            <td><?= html_escape($lead->created_at) ?></td>
                            <td><a class="btn btn-sm btn-outline-secondary" href="<?= site_url('admin/leads/' . (int) $lead->id_contact_request) ?>">Abrir</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Estado del correo</h3></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2"><span>Pendientes</span><strong><?= (int) $queue_summary['pending'] ?></strong></div>
                <div class="d-flex justify-content-between mb-2"><span>En proceso</span><strong><?= (int) $queue_summary['sending'] ?></strong></div>
                <div class="d-flex justify-content-between mb-2"><span>Enviados</span><strong><?= (int) $queue_summary['sent'] ?></strong></div>
                <div class="d-flex justify-content-between"><span>Fallidos</span><strong><?= (int) $queue_summary['failed'] ?></strong></div>
            </div>
            <div class="card-footer"><a href="<?= site_url('admin/email-queue') ?>">Administrar cola <i class="bi bi-arrow-right"></i></a></div>
        </div>
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <span>Usuarios activos</span><strong class="fs-4"><?= (int) $summary['active_users'] ?></strong>
                <a href="<?= site_url('admin/users') ?>" class="btn btn-sm btn-outline-primary">Gestionar</a>
            </div>
        </div>
    </div>
</div>
