<?php

namespace App\Controllers;

use App\Models\Penyewa;

class Home extends BaseController
{
    public function index()
    {
        $transaksiModel = new Penyewa();
        $data = [
            'cardReload' => '<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>',
            'headerTitle' => 'Dashboard',
            'navDashboardActive' => 'active',
            'transaksiProgress' => count($transaksiModel->getPenyewaJumlahPembayaranProgress()->get()->getResultArray()),
            'transaksiApproved' => count($transaksiModel->getPenyewaJumlahPembayaranApproved()->get()->getResultArray()),
            'transaksiRejected' => count($transaksiModel->getPenyewaJumlahPembayaranRejected()->get()->getResultArray())
        ];
        return view('dashboard/dashboard', $data);
    }

    public function downloadFile($filename)
    {
        $filepath = WRITEPATH . 'uploads/' . $filename;

        if (file_exists($filepath)) {
            return $this->response->download($filepath, null);
        } else {
            return "File not found.";
        }
    }
}
