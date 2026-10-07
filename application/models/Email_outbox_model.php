<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_outbox_model extends CI_Model
{
    private $table = 'email_outbox';
    private $max_attempts = 5;

    public function claim_next()
    {
        $this->db->set('status', 'failed');
        $this->db->set('locked_at', NULL);
        $this->db->set('last_error', 'Email worker stopped before completing delivery.');
        $this->db->where('status', 'sending');
        $this->db->where('attempts >=', $this->max_attempts);
        $this->db->where('locked_at < DATE_SUB(NOW(), INTERVAL 15 MINUTE)', NULL, FALSE);
        $this->db->update($this->table);

        $this->db->set('status', 'pending');
        $this->db->set('locked_at', NULL);
        $this->db->where('status', 'sending');
        $this->db->where('attempts <', $this->max_attempts);
        $this->db->where('locked_at < DATE_SUB(NOW(), INTERVAL 15 MINUTE)', NULL, FALSE);
        $this->db->update($this->table);

        $this->db->from($this->table);
        $this->db->where('status', 'pending');
        $this->db->where('attempts <', $this->max_attempts);
        $this->db->where('available_at <=', date('Y-m-d H:i:s'));
        $this->db->order_by('id_email_outbox', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();

        if (!$query) {
            return FALSE;
        }

        $email = $query->row_array();
        if (!$email) {
            return NULL;
        }

        $this->db->set('status', 'sending');
        $this->db->set('attempts', 'attempts + 1', FALSE);
        $this->db->set('locked_at', date('Y-m-d H:i:s'));
        $this->db->where('id_email_outbox', $email['id_email_outbox']);
        $this->db->where('status', 'pending');
        $this->db->where('attempts <', $this->max_attempts);
        $this->db->update($this->table);

        if ($this->db->affected_rows() !== 1) {
            return NULL;
        }

        $email['attempts']++;
        return $email;
    }

    public function mark_sent($id)
    {
        $this->db->set('status', 'sent');
        $this->db->set('sent_at', date('Y-m-d H:i:s'));
        $this->db->set('locked_at', NULL);
        $this->db->set('last_error', NULL);
        $this->db->where('id_email_outbox', $id);
        $this->db->where('status', 'sending');
        return $this->db->update($this->table) && $this->db->affected_rows() === 1;
    }

    public function mark_failed(array $email)
    {
        $attempts = (int) $email['attempts'];
        $retry = $attempts < $this->max_attempts;
        $delay = min(3600, 60 * (2 ** max(0, $attempts - 1)));

        $this->db->set('status', $retry ? 'pending' : 'failed');
        $this->db->set(
            'available_at',
            date('Y-m-d H:i:s', time() + ($retry ? $delay : 0))
        );
        $this->db->set('locked_at', NULL);
        $this->db->set('last_error', 'SMTP delivery failed.');
        $this->db->where('id_email_outbox', $email['id_email_outbox']);
        $this->db->where('status', 'sending');
        return $this->db->update($this->table) && $this->db->affected_rows() === 1;
    }
}
