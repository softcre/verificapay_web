<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$environment_value = function ($name, $default = '') {
    $value = getenv($name);
    return $value === FALSE ? $default : $value;
};

$config['protocol'] = 'smtp';
$config['smtp_host'] = $environment_value('VERIFICAPAY_SMTP_HOST');
$config['smtp_user'] = $environment_value('VERIFICAPAY_SMTP_USER');
$config['smtp_pass'] = $environment_value('VERIFICAPAY_SMTP_PASS');
$config['smtp_port'] = (int) $environment_value('VERIFICAPAY_SMTP_PORT', '587');
$config['smtp_crypto'] = strtolower($environment_value('VERIFICAPAY_SMTP_CRYPTO', 'tls'));
$config['smtp_timeout'] = 15;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = TRUE;
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";
$config['mail_from'] = $environment_value('VERIFICAPAY_MAIL_FROM');
$config['mail_from_name'] = $environment_value('VERIFICAPAY_MAIL_FROM_NAME', 'VerificaPay');
$config['contact_email_to'] = $environment_value(
    'VERIFICAPAY_CONTACT_EMAIL_TO',
    'soportesoftcre@gmail.com'
);

$local_config = APPPATH . 'config/email.local.php';
if (is_file($local_config)) {
    include $local_config;
}
