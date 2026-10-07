<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card">
    <div class="card-header"><h3 class="card-title">Últimos cambios realizados desde el panel</h3></div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Fecha</th><th>Administrador</th><th>Acción</th><th>Registro</th><th>Detalle</th></tr></thead>
            <tbody>
            <?php if (!$events): ?><tr><td colspan="5" class="text-center text-body-secondary py-4">Todavía no hay actividad registrada.</td></tr><?php endif; ?>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= html_escape($event->created_at) ?></td>
                    <td><?= html_escape(trim(($event->nombre ?: '') . ' ' . ($event->apellido ?: '')) ?: 'Usuario eliminado') ?></td>
                    <td><?= html_escape($event->action) ?></td>
                    <td>
                        <?php if ($event->entity_type === 'contact_request'): ?>
                            <a href="<?= site_url('admin/leads/' . (int) $event->entity_id) ?>">Solicitud #<?= (int) $event->entity_id ?></a>
                        <?php elseif ($event->entity_type === 'email_outbox'): ?>
                            <a href="<?= site_url('admin/email-queue') ?>">Correo #<?= (int) $event->entity_id ?></a>
                        <?php else: ?>
                            Cuenta #<?= (int) $event->entity_id ?>
                        <?php endif; ?>
                    </td>
                    <td><?= html_escape($event->details ?: '—') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer text-body-secondary">Se muestran hasta 100 eventos. Los datos personales de los contactos no se copian al registro.</div>
</div>
