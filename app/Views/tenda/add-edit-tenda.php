<?= $this->extend('base-layout/admin-header-sidebar-footer') ?>
<?= $this->section('content') ?>
<div class="row">
        <div class="col-12">
        <div class="card <?= $cardAlignment ?? "" ?>">
            <div class="card-header">
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">                   
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
            </div>
            <div class="card-content collapse show">
            <div class="card-body">     
                <?php if (session()->getFlashdata('error')) : ?>
                    <p><code class="highlighter-rouge"><?= session()->getFlashdata('error') ?></code></p>                    
                <?php endif; ?>       
                <div class = "col-md-6 mx-auto text-center">
                    <form class="form" action="<?= site_url('add-edit-tenda') ?>" method="post" id="registrationForm" enctype="multipart/form-data">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="action" value="<?= $action ?>" />
                    <input type="hidden" name="tendaId" value="<?= $tendaId ?? "" ?>" />
                        <div class="form-body">
                            <div class="form-group">
                                <label>Kode</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $kode ?? "" ?>" class="form-control" placeholder="Kode" name="kode" required>
                            </div>
                            <div class="form-group">
                                <label>Nama</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $nama ?? "" ?>" class="form-control" placeholder="Nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label><strong style="color: red"> *</strong>
                                <fieldset class="form-group">
                                    <select class="form-control" id="basicSelect" name="kategoriId" required>
                                        <?php foreach($kategoriList as $kategori): ?>
                                        <option value = <?= $kategori['id'] ?> <?= $kategoriId == $kategori['id'] ? "selected":""; ?>><?= $kategori['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <label>Ukuran</label><strong style="color: red"> *</strong>
                                <input type="number" value="<?= $ukuran ?? "" ?>" class="form-control" placeholder="Ukuran" name="ukuran" required min = "0">
                            </div>
                            <div class="form-group">
                                <label>Harga</label><strong style="color: red"> *</strong>
                                <input type="number" value="<?= $harga ?? "" ?>" class="form-control" placeholder="Harga" name="harga" required min = "0">
                            </div>
                            <div class="form-group">
                                <label>Kuantitas</label><strong style="color: red"> *</strong>
                                <input type="number" value="<?= $sisa ?? "" ?>" class="form-control" placeholder="Kuantitas" name="sisa" required min = "0">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" accept="image/jpeg, image/png, image/gif" name="gambar"><br>
                                <p>Current File :</p>
                                <img <?= site_url('download/' . ($gambar ?? "")) ?> alt="Gambar Tenda" >
                            </div>
                        </div>
                        <div class="form-actions center">&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php if ($action == 'edit') : ?>
									<button type="submit" class="btn btn-success btn-min-width mr-1 mb-1" onclick="return confirm('Simpan Data?')">Ubah</button>
								<?php else :?> 
									<button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1" onclick="return confirm('Simpan Data?')">Tambah</button>
								<?php endif; ?>	                            
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection() ?>