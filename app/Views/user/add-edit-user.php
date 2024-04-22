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
                    <form class="form" action="<?= site_url('add-edit-user') ?>" method="post" id="registrationForm">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="action" value="<?= $action ?>" />
                    <input type="hidden" name="userId" value="<?= $userId ?? "" ?>" />
                        <div class="form-body">
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