<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Devuelve fecha actual del sistema
 * 
 * @param string $format Formato de salida a eleccion
 * 
 * @return string Fecha y hora actual del sistema en formato indicado
 */
function fechaHoraHoy($format = 'Y-m-d H:i:s')
{
  return date($format);
}

/**
 * Formatea una fecha dada o la fecha actual del sistema.
 * * @param string|int|DateTime|null $fecha La fecha a formatear (acepta texto, timestamp o DateTime). Si es null, usa "now".
 * @param string $format Formato de salida a elección.
 * * @return string Fecha y hora en el formato indicado.
 */
function formatearFecha($fecha = null, string $format = 'd/m/Y'): string
{
  try {
    // Si es un timestamp numérico, lo convertimos anteponiendo '@'
    if (is_numeric($fecha)) {
      $fecha = "@$fecha";
    }

    // Si ya es un objeto DateTime, lo usamos directamente; si no, creamos uno nuevo
    $dateObj = $fecha instanceof DateTime ? $fecha : new DateTime($fecha ?? 'now');

    return $dateObj->format($format);
  } catch (Exception $e) {
    // Manejo de errores por si pasan un string que no es una fecha válida
    return "Fecha inválida";
  }
}

/**
 * Recibe un numero y devuelve en formato ###,##
 * 
 * @param float $numero Numero recibido
 * @param int $decimales Cantidad de decimales
 * 
 * @return string Formato de salida ###,##
 */
function formatearNumero($numero, $decimales = 2)
{
  return number_format($numero, $decimales, ',', '.');
}

/**
 * Recibe un numero y devuelve en formato USD ###,##
 * 
 * @param float $precio Precio recibido
 * @param int $decimales Cantidad de decimales
 * 
 * @return string Formato de salida USD ###,##
 */
function formatearToDolar($precio, $decimales = 2)
{
  return 'USD ' . number_format($precio, $decimales, ',', '.');
}

/**
 * Recibe un simbolo, numero y devuelve en formato ###,##
 * 
 * @param string $simbolo Simbolo de la moneda usada
 * @param float $precio Precio recibido
 * @param int $decimales Cantidad de decimales
 * 
 * @return string Formato de salida USD ###,##
 */
function formatearPrecio($simbolo, $precio, $decimales = 2)
{
  return $simbolo . ' ' . number_format($precio, $decimales, ',', '.');
}

/**
 * Recibe un numero y devuelve en formato $ ###,##
 * 
 * @param float $precio Precio recibido
 * @param int $decimales Cantidad de decimales
 * 
 * @return string Formato de salida $ ###,##
 */
function formatearToPesos($precio, $decimales = 2)
{
  return '$ ' . number_format($precio, $decimales, ',', '.');
}


/**
 * Recibe un numero y devuelve en formato ##,## %
 * 
 * @param float $numero Porcentaje recibido
 * @param int $decimales Cantidad de decimales
 * 
 * @return string Formato de salida ##,## %
 */
function formatearToPorcentaje($numero, $decimales = 2)
{
  return number_format($numero, $decimales, ',', '.') . ' %';
}

/**
 * Calcula el precio de venta en dolar de un producto
 * 
 * @param float $precioListaProv Precio de lista del proveedor
 * @param float $dto1 Descuento 1 del proveedor
 * @param float $dto2 Descuento 2 del proveedor
 * @param float $margen Margen
 * 
 * @return float Precio de venta en USD
 */
function calcularPrecioVenta($precioListaProv, $dto1, $dto2, $margen)
{
  return $precioListaProv * $dto1 * $dto2 * $margen;
}

/**
 * Calcula el precio de venta en pesos de un producto
 * 
 * @param float $precioVenta Precio de venta en dolares
 * @param float $precio_dolar
 * 
 * @return float Precio de venta en pesos
 */
function calcularPVPClasica($precioVenta, $precio_dolar)
{
  return $precioVenta * $precio_dolar;
}

/**
 * Calcula el precio de venta en pesos con IVA de un producto
 * 
 * @param float $PVPClasica Precio de venta sin IVA
 * @param float $iva IVA a aplicar
 * 
 * @return float Precio de venta con IVA
 */
function calcularPVPPremium($PVPClasica, $iva)
{
  return $PVPClasica + ($PVPClasica * $iva / 100);
}

/**
 * Calcula el precio de oferta en pesos de un producto
 * 
 * @param float $precio Precio del producto
 * @param float $porc_descuento Porcentaje de descuento a aplicar
 * 
 * @return float Precio de oferta en pesos
 */
function calcularOferta($precio, $porc_descuento)
{
  return $precio - ($precio * $porc_descuento / 100);
}

/**
 * Indica si hay empresa configurada y certificados ARCA en disco.
 */
function arca_certificados_listos()
{
  $CI = &get_instance();
  if (!$CI->db->table_exists('empresa')) {
    return FALSE;
  }

  $empresa = $CI->db->limit(1)->get('empresa')->row();
  if (!$empresa || empty($empresa->cuit)) {
    return FALSE;
  }

  $certs_path = APPPATH . 'certs' . DIRECTORY_SEPARATOR;
  $cert = !empty($empresa->arca_cert_filename)
    && is_readable($certs_path . $empresa->arca_cert_filename);
  $key = !empty($empresa->arca_key_filename)
    && is_readable($certs_path . $empresa->arca_key_filename);

  return $cert && $key;
}

