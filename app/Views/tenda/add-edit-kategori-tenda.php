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
                    <form class="form" action="<?= site_url('add-edit-kategori-tenda') ?>" method="post" id="registrationForm">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="action" value="<?= $action ?>" />
                    <input type="hidden" name="kategoriId" value="<?= $kategoriId ?? "" ?>" />
                        <div class="form-body">
                            <div class="form-group">
                                <label>Kode</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $kode ?? "" ?>" class="form-control" placeholder="Kode" name="kode" required>
                            </div>
                            <div class="form-group">
                                <label>Nama</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $nama ?? "" ?>" class="form-control" placeholder="Nama" name="nama" required>
                            </div>
                        </div>
                        <div class="form-actions center">
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