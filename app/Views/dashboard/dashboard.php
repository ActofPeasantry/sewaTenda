<?= $this->extend('base-layout/admin-header-sidebar-footer') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-xl-4 col-lg-6 col-md-12">
        <div class="card pull-up ecom-card-1 bg-white">
            <div class="card-content ecom-card2 height-100">
                <h5 class="text-muted info position-absolute p-1">Transaksi Progress</h5>
                <div>
                    <i class="ft-activity info font-large-1 float-right p-1"></i>
                </div>
                <a href="/transaksi-progress"><h1 class="text-muted info position-absolute p-5"><?= $transaksiProgress ?> Transaksi</h1></a>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card pull-up ecom-card-1 bg-white">
            <div class="card-content ecom-card2 height-100">
                <h5 class="text-muted warning position-absolute p-1">Transaksi Approved</h5>
                <div>
                    <i class="la la-check-circle warning font-large-1 float-right p-1"></i>
                </div>
                <a href="/transaksi-approved"><h1 class="text-muted warning position-absolute p-5"><?= $transaksiApproved ?> Transaksi</h1></a>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-12">
        <div class="card pull-up ecom-card-1 bg-white">
            <div class="card-content ecom-card2 height-100">
                <h5 class="text-muted danger position-absolute p-1">Transaksi Rejected</h5>
                <div>
                    <i class="la la-times-circle danger font-large-1 float-right p-1"></i>
                </div>
                <a href="/transaksi-rejected"><h1 class="text-muted danger position-absolute p-5"><?= $transaksiRejected ?> Transaksi</h1></a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>