<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (!empty($flash_message)): ?>
    <div class="alert alert-<?= html_escape($flash_type ?: 'info') ?>"><?= nl2br(html_escape($flash_message)) ?></div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Datos de contacto</h3><a class="btn btn-sm btn-outline-secondary float-end" href="<?= site_url('admin/leads') ?>">Volver al listado</a></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nombre completo</dt><dd class="col-sm-8"><?= html_escape($lead->full_name) ?></dd>
                    <dt class="col-sm-4">Negocio</dt><dd class="col-sm-8"><?= html_escape($lead->business_name) ?></dd>
                    <dt class="col-sm-4">Correo</dt><dd class="col-sm-8"><a href="mailto:<?= html_escape($lead->email) ?>"><?= html_escape($lead->email) ?></a></dd>
                    <dt class="col-sm-4">Teléfono</dt><dd class="col-sm-8"><a href="tel:<?= html_escape($lead->phone) ?>"><?= html_escape($lead->phone) ?></a></dd>
                    <dt class="col-sm-4">Recibida</dt><dd class="col-sm-8"><?= html_escape($lead->created_at) ?></dd>
                    <dt class="col-sm-4">Última actualización</dt><dd class="col-sm-8"><?= html_escape($lead->updated_at ?: 'Sin actualizar') ?></dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3 class="card-title">Historial de cambios</h3></div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Fecha</th><th>Usuario</th><th>Acción</th><th>Detalle</th></tr></thead>
                    <tbody>
                    <?php if (!$history): ?><tr><td colspan="4" class="text-body-secondary text-center py-3">Sin actividad registrada.</td></tr><?php endif; ?>
                    <?php foreach ($history as $event): ?>
                        <tr>
                            <td><?= html_escape($event->created_at) ?></td>
                            <td><?= html_escape(trim(($event->nombre ?: '') . ' ' . ($event->apellido ?: '')) ?: 'Usuario eliminado') ?></td>
                            <td><?= html_escape($event->action) ?></td>
                            <td><?= html_escape($event->details ?: '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title">Seguimiento interno</h3></div>
            <div class="card-body">
                <?= form_open('admin/leads/' . (int) $lead->id_contact_request . '/update') ?>
                    <div class="mb-3">
                        <label class="form-label" for="status">Estado</label>
                        <select class="form-select" id="status" name="status" required>
                            <?php foreach ($statuses as $value => $label): ?>
                                <option value="<?= html_escape($value) ?>" <?= $lead->status === $value ? 'selected' : '' ?>><?= html_escape($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="notes">Notas internas</label>
                        <textarea class="form-control" id="notes" name="notes" rows="7" maxlength="5000" placeholder="No son visibles para el contacto."><?= html_escape($lead->notes ?: '') ?></textarea>
                        <div class="form-text">Máximo 5.000 caracteres. Las notas no se incluyen en el registro de auditoría.</div>
                    </div>
                    <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Guardar cambios</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
