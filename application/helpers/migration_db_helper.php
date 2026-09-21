<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Utilidades para migraciones idempotentes (tabla/columna/FK ya existentes).
 */
function migration_fk_exists($table, $constraint_name)
{
    $CI = &get_instance();
    $sql = "
        SELECT COUNT(*) AS c
        FROM information_schema.TABLE_CONSTRAINTS
        WHERE CONSTRAINT_SCHEMA = DATABASE()
          AND TABLE_NAME = ?
          AND CONSTRAINT_NAME = ?
          AND CONSTRAINT_TYPE = 'FOREIGN KEY'
    ";
    $row = $CI->db->query($sql, [$table, $constraint_name])->row();
    return $row && (int) $row->c > 0;
}

function migration_add_fk_if_missing($table, $constraint_name, $alter_sql)
{
    if (!migration_fk_exists($table, $constraint_name)) {
        $CI = &get_instance();
        $CI->db->query($alter_sql);
    }
}

function migration_filter_missing_columns($table, array $fields)
{
    $CI = &get_instance();
    $missing = [];
    foreach ($fields as $name => $definition) {
        if (!$CI->db->field_exists($name, $table)) {
            $missing[$name] = $definition;
        }
    }
    return $missing;
}
