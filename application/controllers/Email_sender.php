<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Email_outbox_model $email_outbox
 * @property CI_Email $email
 * @property CI_Config $config
 */
class Email_sender extends CI_Controller
{
    private $email_config;

    public function __construct()
    {
        parent::__construct();
        $this->config->load('email', TRUE);
        $this->email_config = $this->config->item('email');
        $this->load->model('Email_outbox_model', 'email_outbox');
    }

    public function send_emails()
    {
        if (!is_cli()) {
            show_404();
            return;
        }

        $required = [
            'smtp_host' => 'VERIFICAPAY_SMTP_HOST',
            'smtp_user' => 'VERIFICAPAY_SMTP_USER',
            'smtp_pass' => 'VERIFICAPAY_SMTP_PASS',
            'mail_from' => 'VERIFICAPAY_MAIL_FROM'
        ];
        $missing = [];

        foreach ($required as $key => $environment_name) {
            if (empty($this->email_config[$key])) {
                $missing[] = $environment_name;
            }
        }

        if (!in_array($this->email_config['smtp_crypto'], ['ssl', 'tls'], TRUE)) {
            $missing[] = 'VERIFICAPAY_SMTP_CRYPTO (ssl or tls)';
        }

        if ($this->email_config['smtp_port'] < 1 || $this->email_config['smtp_port'] > 65535) {
            $missing[] = 'VERIFICAPAY_SMTP_PORT';
        }

        if (
            !empty($this->email_config['mail_from']) &&
            !filter_var($this->email_config['mail_from'], FILTER_VALIDATE_EMAIL)
        ) {
            $missing[] = 'VERIFICAPAY_MAIL_FROM (valid email address)';
        }

        if ($missing) {
            fwrite(STDERR, 'Email sender configuration is incomplete: ' . implode(', ', $missing) . PHP_EOL);
            exit(1);
        }

        $this->load->library('email', $this->email_library_config());

        $sent = 0;
        $failed = 0;
        $batch_size = 10;

        for ($i = 0; $i < $batch_size; $i++) {
            $message = $this->email_outbox->claim_next();

            if ($message === NULL) {
                break;
            }

            if ($message === FALSE) {
                log_message('error', 'Unable to claim an email from the VerificaPay outbox.');
                fwrite(STDERR, 'Unable to read the email queue.' . PHP_EOL);
                exit(1);
            }

            $this->email->clear(TRUE);
            $this->email->from(
                $this->email_config['mail_from'],
                $this->email_config['mail_from_name']
            );
            $this->email->to($message['recipient']);
            $this->email->subject($message['subject']);
            $this->email->message($message['message']);
            $this->email->set_alt_message($message['alt_message']);

            if ($this->email->send()) {
                if (!$this->email_outbox->mark_sent($message['id_email_outbox'])) {
                    log_message(
                        'error',
                        'Email was sent but could not be marked as sent. Outbox ID: ' .
                        (int) $message['id_email_outbox']
                    );
                    $failed++;
                    continue;
                }

                $sent++;
                continue;
            }

            if (!$this->email_outbox->mark_failed($message)) {
                log_message(
                    'error',
                    'Email delivery failed and queue status could not be updated. Outbox ID: ' .
                    (int) $message['id_email_outbox']
                );
            }

            log_message(
                'error',
                'SMTP delivery failed for VerificaPay outbox ID ' .
                (int) $message['id_email_outbox'] .
                ' on attempt ' . (int) $message['attempts'] . '.'
            );
            $failed++;
        }

        echo 'Email queue processed. Sent: ' . $sent . '; failed: ' . $failed . '.' . PHP_EOL;
    }

    private function email_library_config()
    {
        $config = $this->email_config;
        unset($config['mail_from'], $config['mail_from_name'], $config['contact_email_to']);
        return $config;
    }
}
