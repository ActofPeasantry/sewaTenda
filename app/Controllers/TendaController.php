<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tenda;
use App\Models\Kategori;

class TendaController extends BaseController
{
    public function index()
    {
        $tendaModel = new Tenda();
        $tendaList = $tendaModel->getTendasWithKategoris()->get()->getResultArray();

        $data = [
        'headerTitle' => 'Tenda',
        'navTendaActive' => 'active',
        'breadcrumbLink' => '<a href="/dashboard">Dashboard</a>',
        'tendaList' => $tendaList
       ];
        return view('tenda/index-tenda', $data);
    }

    public function addEditTendaView()
    {
        $kategoriModel = new Kategori();
        $kategoriList = $kategoriModel->findAll();

        $data = [
            'headerTitle' => 'Tenda',
            'navTendaActive' => 'active',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/tenda">Back</a>',
            'kategoriList' => $kategoriList
        ];

        if($this->request->getPost('action') == 'add'){
            $data+=[
                'kategoriId' => "",
                'action' => 'add'
            ];
        }else{
            $tendaModel = new Tenda();
            $tenda = $tendaModel->find($this->request->getPost('tendaId'));
            $data+=[
                'action' => 'edit',
                'tendaId' => $tenda['id'],
                'kode' => $tenda['kode'],
                'nama' => $tenda['nama'],
                'ukuran' => $tenda['ukuran'],
                'harga' => $tenda['harga'],
                'sisa' => $tenda['sisa'],
                'gambar' => $tenda['gambar'],
                'kategoriId' => $tenda['kategori_id'],
            ];
        }

        return view('tenda/add-edit-tenda', $data);
    }

    public function addEditTenda()
    {
        $tendaModel = new Tenda();

        $fileGambar = $this->request->getFile('gambar');
        $newName = md5(uniqid(rand(), true)) . '.' . $fileGambar->getExtension();

        $tendaRequest = [
            'kode' => $this->request->getPost('kode'),
            'nama' => $this->request->getPost('nama'),
            'ukuran' => $this->request->getPost('ukuran'),
            'harga' => $this->request->getPost('harga'),
            'sisa' => $this->request->getPost('sisa'),
            'kategori_id' => $this->request->getPost('kategoriId'),
            'is_delete' => 0
        ];

        if($this->request->getPost('action') == 'add'){

            $tenda = $tendaModel->where('kode', $this->request->getPost('kode'))->first();
            
            if($tenda){
                return redirect()->to('/tenda')->with('error', 'Kode Sudah Ada');           
            }

            if($fileGambar->isValid()){
                // Move the file to the uploads directory with the new name
                $fileGambar->move(WRITEPATH . 'uploads', $newName);
    
                $tendaRequest['gambar'] = $newName;
            }

            $tendaModel->insert($tendaRequest);

        }else{

            $tenda = $tendaModel->where('kode', $this->request->getPost('kode'))->first();

            if ($tenda && $tenda['id'] != $this->request->getPost('tendaId')){
                return redirect()->to('/tenda')->with('error', 'Kode Sudah Ada'); 
            }

            if($fileGambar->isValid() && $tenda['gambar']!=$fileGambar->getClientName()){
                // Move the file to the uploads directory with the new name
                $fileGambar->move(WRITEPATH . 'uploads', $newName);
                $tendaRequest['gambar'] = $newName;
            }

            $tendaModel->update((int)$this->request->getPost('tendaId'), $tendaRequest);
        }
        
        return redirect()->to('/tenda')->with('success', 'Perubahan Data Tenda Berhasil');
    }

    public function deleteTenda($id)
    {
       $tendaModel = new Tenda();

       $tenda = $tendaModel->find($id);
       $tenda['is_deleted'] = 1;

       $tendaModel->update($tenda['id'], $tenda);

       $tendaModel->delete($tenda['id']);
       return redirect()->to('/tenda')->with('success', 'Data Tenda Berhasil Dihapus');
    }
    public function indexKategori()
    {
        $kategoriModel = new Kategori();
        $kategoriList = $kategoriModel->findAll();

        $data = [
        'headerTitle' => 'Kategori',
        'navTendaActive' => 'active',
        'breadcrumbLink' => '<a href="/tenda">Tenda</a>',
        'kategoriList' => $kategoriList
       ];
        return view('tenda/index-kategori-tenda', $data);
    }
    
    public function addEditKategoriView()
    {
        $data = [
            'headerTitle' => 'Kategori',
            'navTendaActive' => 'active',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/kategori">Back</a>',
        ];

        if($this->request->getPost('action') == 'add'){
            $data+=[
                'action' => 'add'
            ];
        }else{
            $kategoriModel = new Kategori();
            $kategori = $kategoriModel->find($this->request->getPost('kategoriId'));
            $data+=[
                'action' => 'edit',
                'kategoriId' => $kategori['id'],
                'kode' => $kategori['kode'],
                'nama' => $kategori['nama'],
            ];
        }

        return view('tenda/add-edit-kategori-tenda', $data);
    }

    public function addEditKategori()
    {
        $kategoriModel = new Kategori();

        $kategoriRequest = [
            'kode' => $this->request->getPost('kode'),
            'nama' => $this->request->getPost('nama'),
            'is_delete' => 0
        ];

        if($this->request->getPost('action') == 'add'){

            $kategori = $kategoriModel->where('kode', $this->request->getPost('kode'))->first();

            if($kategori){
                return redirect()->to('/kategori')->with('error', 'Kode Sudah Ada');
            }

            $kategoriModel->insert($kategoriRequest);

        }else{

            $kategori = $kategoriModel->where('kode', $this->request->getPost('kode'))->first();

            if ($kategori && $kategori['id'] != $this->request->getPost('kategoriId')){
                return redirect()->to('/kategori')->with('error', 'Kode Sudah Ada');
            }

            $kategoriModel->update((int)$this->request->getPost('kategoriId'), $kategoriRequest);
        }
        
        return redirect()->to('/kategori')->with('success', 'Perubahan Data Kategori Berhasil');
    }

    public function delete($id)
    {
       $kategoriModel = new Kategori();;

       $kategori = $kategoriModel->find($id);
       $kategori['is_deleted'] = 1;

       $kategoriModel->update($kategori['id'], $kategori);

       $kategoriModel->delete($kategori['id']);
       return redirect()->to('/kategori')->with('success', 'Data Kategori Berhasil Dihapus');
    }
}
