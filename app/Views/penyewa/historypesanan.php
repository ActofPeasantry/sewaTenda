<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Proses Pesanan</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<form action="<?= site_url('update-pembayaran-from-pesanan') ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<input type="hidden" name="action" value="export" />
					<div class="form-row align-items-center">
						<div class="col-auto my-1">
							<button type = "submit" class="btn btn-primary" onclick = "return confirm('Cetak Data Transaksi?');"><i class="la la-print"></i></button>							
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-borderless table-hover" id="myTable1">
							<thead>
								<tr>
									<th><input type="checkbox" id="check-all1"></th>
									<th>No</th>
									<th>Tenda</th>
									<th>Lama Sewa</th>
									<th>Jumlah Tenda</th>
									<th>Alamat Kirim</th>
									<th>Tanggal Mulai Sewa</th>
									<th>Tanggal Pembayaran</th>
									<th>Bukti Pembayaran</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
									<?php $i = 1?>
									<?php foreach($pembayaranSudahBayarList as $pembayaranSudahBayar): ?>
										<tr>
											<td><input type="checkbox" value=<?= $pembayaranSudahBayar['id'] ?> name="idPembayarans1[]" <?= $pembayaranSudahBayar['sudah_bayar'] == 1?"":"disabled"?>></td>
											<td><?= $i ?></td>
											<td><?= $pembayaranSudahBayar['nama'] ?> <?= $pembayaranSudahBayar['ukuran'] ?></td>
											<td><?= $pembayaranSudahBayar['lama_sewa'] ?> Hari</td>
											<td><?= $pembayaranSudahBayar['jumlah_tenda'] ?></td>
											<td><?= $pembayaranSudahBayar['alamat_kirim'] ?></td>
											<td><?= $pembayaranSudahBayar['tanggal_mulai_sewa'] ?></td>
											<td><?= $pembayaranSudahBayar['tanggal_pembayaran'] ?></td>
											<td><a href="<?= site_url('download/' . $pembayaranSudahBayar['bukti_pembayaran']) ?>" download>Download</a></td>
											<?php if ($pembayaranSudahBayar['sudah_bayar'] == 1) : ?>
												<td><p><code class="highlighter-rouge success">Selesai</code></p></td>
											<?php elseif ($pembayaranSudahBayar['sudah_bayar'] == 2) :?> 
												<td><p><code class="highlighter-rouge warning">Sedang Proses</code></p></td>
											<?php else :?> 
												<td><p><code class="highlighter-rouge danger">Dibatalkan</code></p></td>
											<?php endif; ?>											
										</tr>
									<?php $i++?>
									<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				 </form>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    let table1 = new DataTable('#myTable1', {
		"columns": [
					{ "width": "5%" },
					{ "width": "10%" },
					{ "width": "5%" },
					{ "width": "5%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "5%" }
				]
    });

	const checkAllCheckbox1 = document.getElementById('check-all1');
	const checkboxes1 = document.querySelectorAll('input[name="idPembayarans1[]"]');

	checkAllCheckbox1.addEventListener('change', function() {
		checkboxes1.forEach(checkbox => {
			checkbox.checked = checkAllCheckbox1.checked;
		});
	});

</script>
<?= $this->endSection() ?>