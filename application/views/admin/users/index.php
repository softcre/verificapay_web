<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (!empty($flash_message)): ?>
    <div class="alert alert-<?= html_escape($flash_type ?: 'info') ?>"><?= nl2br(html_escape($flash_message)) ?></div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Cuentas existentes</h3></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Usuario</th><th>Rol</th><th>Estado</th><th>Creado</th><th>Actualizar acceso</th></tr></thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><strong><?= html_escape(trim($user->nombre . ' ' . $user->apellido)) ?></strong><br><small><?= html_escape($user->email) ?></small></td>
                            <td><?= html_escape($user->tipo_usuario ?: 'Sin rol') ?></td>
                            <td><span class="badge text-bg-<?= (int) $user->activo === 1 ? 'success' : 'secondary' ?>"><?= (int) $user->activo === 1 ? 'Activo' : 'Desactivado' ?></span></td>
                            <td><?= html_escape($user->created_at ?: '—') ?></td>
                            <td>
                                <?= form_open('admin/users/' . (int) $user->id_usuario . '/update', ['class' => 'd-flex gap-2 align-items-center']) ?>
                                    <select class="form-select form-select-sm" name="usuario_tipo_id" aria-label="Rol">
                                        <option value="1" <?= (int) $user->usuario_tipo_id === 1 ? 'selected' : '' ?>>Administrador</option>
                                        <option value="2" <?= (int) $user->usuario_tipo_id === 2 ? 'selected' : '' ?>>Usuario</option>
                                    </select>
                                    <select class="form-select form-select-sm" name="activo" aria-label="Estado">
                                        <option value="1" <?= (int) $user->activo === 1 ? 'selected' : '' ?>>Activo</option>
                                        <option value="0" <?= (int) $user->activo !== 1 ? 'selected' : '' ?>>Desactivado</option>
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary" type="submit">Guardar</button>
                                <?= form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title">Crear cuenta</h3></div>
            <div class="card-body">
                <?= form_open('admin/users/create') ?>
                    <div class="mb-3"><label class="form-label" for="nombre">Nombre</label><input class="form-control" id="nombre" name="nombre" maxlength="100" required></div>
                    <div class="mb-3"><label class="form-label" for="apellido">Apellido</label><input class="form-control" id="apellido" name="apellido" maxlength="100"></div>
                    <div class="mb-3"><label class="form-label" for="email">Correo electrónico</label><input class="form-control" type="email" id="email" name="email" maxlength="150" required></div>
                    <div class="mb-3"><label class="form-label" for="password">Contraseña temporal</label><input class="form-control" type="password" id="password" name="password" minlength="12" maxlength="72" autocomplete="new-password" required><div class="form-text">Mínimo 12 caracteres. Comparte la contraseña por un canal seguro.</div></div>
                    <div class="mb-3"><label class="form-label" for="usuario_tipo_id">Rol</label><select class="form-select" id="usuario_tipo_id" name="usuario_tipo_id"><option value="2">Usuario</option><option value="1">Administrador</option></select></div>
                    <button class="btn btn-primary w-100" type="submit">Crear cuenta</button>
                <?= form_close() ?>
            </div>
        </div>
        <div class="alert alert-info"><i class="bi bi-shield-lock"></i> El acceso administrativo está limitado a cuentas con rol Administrador. Siempre debe quedar un administrador activo.</div>
    </div>
</div>
