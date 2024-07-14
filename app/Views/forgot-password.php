<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card <?= $cardAlignment ?? "" ?>">
      <div class="card-header">
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <?= $cardReload; ?>
            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-content collapse show">
        <div class="card-body">
          <h1>Halaman Lupa Password</h1>

          <?php if (isset($validation)) : ?>
            <div class="alert alert-danger">
              <?php $validation->listErrors() ?>
            </div>
          <?php endif; ?>

          <div class="col-md-3 mx-auto text-center">
            <form class="form" action="<?= site_url('forgot-password') ?>" method="post">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <div class="form-body">
                <div class="form-group">
                  <label for="donationinput3" class="sr-only">E-mail</label>
                  <input type="email" id="donationinput3" class="form-control" placeholder="E-mail" name="email">
                </div>

              </div>
              <div class="form-actions center">
                <button type="submit" class="btn btn-info btn-min-width mr-1 mb-1">Reset Password</button>
              </div>
              <div class="center">
                <p>Belum Punya Akun? Silahkan <a href="/register-update-account" class="danger"><code class="highlighter-rouge">Daftar.</code></a></p>
                <p> <a href="/login" class="danger"><code class="highlighter-rouge">Balik ke Login.</code></a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>