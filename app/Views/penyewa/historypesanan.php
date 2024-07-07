<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Menu Pesanan</h4>
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
										<th>Tipe Pembayaran</th>
										<th>Total Biaya</th>
										<th>Status Transaksi</th>
										<th>Status Lunas</th>
										<th>Bukti Pembayaran</th>
										<th>Bukti Pembayaran DP</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1 ?>
									<?php foreach ($pembayaranSudahBayarList as $pembayaranSudahBayar) : ?>
										<tr>
											<td><input type="checkbox" value=<?= $pembayaranSudahBayar['id'] ?> name="idPembayarans1[]" <?= $pembayaranSudahBayar['status_pembayaran'] == 1 ? "" : "disabled" ?>></td>
											<td><?= $i ?></td>
											<td><?= $pembayaranSudahBayar['alamat_kirim'] ?></td>
											<td><?= $pembayaranSudahBayar['tanggal_mulai_sewa'] ?></td>
											<?php if ($pembayaranSudahBayar['pakai_dp'] == 0) : ?>
												<td>
													<p>Tidak DP</p>
												</td>
											<?php else : ?>
												<td>
													<p>Dp</p>
												</td>
											<?php endif; ?>
											<td> IDR <?= number_format($totalBiaya[$i - 1], 2, '.', ','); ?> </td>
											<?php if ($pembayaranSudahBayar['status_pembayaran'] == 1) : ?>
												<td>
													<p><code class="highlighter-rouge success">Selesai</code></p>
												</td>
											<?php elseif ($pembayaranSudahBayar['status_pembayaran'] == 2) : ?>
												<td>
													<p><code class="highlighter-rouge warning">Sedang Proses</code></p>
												</td>
											<?php else : ?>
												<td>
													<p><code class="highlighter-rouge danger">Dibatalkan</code></p>
												</td>
											<?php endif; ?>
											<?php if ($pembayaranSudahBayar['status_lunas'] == 0) : ?>
												<td>
													<p><code class="highlighter-rouge danger">Belum Lunas</code></p>
												</td>
											<?php else : ?>
												<td>
													<p><code class="highlighter-rouge success">Lunas</code></p>
												</td>
											<?php endif; ?>

											<td>
												<?php if (isset($pembayaranSudahBayar['bukti_pembayaran'])) : ?>
													<a href="<?= site_url('download/' . $pembayaranSudahBayar['bukti_pembayaran']) ?>" download>
														<img src=<?= site_url('download/' . $pembayaranSudahBayar['bukti_pembayaran']) ?> alt="Gambar Item" style="max-width: 200px; height: auto;">
													</a>
												<?php endif; ?>
											</td>

											<td>
												<?php if (isset($pembayaranSudahBayar['bukti_pembayaran_dp'])) : ?>
													<a href="<?= site_url('download/' . $pembayaranSudahBayar['bukti_pembayaran_dp']) ?>" download>
														<img src=<?= site_url('download/' . $pembayaranSudahBayar['bukti_pembayaran_dp']) ?> alt="Gambar Item" style="max-width: 200px; height: auto;">
													</a>
												<?php endif; ?>
											</td>

											<td>
												<button type="button" class="btn btn-sm btn-info show-button" data-toggle="modal" data-target="#modal-pesanan" data-id="<?= $pembayaranSudahBayar['id'] ?>">
													<i class="ft-edit"></i> Detail</a>
												</button>

												<?php if ($pembayaranSudahBayar['status_lunas'] == 0) : ?>
													<button type="button" class="btn btn-sm btn-success pay-button" data-toggle="modal" data-target="#modal-lunas" data-id="<?= $pembayaranSudahBayar['id'] ?>">
														<i class="ft-edit"></i> Lunaskan Pesanan
													</button>
												<?php endif; ?>
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
							<th>Nama Item</th>
							<th>Jumlah Pesanan</th>
							<th>Ukuran Item</th>
							<th>Lama Sewa</th>
							<th>Harga Item</th>
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

<!-- Pelunasan Modal -->
<div id="modal-lunas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Pelunasan Pesanan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= site_url('update-pelunasan') ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
				<input type="hidden" name="action" value="update" />
				<div class="modal-body">
					<input type="hidden" id="orderId" name="orderId" value="">

					<div class="form-group mb-1">
						<label class="form-label" for="tanggalPembayaran">Tanggal Pembayaran</label>
						<input type="date" class="form-control mr-sm-2" name="tanggalPembayaran" id="tanggalPembayaran" required>
					</div>
					<div class="form-group mb-1">
						<label class="form-label" for="bukti">Bukti Pembayaran</label>
						<input type="file" class="form-control mr-sm-2" name="bukti" accept="image/jpeg, image/png, image/gif" id="bukti" required>
					</div>
				</div>


				<div class="modal-footer">
					<div class="col-auto my-1">
						<button type="submit" class="btn btn-primary" name="submit1">Submit Pembayaran</button>
					</div>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
	let table1 = new DataTable('#myTable1', {
		"columns": [{
				"width": "2%"
			},
			{
				"width": "2%"
			},
			{
				"width": "5%"
			},
			{
				"width": "5%"
			},
			{
				"width": "5%"
			},
			{
				"width": "5%"
			},
			{
				"width": "5%"
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
				"width": "15%"
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
					// console.log(response);
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
						// console.log(id);
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

<script>
	$(document).ready(function() {
		$('.pay-button').on('click', function() {
			var orderId = $(this).data('id');
			$('#orderId').val(orderId);
		});
	});
</script>
<?= $this->endSection() ?>