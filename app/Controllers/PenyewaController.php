<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailPembayaran;
use App\Models\Tenda;
use App\Models\Pembayaran;
use App\Models\Penyewa;
use App\Models\Invoice;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\I18n\Time;

class PenyewaController extends BaseController
{
    public function index()
    {
        $penyewaModel = new Penyewa();
        $penyewaList = $penyewaModel->getPenyewa()->get()->getResultArray();

        $data = [
            'headerTitle' => 'Penyewa',
            'navPenyewaActive' => 'active',
            'breadcrumbLink' => '<a href="/dashboard">Dashboard</a>',
            'penyewaList' => $penyewaList
        ];
        return view('penyewa/index-penyewa', $data);
    }

    public function catalog()
    {
        if (session()->get('user')) {
            if (session()->get('role')['kode'] == 'ADM') {
                return redirect()->to('/dashboard');
            }
        }

        $tendaModel = new Tenda();
        $tendaList = $tendaModel->getTendasWithKategoris();

        $data = [
            'cardReload' => '',
            'headerTitle' => 'Rama Tenda : Catalog',
            'breadcrumbLink' => session()->get('user') ? '<a href="/cart">Cart</a> - <a href="/pesanan">Pembayaran</a> - <a href="/prosespesanan">Menu Pembayaran</a>' : '<a href="/login">Login</a>',
            'tendaList' => $tendaList->paginate(6, 'tenda'),
            'pager' => $tendaList->pager,
            'nomor' => nomor($this->request->getVar('page_tenda'), 6),
        ];
        return view('penyewa/catalog-tenda', $data);
    }

    public function cart()
    {
        $data = [
            'cardReload' => '',
            'headerTitle' => 'Cart',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a> - <a href="/pesanan">Pembayaran</a> - <a href="/cart">Menu Pembayaran</a>',
        ];
        return view('penyewa/cart', $data);
    }

    public function submitPembayaran()
    {
        $tendaList = json_decode($this->request->getVar('tendaList'), true);
        $alamat = $this->request->getVar('alamat');
        $tanggalMulaiSewa = $this->request->getVar('tanggalMulaiSewa');

        $pembayaranModel = new Pembayaran();
        $pembayaranData = [
            'alamat_kirim' => $alamat,
            'tanggal_mulai_sewa' => $tanggalMulaiSewa,
            'user_id' => session()->get('user')['id'],
            'status_pembayaran' => 3, //unpaid status number
        ];
        $pembayaranModel->insert($pembayaranData);
        $pembayaranId = $pembayaranModel->insertID();

        // Loop through each Tenda in the TendaList
        foreach ($tendaList as $tenda) {
            $detailPembayaranModel = new DetailPembayaran();
            $detailPembayaranData = [
                'item_id' => $tenda['id'],
                'transaction_id' => $pembayaranId, // Use the retrieved Pembayaran ID
                'jumlah_tenda' => $tenda['newQuantity'],
                'lama_sewa' => $tenda['jumlahHari'],
                'is_deleted' => 0,
            ];
            $detailPembayaranModel->insert($detailPembayaranData);

            // Update the 'sisa' quantity of the Tenda
            $tendaModel = new Tenda();
            $newTenda = $tendaModel->find($tenda['id']);
            $newTenda['sisa'] = $newTenda['sisa'] - $tenda['newQuantity'];
            $tendaModel->save($newTenda);
        }

        return $this->response->setJSON(['status' => 'success']);
    }
    public function pesanan()
    {
        $pembayaranModel = new Pembayaran();

        // $pembayaranBelumBayarList = $pembayaranModel->getPembayaranBelumBayarWithTenda(session()->get('penyewa')['id'])->get()->getResultArray();
        $pembayaranBelumBayarList = $pembayaranModel->getUnpaidPembayaran(session()->get('user')['id'])->get()->getResultArray();
        $getCost = $pembayaranModel->getPembayaranCost(session()->get('user')['id'], false);
        // var_dump($getCost);


        $data = [
            'cardReload' => '',
            'headerTitle' => 'Pesanan',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a> - <a href="/prosespesanan">Menu Pembayaran</a> - <a href="/cart">Cart</a>',
            'pembayaranBelumBayarList' => $pembayaranBelumBayarList,
            'totalBiaya' => $getCost
        ];
        return view('penyewa/pesanan', $data);
    }

    public function detailPesanan($pesananId)
    {
        $detailModel = new DetailPembayaran();
        $detail = $detailModel->getDetailByPembayaranId($pesananId)->get()->getResultArray();

        return $this->response->setJSON($detail);
    }

    public function historyPesanan()
    {
        $pembayaranModel = new Pembayaran();

        $pembayaranSudahBayarList = $pembayaranModel->getPaidPembayaran(session()->get('user')['id'])->get()->getResultArray();
        $getCost = $pembayaranModel->getPembayaranCost(session()->get('user')['id'], true);

        $data = [
            'cardReload' => '',
            'headerTitle' => 'Pesanan',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a> - <a href="/pesanan">Pembayaran</a> - <a href="/cart">Cart</a>',
            'pembayaranSudahBayarList' => $pembayaranSudahBayarList,
            'totalBiaya' => $getCost
        ];
        return view('penyewa/historyPesanan', $data);
    }

