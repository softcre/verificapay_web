<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard_model extends CI_Model
{
    public function get_summary()
    {
        return [
            'new_leads' => $this->db->where('status', 'new')->count_all_results('contact_requests'),
            'follow_up_leads' => $this->db
                ->where_in('status', ['contacted', 'demo_scheduled'])
                ->count_all_results('contact_requests'),
            'pending_emails' => $this->db
                ->where('status', 'pending')
                ->count_all_results('email_outbox'),
            'failed_emails' => $this->db
                ->where('status', 'failed')
                ->count_all_results('email_outbox'),
            'active_users' => $this->db
                ->where('activo', 1)
                ->where('deleted_at', NULL)
                ->count_all_results('usuarios')
        ];
    }

    public function get_recent_leads($limit = 8)
    {
        return $this->db
            ->from('contact_requests')
            ->order_by('id_contact_request', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }

    public function get_queue_summary()
    {
        $rows = $this->db
            ->select('status, COUNT(*) AS total')
            ->group_by('status')
            ->get('email_outbox')
            ->result();
        $summary = ['pending' => 0, 'sending' => 0, 'sent' => 0, 'failed' => 0];

        foreach ($rows as $row) {
            if (isset($summary[$row->status])) {
                $summary[$row->status] = (int) $row->total;
            }
        }

        return $summary;
    }
}
