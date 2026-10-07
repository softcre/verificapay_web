<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_requests_model extends CI_Model
{
    private $table = 'contact_requests';

    public function create(array $contact, array $notification)
    {
        $this->db->trans_begin();

        $inserted_contact = $this->db->insert($this->table, [
            'full_name' => $contact['full_name'],
            'business_name' => $contact['business_name'],
            'email' => $contact['email'],
            'phone' => $contact['phone'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!$inserted_contact) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $contact_request_id = $this->db->insert_id();
        $queued_email = $this->db->insert('email_outbox', [
            'contact_request_id' => $contact_request_id,
            'recipient' => $notification['recipient'],
            'subject' => $notification['subject'],
            'message' => $notification['message'],
            'alt_message' => $notification['alt_message'],
            'status' => 'pending',
            'attempts' => 0,
            'available_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!$queued_email || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->trans_commit();
        return $contact_request_id;
    }
}
