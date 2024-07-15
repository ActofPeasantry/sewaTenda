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
          <h1>Ubah Password</h1>

          <?php if (isset($validation)) : ?>
            <div class="alert alert-danger">
              <?= $validation->listErrors() ?>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
              <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
              <?= session()->getFlashdata('success') ?>
            </div>
          <?php endif; ?>

          <div class="col-md-3 mx-auto text-center">
            <form class="form" action="<?= site_url('reset-password') ?>" method="post">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <div class="form-body">
                <div class="form-group">
                  <label for="password" class="sr-only">Password</label>
                  <input type="password" id="password" class="form-control" placeholder="Password" name="password">
                </div>
                <input type="hidden" name="token" value="<?= $token ?>">
              </div>
              <div class="form-actions center">
                <button type="submit" class="btn btn-info btn-min-width mr-1 mb-1">Confirm Password</button>
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