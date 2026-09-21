<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input Optional description
 */

/**
 * Verifica si el usuario actual tiene permisos de administrador o superadmin
 */
function esAdmin()
{
  return isset($_SESSION['usuario_tipo_id']) && in_array((int) $_SESSION['usuario_tipo_id'], [1, 2], true);
}

/**
 * Verifica si el usuario actual es superadmin
 */
function esSuperAdmin()
{
  return isset($_SESSION['usuario_tipo_id']) && (int) $_SESSION['usuario_tipo_id'] === 2;
}

/**
 * Verifica si hay una sesion de usuario 'admin' en curso
 */
function verificarSesionAdmin()
{
  if (esAdmin())
    return;

  show_404();
}

/**
 * Verifica si hay una sesion de usuario 'superadmin' en curso
 */
function verificarSesionSuperAdmin()
{
  if (esSuperAdmin())
    return;

  show_404();
}

/**
 * Verifica si es una llamada (request) desde Ajax
 */
function verificarConsulAjax()
{
  $CI = &get_instance();

  if (!$CI->input->is_ajax_request()) {
    show_404();
  }
}


function validarFileExcel($fileExcel)
{
  $file_mimes = array('application/vnd.ms-excel', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  $errorFile = '';

  if (isset($fileExcel['name']) && $fileExcel['name']) {
    if (!in_array($fileExcel['type'], $file_mimes)) {
      $errorFile = "Debe ingresar un archivo de excel (.xlsx)";
    }
  } else {
    $errorFile = "Ingrese un archivo de Excel";
  }

  return $errorFile;
}
