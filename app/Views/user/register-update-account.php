<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
    <div class="row">
        <div class="col-12">
        <div class="card <?= $cardAlignment ?? "" ?>">
            <div class="card-header">
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                <?= $cardReload;?>                       
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
                    <form class="form" action="<?= site_url('register-update-account') ?>" method="post" id="registrationForm">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="action" value="<?= $action ?>" />
                    <input type="hidden" name="userId" value="<?= $userId ?? "" ?>" />
                    <input type="hidden" name="penyewaId" value="<?= $penyewaId ?? "" ?>" />
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
                            <div class="form-group">
                                <label>Username</label><strong style="color: red"> *</strong>
                                <input type="text" value="<?= $username ?? "" ?>" class="form-control" placeholder="Username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>E-mail</label><strong style="color: red"> *</strong>
                                <input type="email" value="<?= $email ?? "" ?>" class="form-control" placeholder="E-mail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label><strong style="color: red"> *</strong>
                                <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Masukkan Ulang Password</label>
                                <input type="password" id="retypePassword" class="form-control" placeholder="Masukkan Ulang Password" name="retypePassword" required>
                            </div>
                            <strong style="color: red" id="errorRetypePassword"></strong>
                        </div>
                        <div class="form-actions center">
                                <?php if (session()->get('user')) : ?>
									<button type="submit" class="btn btn-info btn-min-width mr-1 mb-1">Ubah</button>
								<?php else :?> 
									<button type="submit" class="btn btn-info btn-min-width mr-1 mb-1">Daftar</button>
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

<?= $this->section('js') ?>
<script>
    document.getElementById('registrationForm').onsubmit = function (event) {
        event.preventDefault();
        // Get the values of password and retype password fields
        var password = document.getElementById('password').value;
        var retypePassword = document.getElementById('retypePassword').value;

        // Check if password and retype password match
        if (password === retypePassword) {
            // If they match, submit the form
            this.submit();
        } else {
            // If they don't match, show an error message or perform any other action
            document.getElementById("errorRetypePassword").innerText = "Password dan Masukkan Ulang Password Tidak Sama";
        }
    };
</script>
<?= $this->endSection() ?>