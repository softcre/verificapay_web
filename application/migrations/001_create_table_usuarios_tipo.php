<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_table_usuarios_tipo extends CI_Migration
{
    public function up()
    {
        if (!$this->db->table_exists('usuarios_tipo')) {

            $this->dbforge->add_field([
                'id_tipo_usuario' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE
                ],

                'tipo_usuario' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50
                ],

                'descripcion' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE
                ],

                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE
                ],

                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE
                ],

                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE
                ]
            ]);

            $this->dbforge->add_key('id_tipo_usuario', TRUE);

            $this->dbforge->create_table('usuarios_tipo', TRUE);
        }

        /*
         * Initial user types
         */

        $tipos = [
            [
                'id_tipo_usuario' => 1,
                'tipo_usuario'    => 'ADMIN',
                'descripcion'     => 'Administrador del sistema',
                'created_at'      => date('Y-m-d H:i:s')
            ],
            [
                'id_tipo_usuario' => 2,
                'tipo_usuario'    => 'USER',
                'descripcion'     => 'Usuario del sistema',
                'created_at'      => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($tipos as $tipo) {

            $exists = $this->db
                ->where(
                    'id_tipo_usuario',
                    $tipo['id_tipo_usuario']
                )
                ->count_all_results('usuarios_tipo');

            if (!$exists) {
                $this->db->insert('usuarios_tipo', $tipo);
            }
        }
    }

    public function down()
    {
        $this->dbforge->drop_table('usuarios_tipo', TRUE);
    }
}