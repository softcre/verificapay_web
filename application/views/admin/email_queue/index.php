<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$statuses = ['pending' => 'Pendiente', 'sending' => 'En proceso', 'sent' => 'Enviado', 'failed' => 'Fallido'];
$page_url = function ($number) use ($selected_status, $statuses) {
    $query = ['page' => $number];
    if (isset($statuses[$selected_status])) {
        $query['status'] = $selected_status;
    }
    return site_url('admin/email-queue') . '?' . http_build_query($query);
};
?>
<?php if (!empty($flash_message)): ?>
    <div class="alert alert-<?= html_escape($flash_type ?: 'info') ?>"><?= html_escape($flash_message) ?></div>
<?php endif; ?>
<div class="card">
    <div class="card-header">
        <form class="row g-2" method="get" action="<?= site_url('admin/email-queue') ?>">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Todos los estados</option>
                    <?php foreach ($statuses as $value => $label): ?>
                        <option value="<?= html_escape($value) ?>" <?= $selected_status === $value ? 'selected' : '' ?>><?= html_escape($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-primary" type="submit">Filtrar</button></div>
            <div class="col-auto"><a class="btn btn-outline-secondary" href="<?= site_url('admin/email-queue') ?>">Limpiar</a></div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>ID / estado</th><th>Destinatario</th><th>Solicitud</th><th>Intentos</th><th>Fechas</th><th></th></tr></thead>
            <tbody>
            <?php if (!$emails): ?><tr><td colspan="6" class="text-center text-body-secondary py-4">No hay correos para mostrar.</td></tr><?php endif; ?>
            <?php foreach ($emails as $email): ?>
                <tr>
                    <td>#<?= (int) $email->id_email_outbox ?><br><span class="badge text-bg-<?= $email->status === 'failed' ? 'danger' : ($email->status === 'sent' ? 'success' : ($email->status === 'sending' ? 'info' : 'warning')) ?>"><?= html_escape(isset($statuses[$email->status]) ? $statuses[$email->status] : $email->status) ?></span></td>
                    <td><?= html_escape($email->recipient) ?><br><small><?= html_escape($email->subject) ?></small></td>
                    <td><?php if ($email->contact_request_id): ?><a href="<?= site_url('admin/leads/' . (int) $email->contact_request_id) ?>">#<?= (int) $email->contact_request_id ?> · <?= html_escape($email->full_name ?: 'Solicitud') ?></a><br><small><?= html_escape($email->contact_email ?: '') ?></small><?php else: ?>—<?php endif; ?></td>
                    <td><?= (int) $email->attempts ?></td>
                    <td><small>Creado: <?= html_escape($email->created_at) ?><br>Disponible: <?= html_escape($email->available_at) ?><?php if ($email->sent_at): ?><br>Enviado: <?= html_escape($email->sent_at) ?><?php endif; ?></small><?php if ($email->status === 'failed' && $email->last_error): ?><br><small class="text-danger"><?= html_escape($email->last_error) ?></small><?php endif; ?></td>
                    <td>
                        <?php if ($email->status === 'failed'): ?>
                            <?= form_open('admin/email-queue/' . (int) $email->id_email_outbox . '/retry', ['class' => 'd-inline']) ?>
                                <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('¿Volver a poner este correo en la cola?')"><i class="bi bi-arrow-clockwise"></i> Reintentar</button>
                            <?= form_close() ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span><?= (int) $total ?> correo(s)</span>
        <div class="btn-group">
            <?php if ($page > 1): ?><a class="btn btn-sm btn-outline-secondary" href="<?= html_escape($page_url($page - 1)) ?>">Anterior</a><?php endif; ?>
            <?php if ($page * $per_page < $total): ?><a class="btn btn-sm btn-outline-secondary" href="<?= html_escape($page_url($page + 1)) ?>">Siguiente</a><?php endif; ?>
        </div>
    </div>
</div>
