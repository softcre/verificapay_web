<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Upload $upload Optional description
 */
class Imagen
{

  /**
   * Obtiene la url del archivo indicado
   * @param string $folder Nombre de la carpeta donde se encuenta archivo
   * @param string $file Nombre archivo
   */
  function getUrlImg($folder, $file)
  {
    $folder = strtolower($folder);
    $filename = 'assets/img/' . $folder . '/' . $file;

    if (file_exists($filename)) {
      return base_url($filename);
    } else {
      return $this->getImgDefault($folder);
    }
  }

  /**
   * Sube una imagen
   * @param string $nombre Nombre del input de donde se recibe el archivo
   * @param string $carpeta Nombre de la carpeta donde se subira la imagen
   * @param string $imgDefault Nombre de imagen por defecto, en caso de que no haya nada
   */
  function subirImagen($nombre, $carpeta, $imgDefault, $num = '')
  {
    $CI = &get_instance();
    $tipos  = array('image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png', 'imagen/x-png');
    $destino = 'assets/img/' . $carpeta . '/';

    if (isset($_FILES[$nombre]['name'])) {
      $mime  =  get_mime_by_extension($_FILES[$nombre]['name']); //obtiene la extension del file

      if (in_array($mime,  $tipos)) {
        //cargar configuración 
        $config['upload_path'] = $destino;
        $config['allowed_types'] = 'bmp|jpeg|jpg|png';
        $config['file_name'] = date('dmY') . '_' . time() . $num;

        $CI->upload->initialize($config); // Se inicializa la config

        // subir el archivo al directorio 
        if ($CI->upload->do_upload($nombre)) {
          $imgSubida = $CI->upload->data();
          return $imgSubida['orig_name'];
          //return $destino . $imgSubida['orig_name'];
        }
      }
    }
    return $imgDefault;
    //return $destino . $imgDefault;
  }

  /**
   * Devuelve una imagen default
   * 
   * @param string $folder Nombre de la carpeta donde se busca imag default
   * @return string $url de imagen default
   */
  function getImgDefault($folder)
  {
    $filename = 'assets/img/' . $folder . '/';

    switch ($folder) {
      case 'usuarios':
        $filename .= IMG_DEFAULT_USUARIOS;
        break;
      case 'productos':
        $filename .= IMG_DEFAULT_PRODUCTOS;
        break;
    }

    if (file_exists($filename))
      return base_url($filename);
    else
      return false;
  }

  // /**
  //  * Sube un comprobante
  //  * @param string $nombre Nombre del input de donde se recibe el archivo
  //  * @param string $carpeta Nombre de la carpeta donde se subira el comprobante
  //  */
  // function subirComprobante($nombre, $carpeta)
  // {
  //   $CI = &get_instance();
  //   //$tipos  = array('image/jpeg', 'image/pjpeg', 'image/bmp', 'image/png', 'imagen/x-png');
  //   $destino = 'assets/ventas/' . $carpeta . '/';

  //   if (isset($_FILES[$nombre]['name'])) {
  //     //$mime  =  get_mime_by_extension($_FILES[$nombre]['name']); //obtiene la extension del file

  //     //if (in_array($mime,  $tipos)) {
  //     //cargar configuración 
  //     $config['upload_path'] = $destino;
  //     $config['allowed_types'] = '*';
  //     $config['file_name'] = date('dmY') . '_' . time();

  //     $CI->upload->initialize($config); // Se inicializa la config

  //     // subir el archivo al directorio 
  //     if ($CI->upload->do_upload($nombre)) {
  //       $imgSubida = $CI->upload->data();
  //       return $destino . $imgSubida['orig_name'];
  //     }
  //     //}
  //   }
  // }
}
