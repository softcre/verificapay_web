<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admin_workflow extends CI_Migration
{
    public function up()
    {
        if (!$this->db->field_exists('status', 'contact_requests')) {
            $this->dbforge->add_column('contact_requests', [
                'status' => [
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                    'default' => 'new'
                ]
            ]);
            $this->db->query(
                "UPDATE `contact_requests` SET `status` = 'new' WHERE `status` IS NULL OR `status` = ''"
            );
        }

        if (!$this->db->field_exists('notes', 'contact_requests')) {
            $this->dbforge->add_column('contact_requests', [
                'notes' => [
                    'type' => 'TEXT',
                    'null' => TRUE
                ]
            ]);
        }

        if (!$this->db->field_exists('updated_at', 'contact_requests')) {
            $this->dbforge->add_column('contact_requests', [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE
                ]
            ]);
        }

        if (!$this->db->table_exists('admin_audit_log')) {
            $this->dbforge->add_field([
                'id_admin_audit_log' => [
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ],
                'admin_user_id' => [
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => TRUE,
                    'null' => TRUE
                ],
                'action' => [
                    'type' => 'VARCHAR',
                    'constraint' => 80
                ],
                'entity_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => 40
                ],
                'entity_id' => [
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => TRUE
                ],
                'details' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE
                ],
                'created_at' => [
                    'type' => 'DATETIME'
                ]
            ]);
            $this->dbforge->add_key('id_admin_audit_log', TRUE);
            $this->dbforge->add_key(['entity_type', 'entity_id']);
            $this->dbforge->add_key('created_at');
            $this->dbforge->create_table('admin_audit_log', TRUE);
        }
    }

    public function down()
    {
        if ($this->db->table_exists('admin_audit_log')) {
            $this->dbforge->drop_table('admin_audit_log', TRUE);
        }

        foreach (['updated_at', 'notes', 'status'] as $field) {
            if ($this->db->field_exists($field, 'contact_requests')) {
                $this->dbforge->drop_column('contact_requests', $field);
            }
        }
    }
}