/**
 * Desglose neto / IVA asumiendo precio unitario con IVA incluido.
 */
function calcularImportesFiscalesLinea($precio_unitario_con_iva, $cantidad, $iva_porcentaje)
{
  $total = round((float) $precio_unitario_con_iva * (float) $cantidad, 2);
  $factor = 1 + ((float) $iva_porcentaje / 100);
  $neto = $factor > 0 ? round($total / $factor, 2) : $total;
  $iva = round($total - $neto, 2);

  return [
    'subtotal' => $total,
    'importe_neto' => $neto,
    'importe_iva' => $iva,
  ];
}

function arca_tipos_comprobante()
{
  return [
    1 => 'Factura A',
    6 => 'Factura B',
    11 => 'Factura C',
    2 => 'Nota de Débito A',
    7 => 'Nota de Débito B',
    12 => 'Nota de Débito C',
    3 => 'Nota de Crédito A',
    8 => 'Nota de Crédito B',
    13 => 'Nota de Crédito C',
  ];
}

function arca_condiciones_iva_receptor($cod_iva = null)
{
  $map = [
    1 => 'Responsable Inscripto',
    4 => 'Sujeto Exento',
    5 => 'Consumidor Final',
    6 => 'Responsable Monotributo',
  ];
  return $map[$cod_iva] ?? $map;
}

function arca_tipos_documento($cod_doc = null)
{
  $map = [
    80 => 'CUIT',
    96 => 'DNI',
    //99 => 'Consumidor Final',
  ];
  return $cod_doc ? ($map[$cod_doc] ?? null) : $map;
}

function badgeEstadoVenta($estado)
{
  $map = [
    'BORRADOR' => 'secondary',
    'PENDIENTE_ARCA' => 'warning',
    'AUTORIZADA' => 'success',
    'RECHAZADA' => 'danger',
    'ANULADA' => 'dark',
    'PENDIENTE' => 'info',
  ];
  $class = $map[$estado] ?? 'light';
  return '<span class="badge badge-' . $class . '">' . htmlspecialchars($estado) . '</span>';
}

function badgeEstadoPresupuesto($estado)
{
  $map = [
    'PENDIENTE' => 'warning',
    'APROBADO' => 'success',
    'CANCELADO' => 'dark',
    'VENCIDO' => 'secondary',
    'FACTURADO' => 'info',
  ];
  $class = $map[$estado] ?? 'light';
  return '<span class="badge badge-' . $class . '">' . htmlspecialchars($estado) . '</span>';
}

/**
 * Alias de formatearNumero usado en vistas legacy de ventas.
 */
function formatearMonto($numero, $decimales = 2)
{
  return formatearNumero($numero, $decimales);
}

/**
 * Tipo de cambio vigente (promedio de proveedores activos).
 */
function obtenerDolarVigente()
{
  $CI = &get_instance();
  $row = $CI->db->select_avg('precio_dolar', 'precio')
    ->where('deleted_at IS NULL', NULL, FALSE)
    ->get('proveedores')
    ->row();

  return (object) [
    'precio' => $row && $row->precio ? round((float) $row->precio, 2) : 1,
  ];
}

function totalMediosPago()
{
  if (empty($_SESSION['medios_pago'])) {
    return 0;
  }

  $total = 0;
  foreach ($_SESSION['medios_pago'] as $mp) {
    $total += (float) ($mp['monto'] ?? 0);
  }

  return round($total, 2);
}

function totalMediosPagoDolar($precio_dolar)
{
  if (!$precio_dolar) {
    return 0;
  }

  return round(totalMediosPago() / (float) $precio_dolar, 2);
}

function calcularEstadoCuentaCliente($total_debe, $total_haber)
{
  return round((float) $total_haber - (float) $total_debe, 2);
}

function calcularTotalBonificado($subtotal, $bonificacion)
{
  $subtotal = (float) $subtotal;
  $bonificacion = (float) $bonificacion;

  return round($subtotal - ($subtotal * ($bonificacion / 100)), 2);
}

function totalCarritoBonificado($cart = null)
{
  $CI = &get_instance();

  if ($cart === null) {
    $cart = $CI->cart;
  }

  $total = 0;

  foreach ($cart->contents() as $item) {
    $subtotalItem = (float) ($item['subtotal'] ?? 0);
    $porcentajeBonif = (float) ($item['bonificacion'] ?? 0);
    $total += calcularTotalBonificado($subtotalItem, $porcentajeBonif);
  }

  return round($total, 2);
}

function montoSugeridoMedioPago($cart = null)
{
  $totalVenta = totalCarritoBonificado($cart);
  $pagado = totalMediosPago();

  return max(0, round($totalVenta - $pagado, 2));
}

function nextMedioPagoId()
{
  if (empty($_SESSION['medios_pago'])) {
    return 1;
  }

  $ids = array_column($_SESSION['medios_pago'], 'id');
  return max($ids) + 1;
}
