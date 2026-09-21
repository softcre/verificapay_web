<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_table_usuarios extends CI_Migration
{
    public function up()
    {
        if (!$this->db->table_exists('usuarios')) {

            $this->dbforge->add_field([
                'id_usuario' => [
                    'type'           => 'BIGINT',
                    'constraint'     => 20,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE
                ],

                'usuario_tipo_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => TRUE
                ],

                'nombre' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100
                ],

                'apellido' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => TRUE
                ],

                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150
                ],

                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255
                ],

                'telefono' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => TRUE
                ],

                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE,
                    'default'    => 'no-user.jpg'
                ],

                'firma_usuario' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE
                ],

                'activo' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1
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

            $this->dbforge->add_key('id_usuario', TRUE);
            $this->dbforge->add_key('email');

            $this->dbforge->create_table('usuarios', TRUE);
        }

        /*
         * Foreign key:
         *
         * usuarios.usuario_tipo_id
         *          ↓
         * usuarios_tipo.id_tipo_usuario
         */

        if (!$this->foreign_key_exists(
            'usuarios',
            'fk_usuarios_tipo'
        )) {

            $this->db->query(
                'ALTER TABLE `usuarios`
                 ADD CONSTRAINT `fk_usuarios_tipo`
                 FOREIGN KEY (`usuario_tipo_id`)
                 REFERENCES `usuarios_tipo` (`id_tipo_usuario`)
                 ON UPDATE CASCADE
                 ON DELETE RESTRICT'
            );
        }

        /*
         * Initial users
         */

        $password = '$2a$12$sp/C2Lteakyaj3Pwd6vt9O1X5t8MjwSkbNsPmSH.qEBfnZ9Jnc.6u';

        /*
         * Administrator
         */

        $admin_email = 'adminverificapay@softcre.com';

        $admin_exists = $this->db
            ->where('email', $admin_email)
            ->count_all_results('usuarios');

        if (!$admin_exists) {

            $this->db->insert('usuarios', [
                'usuario_tipo_id' => 1,
                'nombre'         => 'Administrador',
                'apellido'       => 'VerificaPay',
                'email'          => $admin_email,
                'password'       => $password,
                'foto'           => 'no-user.jpg',
                'activo'         => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ]);
        }

        /*
         * Regular user
         */

        $user_email = 'userverificapay@softcre.com';

        $user_exists = $this->db
            ->where('email', $user_email)
            ->count_all_results('usuarios');

        if (!$user_exists) {

            $this->db->insert('usuarios', [
                'usuario_tipo_id' => 2,
                'nombre'         => 'Usuario',
                'apellido'       => 'VerificaPay',
                'email'          => $user_email,
                'password'       => $password,
                'foto'           => 'no-user.jpg',
                'activo'         => 1,
                'created_at'     => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function down()
    {
        if ($this->db->table_exists('usuarios')) {
            $this->dbforge->drop_table('usuarios', TRUE);
        }
    }

    /**
     * Check whether a foreign key already exists.
     */
    private function foreign_key_exists($table, $constraint)
    {
        $database = $this->db->database;

        $query = $this->db->query(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = ?
             AND TABLE_NAME = ?
             AND CONSTRAINT_NAME = ?
             AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
            [
                $database,
                $table,
                $constraint
            ]
        );

        return $query->num_rows() > 0;
    }
}