    public function updatePembayaranFromPesanan()
    {
        $idPembayarans = $this->request->getPost('idPembayarans');

        $pembayaranModel = new Pembayaran();
        $invoiceModel = new Invoice();

        $PenyewaModel = new Penyewa();
        $penyewa = $PenyewaModel->find(session()->get('user')['id']);

        if ($this->request->getPost('action') == 'export') {
            $idPembayarans = $this->request->getPost('idPembayarans1');
            if (empty($idPembayarans)) {
                return redirect()->back()->with('error', 'error');
            }
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

            $html = view('transaksi/pdf-transaksi-1', $data);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('bukti_transaksi.pdf', ['Attachment' => false]);
        } else {
            if (empty($idPembayarans)) {
                return redirect()->back()->with('error', 'error');
            }
            if ($this->request->getPost('submit1') !== null) {

                $filebuktiPembayaran = $this->request->getFile('bukti');

                $newName = md5(uniqid(rand(), true)) . '.' . $filebuktiPembayaran->getExtension();

                // Move the file to the uploads directory with the new name
                $filebuktiPembayaran->move(WRITEPATH . 'uploads', $newName);

                $tanggalPembayaran = $this->request->getPost('tanggalPembayaran');

                foreach ($idPembayarans as $idPembayaran) {
                    $pembayaran = $pembayaranModel->find($idPembayaran);
                    $invoice = array();

                    if ($this->request->getPost('payment_method') == 0) { //Non DP
                        $pembayaran['status_lunas'] = 1;
                        $pembayaran['pakai_dp'] = $this->request->getPost('payment_method');
                        $invoice['transaction_id'] = $pembayaran['id'];
                        $invoice['bukti_pembayaran'] = $newName;
                    }
                    if ($this->request->getPost('payment_method') == 1) { //DP
                        $pembayaran['pakai_dp'] = $this->request->getPost('payment_method');
                        $invoice['transaction_id'] = $pembayaran['id'];
                        $invoice['bukti_pembayaran_dp'] = $newName;
                    }
                    $pembayaran['tanggal_pembayaran'] = $tanggalPembayaran;
                    $pembayaran['status_pembayaran'] = 2;
                    $pembayaranModel->save($pembayaran);
                    $invoiceModel->save($invoice);
                }
                return redirect()->back()->with('success', 'success');
            } else {
                if (($this->request->getPost('submit2') === null && $this->request->getPost('submit3') === null)) {
                    return redirect()->back()->with('error', 'error');
                }
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

                if ($this->request->getPost('submit3') !== null) {
                    $data['dp'] = floatval(array_sum(array_map(function ($item) {
                        return ($item['harga'] * $item['lama_sewa'] * $item['jumlah_tenda']) * (10 / 100);
                    }, $pembayaranList)));
                }

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);

                $html = view('transaksi/pdf-transaksi', $data);

                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream('invoice.pdf', ['Attachment' => false]);
            }
        }

        return redirect()->back();
    }

    public function updatePelunasan()
    {
        $idPembayaran = $this->request->getPost('orderId');
        $pembayaranModel = new Pembayaran();
        $pembayaran = $pembayaranModel->find($idPembayaran);

        $filebuktiPembayaran = $this->request->getFile('bukti');
        $newName = md5(uniqid(rand(), true)) . '.' . $filebuktiPembayaran->getExtension();
        // Move the file to the uploads directory with the new name
        $filebuktiPembayaran->move(WRITEPATH . 'uploads', $newName);

        $tanggalPembayaran = $this->request->getPost('tanggalPembayaran');

        $pembayaran['status_lunas'] = 1;
        $pembayaran['bukti_pembayaran'] = $newName;
        $pembayaran['tanggal_pembayaran'] = $tanggalPembayaran;
        $pembayaranModel->save($pembayaran);

        return redirect()->back()->with('success', 'success');
    }

    public function editPenyewaView()
    {
        $data = [
            'headerTitle' => 'Penyewa',
            'navPenyewaActive' => 'active',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/penyewa">Back</a>',
        ];

        $penyewaModel = new Penyewa();
        $penyewa = $penyewaModel->find($this->request->getPost('penyewaId'));
        $data += [
            'penyewaId' => $penyewa['id'],
            'nik' => $penyewa['nik'],
            'nama' => $penyewa['nama'],
            'alamat' => $penyewa['alamat'],
            'noHp' => $penyewa['no_hp'],
        ];

        return view('penyewa/edit-penyewa', $data);
    }

    public function editPenyewa()
    {
        $penyewaModel = new Penyewa();

        $penyewaRequest = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('noHp')
        ];

        $penyewa = $penyewaModel->where('nik', $this->request->getPost('nik'))->first();

        if ($penyewa['id'] != $this->request->getPost('penyewaId')) {

            return redirect()->to('/penyewa')->with('error', 'NIK Sudah Ada');
        }

        $penyewaModel->update((int)$this->request->getPost('penyewaId'), $penyewaRequest);

        return redirect()->to('/penyewa')->with('success', 'Perubahan Data Penyewa Berhasil');
    }

    public function delete($id)
    {

        $penyewaModel = new Penyewa();

        $penyewa = $penyewaModel->find($id);
        $penyewa['is_deleted'] = 1;

        $penyewaModel->update($penyewa['id'], $penyewa);

        $penyewaModel->delete($penyewa['id']);

        return redirect()->to('/penyewa')->with('success', 'Data Penyewa Berhasil Dihapus');
    }
}
