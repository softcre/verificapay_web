<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_table_contact_requests extends CI_Migration
{
    public function up()
    {
        if ($this->db->table_exists('contact_requests')) {
            return;
        }

        $this->dbforge->add_field([
            'id_contact_request' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 160
            ],
            'business_name' => [
                'type' => 'VARCHAR',
                'constraint' => 160
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 254
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->dbforge->add_key('id_contact_request', TRUE);
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('contact_requests', TRUE);
    }

    public function down()
    {
        if ($this->db->table_exists('contact_requests')) {
            $this->dbforge->drop_table('contact_requests', TRUE);
        }
    }
}
