<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_table_email_outbox extends CI_Migration
{
    public function up()
    {
        if ($this->db->table_exists('email_outbox')) {
            return;
        }

        $this->dbforge->add_field([
            'id_email_outbox' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'contact_request_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'recipient' => [
                'type' => 'VARCHAR',
                'constraint' => 254
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'message' => [
                'type' => 'MEDIUMTEXT'
            ],
            'alt_message' => [
                'type' => 'TEXT'
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'pending'
            ],
            'attempts' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'available_at' => [
                'type' => 'DATETIME'
            ],
            'locked_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'sent_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'last_error' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->dbforge->add_key('id_email_outbox', TRUE);
        $this->dbforge->add_key('contact_request_id', FALSE, TRUE);
        $this->dbforge->add_key(['status', 'available_at']);
        $this->dbforge->create_table('email_outbox', TRUE);
    }

    public function down()
    {
        if ($this->db->table_exists('email_outbox')) {
            $this->dbforge->drop_table('email_outbox', TRUE);
        }
    }
}
