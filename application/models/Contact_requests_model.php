<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_requests_model extends CI_Model
{
    private $table = 'contact_requests';

    public function search($status = '', $search = '', $limit = 20, $offset = 0)
    {
        $this->apply_filters($status, $search);
        return $this->db
            ->order_by('id_contact_request', 'DESC')
            ->limit((int) $limit, (int) $offset)
            ->get($this->table)
            ->result();
    }

    public function count_search($status = '', $search = '')
    {
        $this->apply_filters($status, $search);
        return $this->db->count_all_results($this->table);
    }

    public function get($id)
    {
        return $this->db
            ->where('id_contact_request', (int) $id)
            ->get($this->table)
            ->row();
    }

    public function update_admin_fields($id, $status, $notes)
    {
        return $this->db
            ->where('id_contact_request', (int) $id)
            ->update($this->table, [
                'status' => $status,
                'notes' => $notes === '' ? NULL : $notes,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    private function apply_filters($status, $search)
    {
        $allowed_statuses = ['new', 'contacted', 'demo_scheduled', 'closed'];
        if (in_array($status, $allowed_statuses, TRUE)) {
            $this->db->where('status', $status);
        }

        $search = trim((string) $search);
        if ($search !== '') {
            $this->db->group_start()
                ->like('full_name', $search)
                ->or_like('business_name', $search)
                ->or_like('email', $search)
                ->or_like('phone', $search)
                ->group_end();
        }
    }

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
