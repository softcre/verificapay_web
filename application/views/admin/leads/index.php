<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$query = ['q' => $search, 'status' => $selected_status];
$page_url = function ($number) use ($query) {
    $params = array_filter(array_merge($query, ['page' => $number]), function ($value) {
        return $value !== '';
    });
    return site_url('admin/leads') . '?' . http_build_query($params);
};
?>
<?php if (!empty($flash_message)): ?>
    <div class="alert alert-<?= html_escape($flash_type ?: 'info') ?>"><?= html_escape($flash_message) ?></div>
<?php endif; ?>
<div class="card">
    <div class="card-header">
        <form class="row g-2" method="get" action="<?= site_url('admin/leads') ?>">
            <div class="col-md-5"><input class="form-control" name="q" value="<?= html_escape($search) ?>" placeholder="Buscar nombre, negocio, correo o teléfono"></div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">Todos los estados</option>
                    <?php foreach ($statuses as $value => $label): ?>
                        <option value="<?= html_escape($value) ?>" <?= $selected_status === $value ? 'selected' : '' ?>><?= html_escape($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button></div>
            <div class="col-auto"><a class="btn btn-outline-secondary" href="<?= site_url('admin/leads') ?>">Limpiar</a></div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Persona / negocio</th><th>Contacto</th><th>Estado</th><th>Recibida</th><th></th></tr></thead>
            <tbody>
            <?php if (!$leads): ?>
                <tr><td colspan="5" class="text-center text-body-secondary py-4">No se encontraron solicitudes.</td></tr>
            <?php endif; ?>
            <?php foreach ($leads as $lead): ?>
                <tr>
                    <td><strong><?= html_escape($lead->full_name) ?></strong><br><small class="text-body-secondary"><?= html_escape($lead->business_name) ?></small></td>
                    <td><a href="mailto:<?= html_escape($lead->email) ?>"><?= html_escape($lead->email) ?></a><br><?= html_escape($lead->phone) ?></td>
                    <td><?= html_escape(isset($statuses[$lead->status]) ? $statuses[$lead->status] : $lead->status) ?></td>
                    <td><?= html_escape($lead->created_at) ?></td>
                    <td><a class="btn btn-sm btn-outline-primary" href="<?= site_url('admin/leads/' . (int) $lead->id_contact_request) ?>">Ver solicitud</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span><?= (int) $total ?> solicitud(es)</span>
        <div class="btn-group">
            <?php if ($page > 1): ?><a class="btn btn-sm btn-outline-secondary" href="<?= html_escape($page_url($page - 1)) ?>">Anterior</a><?php endif; ?>
            <?php if ($page * $per_page < $total): ?><a class="btn btn-sm btn-outline-secondary" href="<?= html_escape($page_url($page + 1)) ?>">Siguiente</a><?php endif; ?>
        </div>
    </div>
</div>
