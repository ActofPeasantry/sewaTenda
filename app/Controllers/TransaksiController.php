<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Penyewa;
use App\Models\Pembayaran;
use App\Models\DetailPembayaran;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\I18n\Time;

class TransaksiController extends BaseController
{
    public function indexTransaksiProgress()
    {
        $transaksiModel = new Penyewa();
        $transaksiList = $transaksiModel->getPenyewaJumlahPembayaranProgress()->get()->getResultArray();

        $data = [
            'headerTitle' => 'Transaksi Progress',
            'navTransaksiActive' => 'active',
            'breadcrumbLink' => '<a href="/dashboard">Dashboard</a>',
            'status' => '2',
            'btnInfo' => 'btn-info',
            'transaksiList' => $transaksiList
        ];
        return view('transaksi/index-transaksi', $data);
    }

    public function indexTransaksiApproved()
    {
        $transaksiModel = new Penyewa();
        $transaksiList = $transaksiModel->getPenyewaJumlahPembayaranApproved()->get()->getResultArray();

        $data = [
            'headerTitle' => 'Transaksi Approved',
            'navTransaksiActive' => 'active',
            'breadcrumbLink' => '<a href="/dashboard">Dashboard</a>',
            'status' => '1',
            'btnSuccess' => 'btn-success',
            'transaksiList' => $transaksiList
        ];
        return view('transaksi/index-transaksi', $data);
    }

    public function indexTransaksiRejected()
    {
        $transaksiModel = new Penyewa();
        $transaksiList = $transaksiModel->getPenyewaJumlahPembayaranRejected()->get()->getResultArray();
        $data = [
            'headerTitle' => 'Transaksi Rejected',
            'navTransaksiActive' => 'active',
            'breadcrumbLink' => '<a href="/dashboard">Dashboard</a>',
            'status' => '0',
            'btnDanger' => 'btn-danger',
            'transaksiList' => $transaksiList
        ];
        return view('transaksi/index-transaksi', $data);
    }

    public function confirmTransaksiView()
    {
        $data = [
            'headerTitle' => 'Transaksi',
            'navTransaksiActive' => 'active',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/transaksi-' . ($this->request->getPost('status') == 2 ? "progress" : ($this->request->getPost('status') == 1 ? "approved" : "rejected")) . '">Back</a>',
        ];

        $PenyewaModel = new Penyewa();
        $penyewa = $PenyewaModel->find($this->request->getPost('penyewaId'));

        $pembayaranModel = new Pembayaran();
        $pembayaranList = $pembayaranModel->getPembayaranByPenyewaAndStatus(
            $this->request->getPost('penyewaId'),
            $this->request->getPost('status')
        )->get()->getResultArray();
        $getCost = $pembayaranModel->getPembayaranCostByPenyewaAndStatus(
            $this->request->getPost('penyewaId'),
            $this->request->getPost('status')
        );

        $data += [
            'pembayaranList' => $pembayaranList,
            'penyewa' => $penyewa,
            'status' => $this->request->getPost('status'),
            'totalBiaya' => $getCost
        ];

        return view('transaksi/detail-transaksi', $data);
    }

    public function confirmTransaksiViewDetail($pesananId)
    {
        $detailModel = new DetailPembayaran();
        $detail = $detailModel->getDetailByPembayaranId($pesananId)->get()->getResultArray();

        return $this->response->setJSON($detail);
    }

