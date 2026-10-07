<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva solicitud de contacto</title>
</head>
<body style="margin:0;padding:24px;background:#f4f8f9;font-family:Arial,sans-serif;color:#0b2342;">
    <div style="max-width:600px;margin:0 auto;padding:28px;background:#ffffff;border:1px solid #dce5ea;border-radius:12px;">
        <p style="margin:0 0 8px;color:#0e9d8e;font-size:12px;font-weight:bold;letter-spacing:1px;">VERIFICAPAY / CONTACTO</p>
        <h1 style="margin:0 0 20px;font-size:24px;">Nueva solicitud de contacto</h1>
        <p style="margin:0 0 20px;color:#5d6b78;line-height:1.6;">Una persona completó el formulario del sitio web.</p>
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
            <tr>
                <th style="width:165px;padding:12px 0;border-top:1px solid #e6edef;text-align:left;">Nombre y apellido</th>
                <td style="padding:12px 0;border-top:1px solid #e6edef;"><?= html_escape($full_name) ?></td>
            </tr>
            <tr>
                <th style="padding:12px 0;border-top:1px solid #e6edef;text-align:left;">Negocio</th>
                <td style="padding:12px 0;border-top:1px solid #e6edef;"><?= html_escape($business_name) ?></td>
            </tr>
            <tr>
                <th style="padding:12px 0;border-top:1px solid #e6edef;text-align:left;">Correo</th>
                <td style="padding:12px 0;border-top:1px solid #e6edef;"><a href="mailto:<?= html_escape($email) ?>" style="color:#0b7d72;"><?= html_escape($email) ?></a></td>
            </tr>
            <tr>
                <th style="padding:12px 0;border-top:1px solid #e6edef;text-align:left;">Teléfono</th>
                <td style="padding:12px 0;border-top:1px solid #e6edef;"><?= html_escape($phone) ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
