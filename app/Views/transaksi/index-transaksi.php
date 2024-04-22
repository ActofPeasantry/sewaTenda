<?= $this->extend('base-layout/admin-header-sidebar-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Daftar Transaksi <?= $status==1?"Approved":($status==2?"progress":"Rejected") ?? ""?></h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <p><code class="highlighter-rouge success"><?= session()->getFlashdata('success') ?></code></p>                    
                    <?php endif; ?>
					<?php if (session()->getFlashdata('error')) : ?>
                        <p><code class="highlighter-rouge danger"><?= session()->getFlashdata('error') ?></code></p>                    
                    <?php endif; ?>
					<a class="btn <?= $btnInfo ?? "btn-primary"?> btn-min-width mr-1 mb-1" href = "/transaksi-progress"><i class="la la-chain"></i> Daftar Transaksi Progress</a>
					<a class="btn <?= $btnSuccess ?? "btn-primary"?> btn-min-width mr-1 mb-1" href = "/transaksi-approved"><i class="la la-thumbs-o-up"></i> Daftar Transaksi Approved</a>
					<a class="btn <?= $btnDanger ?? "btn-primary"?> btn-min-width mr-1 mb-1" href = "/transaksi-rejected"><i class="la la-times-circle-o"></i> Daftar Transaksi Rejected</a>
					<div class="btn-group mr-1 mb-1">
                                <button type="button" class="btn btn-light"><i class="la la-print"></i>Cetak</button>
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="download-pdf-transaksi-all/2">Transaksi Progress</a>
                                    <a class="dropdown-item" href="download-pdf-transaksi-all/1">Transaksi Approved</a>
                                    <a class="dropdown-item" href="download-pdf-transaksi-all/0">Transaksi Rejected</a>
                                </div>
                    </div>
					<div class="table-responsive">
						<table class="table table-striped table-borderless table-hover" id = "myTable">
							<thead>
								<tr>
									<th>No</th>
									<th style = "text-align : center">NIK</th>
									<th style = "text-align : center">Nama Penyewa</th>
									<th style = "text-align : center">No Hp</th>
									<th style = "text-align : center">Jumlah Pesanan</th>
									<th style = "text-align : center">Action</th>
									
								</tr>
							</thead>
							<tbody>
                                <?php $i = 1?>
                                <?php foreach($transaksiList as $transaksi): ?>
								<tr>
									<th scope="row"><?= $i ?></th>
									<td style = "text-align : center"><?=$transaksi['nik']?></td>
									<td style = "text-align : center"><?=$transaksi['nama']?></td>
									<td style = "text-align : center"><?=$transaksi['no_hp']?></td>
									<td style = "text-align : center"><?=$transaksi['jumlah_pesanan']?> Tenda</td>
									<td style = "text-align : center">
                                    <form action="/confirm-transaksi-view" method="post">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <input type="hidden" name = "penyewaId" value=<?=$transaksi['id']?>>
                                        <input type="hidden" name = "status" value=<?= $status ?>>
                                        <button type="submit" class="btn btn-sm btn-warning"><i class="la la-opencart"></i></button>
                                    </form>
                                    </td>
								</tr>
                                <?php $i++?>
                                <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    let table1 = new DataTable('#myTable', {

    });

</script>
<?= $this->endSection() ?>