    public function confirmTransaksi()
    {
        $idPembayarans = $this->request->getPost('idPembayarans');
        if (empty($idPembayarans)) {
            return redirect()->to('/transaksi-progress')->with('error', '<em>Submit Gagal : </em> Sebelum melakukan <code>Submit</code>, harap pastikan bahwa data pembayaran telah diverifikasi dengan memilih setidaknya satu catatan pembayaran.');
        }

        $pembayaranModel = new Pembayaran();

        $PenyewaModel = new Penyewa();
        $penyewa = $PenyewaModel->find($this->request->getPost('penyewaId'));

        if ($this->request->getPost('action') == 'export') {

            // Get the current date and time
            $currentDateTime = Time::now();

            // Format the date according to your desired format
            $formattedDate = $currentDateTime->format('l, d F Y');

            $pembayaranList = $pembayaranModel->getPembayaranByPembayaranIdList($idPembayarans)->get()->getResultArray();
            $data = [
                'pembayaranList' => $pembayaranList,
                'penyewa' => $penyewa,
                'tanggal' => $formattedDate
            ];

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);

            $html = view('transaksi/pdf-transaksi', $data);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('bukti_transaksi.pdf', ['Attachment' => false]);
        } else {
            foreach ($idPembayarans as $idPembayaran) {
                $pembayaran = $pembayaranModel->find($idPembayaran);
                $pembayaran['catatan'] = $this->request->getPost('catatan');
                $pembayaran['status_pembayaran'] = $this->request->getPost('sudahBayar');

                $pembayaranModel->save($pembayaran);
            }
        }

        return redirect()->to('/transaksi-progress')->with('success', 'Data Transaksi Berhasil Disimpan');
    }

    public function generatePDFTransaksiAll($id)
    {
        // Get the current date and time
        $currentDateTime = Time::now();

        // Format the date according to your desired format
        $formattedDate = $currentDateTime->format('l, d F Y');

        $pembayaranModel = new Pembayaran();
        $pembayaranList = $pembayaranModel->getPembayaranByStatus($id)->get()->getResultArray();

        $targetIndex = 0;
        $totalRowSpan = 0;
        $totalTransCost = [];
        $getTransCost = 0;
        foreach ($pembayaranList as $index => &$pembayaran) {
            $nextIndex = $index + 1;

            // Create a Time object from the date value
            $tgl_pembayaran = new Time($pembayaran['tanggal_pembayaran']);
            $tgl_sewa = new Time($pembayaran['tanggal_mulai_sewa']);
            // Format the Time object to remove hours, minutes, and seconds
            $pembayaran['tanggal_pembayaran'] = $tgl_pembayaran->format('d-m-Y');
            $pembayaran['tanggal_mulai_sewa'] = $tgl_sewa->format('d-m-Y');

            if (count($pembayaranList) > 1) {
                if ($nextIndex < count($pembayaranList)) {
                    //if current data related to the next data
                    if ($pembayaran['transaction_id'] == $pembayaranList[$nextIndex]['transaction_id']) {
                        $totalRowSpan++;
                        $getTransCost += $pembayaran['lama_sewa'] * $pembayaran['jumlah_tenda'] * $pembayaran['harga_tenda'];
                    } else {
                        $totalRowSpan++;
                        $pembayaranList[$targetIndex]['rowspan'] = $totalRowSpan;

                        $getTransCost += $pembayaran['lama_sewa'] * $pembayaran['jumlah_tenda'] * $pembayaran['harga_tenda'];
                        array_push($totalTransCost, $getTransCost);

                        $getTransCost = 0;
                        $totalRowSpan = 0;

                        $targetIndex = $nextIndex;
                    }
                }
                // check if its the last data
                if ($index == (count($pembayaranList)) - 1) {
                    if ($pembayaran['transaction_id'] != $pembayaranList[$index - 1]['transaction_id']) {
                        $pembayaran['rowspan'] = 1;
                    } else {
                        $totalRowSpan++;
                        $pembayaranList[$targetIndex]['rowspan'] = $totalRowSpan;
                    }
                    $getTransCost += $pembayaran['lama_sewa'] * $pembayaran['jumlah_tenda'] * $pembayaran['harga_tenda'];
                    array_push($totalTransCost, $getTransCost);
                    $getTransCost = 0;
                }
            } else {
                $pembayaran['rowspan'] = $totalRowSpan;
                $getTransCost += $pembayaran['lama_sewa'] * $pembayaran['jumlah_tenda'] * $pembayaran['harga_tenda'];
                array_push($totalTransCost, $getTransCost);
                $getTransCost = 0;
            }
        }

        $data = [
            'pembayaranList' => $pembayaranList,
            'tanggal' => $formattedDate,
            'totalTransCost' => $totalTransCost
        ];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $html = view('transaksi/pdf-transaksi-all', $data);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan_transaksi.pdf', ['Attachment' => false]);
    }
}
