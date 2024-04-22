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
                    <form class="form" action="<?= site_url('edit-penyewa') ?>" method="post" id="registrationForm">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="userId" value="<?= $penyewaId ?? "" ?>" />
                        <div class="form-body">
                        <div class="form-group">
                                <label>NIK</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $nik ?? "" ?>"  class="form-control" placeholder="NIK" name="nik" maxlength = "15" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="form-group">
                                <label>Nama</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $nama ?? "" ?>" id="donationinput2" class="form-control" placeholder="Nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $noHp ?? "" ?>" class="form-control" placeholder="No Handphone" name="noHp" maxlength = "13" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label><strong style="color: red"> *</strong>
                                <textarea name="alamat" id="inputAlamat" cols="30" rows="10" class="form-control" required><?= $alamat ?? "" ?></textarea>
                            </div>
                        </div>
                        <div class="form-actions center">
                            <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1" onclick="return confirm('Simpan Data?')">Ubah</button>                           
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
<?= $this->endSection() ?>