<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('asset_url')) {
    function asset_url($path = '')
    {
        $url = base_url('assets/' . ltrim($path, '/'));
        $file = FCPATH . 'assets/' . ltrim($path, '/');
        return file_exists($file) ? $url . '?v=' . filemtime($file) : $url;
    }
}

if (!function_exists('arsha_asset')) {
    function arsha_asset($path = '')
    {
        $url = base_url('assets/arsha/' . ltrim($path, '/'));
        $file = FCPATH . 'assets/arsha/' . ltrim($path, '/');
        return file_exists($file) ? $url . '?v=' . filemtime($file) : $url;
    }
}

if (!function_exists('adminlte_asset')) {
    function adminlte_asset($path = '')
    {
        $url = base_url('assets/adminlte/' . ltrim($path, '/'));
        $file = FCPATH . 'assets/adminlte/' . ltrim($path, '/');
        return file_exists($file) ? $url . '?v=' . filemtime($file) : $url;
    }
}