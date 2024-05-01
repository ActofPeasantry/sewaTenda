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
								<button type="submit" class="btn btn-primary" onclick="return confirm('Cetak Data Transaksi?');"><i class="la la-print"></i></button>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-borderless table-hover" id="myTable1">
								<thead>
									<tr>
										<th><input type="checkbox" id="check-all1"></th>
										<th>No</th>
										<th>Alamat Kirim</th>
										<th>Tanggal Mulai Sewa</th>
										<th>Total Biaya</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1 ?>
									<?php foreach ($pembayaranSudahBayarList as $pembayaranSudahBayar) : ?>
										<tr>
											<td><input type="checkbox" value=<?= $pembayaranSudahBayar['id'] ?> name="idPembayarans1[]" <?= $pembayaranSudahBayar['sudah_bayar'] == 1 ? "" : "disabled" ?>></td>
											<td><?= $i ?></td>
											<td><?= $pembayaranSudahBayar['alamat_kirim'] ?></td>
											<td><?= $pembayaranSudahBayar['tanggal_mulai_sewa'] ?></td>
											<td><?= $totalBiaya[$i - 1] ?></td>
											<?php if ($pembayaranSudahBayar['sudah_bayar'] == 1) : ?>
												<td>
													<p><code class="highlighter-rouge success">Selesai</code></p>
												</td>
											<?php elseif ($pembayaranSudahBayar['sudah_bayar'] == 2) : ?>
												<td>
													<p><code class="highlighter-rouge warning">Sedang Proses</code></p>
												</td>
											<?php else : ?>
												<td>
													<p><code class="highlighter-rouge danger">Dibatalkan</code></p>
												</td>
											<?php endif; ?>
											<td>
												<a class="btn btn-sm btn-success" href="<?= site_url('download/' . $pembayaranSudahBayar['bukti_pembayaran']) ?>" download>Unduh Bukti Pembayaran</a>
												<button type="button" class="btn btn-sm btn-info show-button" data-toggle="modal" data-target="#modal-pesanan" data-id="<?= $pembayaranSudahBayar['id'] ?>">
													<i class="ft-edit"></i> Detail</a>
												</button>
											</td>
										</tr>
										<?php $i++ ?>
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
<!-- Detail Modal -->
<div id="modal-pesanan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog  modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Detail Alternatif</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-borderless table-hover detail-table">
					<thead>
						<tr>
							<th>Nama Tenda</th>
							<th>Jumlah Pesanan</th>
							<th>Ukuran Tenda</th>
							<th>Lama Sewa</th>
							<th>Harga Tenda</th>
							<th>Harga Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>

						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
	let table1 = new DataTable('#myTable1', {
		"columns": [{
				"width": "5%"
			},
			{
				"width": "10%"
			},
			{
				"width": "5%"
			},
			{
				"width": "5%"
			},
			{
				"width": "10%"
			},
			{
				"width": "10%"
			},
			{
				"width": "10%"
			},
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

<script>
	$(document).ready(function() {
		$('.show-button').on('click', function() {
			var id = $(this).data('id');
			$.ajax({
				method: 'GET',
				url: '/pesanan/detail/' + id,
				dataType: 'json',
				success: function(response) {
					console.log(response);
					if (response && response.length > 0) {
						$('.detail-table tbody').empty();

						response.forEach(function(item) {
							$('.detail-table tbody').append(
								'<tr>' +
								'<td>' + item.nama + '</td>' +
								'<td>' + item.jumlah_tenda + '</td>' +
								'<td>' + item.ukuran + '</td>' +
								'<td>' + item.lama_sewa + '</td>' +
								'<td>' + item.harga + '</td>' +
								'<td>' + item.lama_sewa * item.jumlah_tenda * item.harga + '</td>' +
								'</tr>'
							);
						});
					} else {
						console.log(id);
						$('.detail-table tbody').html('<tr><td colspan="3">No data available</td></tr>');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error fetching data:', error);
				}
			});
		});
	});
</script>
<?= $this->endSection() ?>