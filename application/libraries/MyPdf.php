<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'Config_MyPdf.php';
require 'vendor/tecnickcom/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{

  public function __construct($orientation = PDF_PAGE_ORIENTATION, $unit = PDF_UNIT, $format = PDF_PAGE_FORMAT, $unicode = true, $encoding = 'UTF-8', $diskcache = false)
  {
    parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
  }

  public function index($title)
  {
    $this->SetTitle($title);
    $this->SetSubject('Listado de Productos Disponibles');
  }

  // Page footer
  public function Footer()
  {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    $this->SetFont('helvetica', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }

  public function DrawHeader($header, $w)
  {
    // Colors, line width and bold font
    // Header
    $this->SetFillColor(5, 32, 53);
    $this->SetTextColor(255);
    $this->SetDrawColor(5, 32, 53);
    $this->SetLineWidth(0.1);
    $this->SetFont('', 'B', 9);
    $num_headers = count($header);
    for ($i = 0; $i < $num_headers; ++$i) {
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
    }
    $this->Ln();
  }

  public function colorRow()
  {
    // Color and font restoration
    $this->SetFillColor(238, 238, 238);
    $this->SetTextColor(0);
    $this->SetFont('', '', 9);
  }

  public function colorOferta()
  {
    $this->SetFillColor(127, 255, 212);
    $this->SetTextColor(0);
    $this->SetFont('', '', 9);
  }

  public function colorProveedor()
  {
    $this->SetFillColor(119, 245, 255);
    $this->SetTextColor(0);
    $this->SetFont('', 'B', 10);
  }

  public function colorSegmento()
  {
    // $this->SetFillColor(176, 224, 230);
    $this->SetFillColor(224, 255, 255);
    $this->SetTextColor(0);
    $this->SetFont('', 'B', 9);
  }
}
