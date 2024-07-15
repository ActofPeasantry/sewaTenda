<?= $this->extend('base-layout/admin-header-sidebar-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Transaksi Penyewa <?= $penyewa['nama'] ?? "" ?> (<?= $status == 1 ? "Approved" : ($status == 2 ? "progress" : "Rejected") ?? "" ?> List)</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-content collapse show">
				<div class="card-body">
					<form action="<?= site_url('confirm-transaksi') ?>" method="post">
						<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
						<input type="hidden" name="action" id="action" value="update" />
						<input type="hidden" name="penyewaId" value=<?= $penyewa['id'] ?? "" ?> />
						<?php if (session()->getFlashdata('error')) : ?>
							<p><code class="highlighter-rouge"><?= session()->getFlashdata('error') ?></code></p>
						<?php endif; ?>
						<div class="form-row align-items-center">
							<div class="col-auto my-1">
								<label>Status Pembayaran</label>
							</div>
							<div class="col-auto my-1">
								<select class="form-control" id="basicSelect" name="sudahBayar" required <?= $status != 2 ? "disabled" : "" ?>>
									<option value=1 <?= $status == 1 ? "selected" : "" ?>>Approved</option>
									<option value=0 <?= $status == 0 ? "selected" : "" ?>>Rejected</option>
								</select>
							</div>
							<div class="col-auto my-1">
								<label>Catatan</label>
							</div>
							<div class="col-auto my-1">
								<textarea name="catatan" cols="35" rows="3" class="form-control" required <?= $status != 2 ? "disabled" : "" ?>><?= isset($pembayaranList[0]['catatan']) ? $pembayaranList[0]['catatan'] : "" ?></textarea>
							</div>
							<?php if ($status == 2) : ?>
								<div class="col-auto my-1">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Submit Data Transaksi?')">Submit</button>
								</div>
							<?php else : ?>
								<div class="col-auto my-1">
									<button type="submit" class="btn btn-primary" onclick="document.getElementById('action').value = 'export'; return confirm('Cetak Data Transaksi?');">Cetak</button>
								</div>
							<?php endif; ?>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-borderless table-hover" id="myTable">
								<thead>
									<tr>
										<th><input type="checkbox" id="check-all"></th>
										<th>No</th>
										<th>Alamat Kirim</th>
										<th>Tanggal Mulai Sewa</th>
										<th>Tipe Pembayaran</th>
										<th>Status Transaksi</th>
										<th>Status Lunas</th>
										<th>Total Biaya</th>
										<th>Bukti Pembayaran</th>
										<th>Bukti Pembayaran DP</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1 ?>
									<?php foreach ($pembayaranList as $pembayaran) : ?>
										<tr>
											<td><input type="checkbox" value=<?= $pembayaran['transaction_id'] ?> name="idPembayarans[]"></td>
											<th scope="row"><?= $i ?></th>
											<td><?= $pembayaran['alamat_kirim'] ?></td>
											<td><?= $pembayaran['tanggal_mulai_sewa'] ?></td>

											<?php if ($pembayaran['pakai_dp'] == 0) : ?>
												<td>
													<p>Tidak DP</p>
												</td>
											<?php else : ?>
												<td>
													<p>Dp</p>
												</td>
											<?php endif; ?>

											<?php if ($pembayaran['status_pembayaran'] == 1) : ?>
												<td>
													<p><code class="highlighter-rouge success">Selesai</code></p>
												</td>
											<?php elseif ($pembayaran['status_pembayaran'] == 2) : ?>
												<td>
													<p><code class="highlighter-rouge warning">Sedang Proses</code></p>
												</td>
											<?php elseif ($pembayaran['status_pembayaran'] == 4) : ?>
												<td>
													<p><code class="highlighter-rouge info">DP Diterima</code></p>
												</td>
											<?php else : ?>
												<td>
													<p><code class="highlighter-rouge danger">Dibatalkan</code></p>
												</td>
											<?php endif; ?>

											<?php if ($pembayaran['status_lunas'] == 0) : ?>
												<td>
													<p><code class="highlighter-rouge danger">Belum Lunas</code></p>
												</td>
											<?php elseif ($pembayaran['status_lunas'] == 2) : ?>
												<td>
													<p><code class="highlighter-rouge info">Sudah Bayar DP</code></p>
												</td>
											<?php elseif ($pembayaran['status_lunas'] == 3) : ?>
												<td>
													<p><code class="highlighter-rouge info">Sudah Bayar Full</code></p>
												</td>
											<?php else : ?>
												<td>
													<p><code class="highlighter-rouge success">Lunas</code></p>
												</td>
											<?php endif; ?>


											<td> IDR <?= number_format($totalBiaya[$i - 1], 2, '.', ','); ?> </td>
											<td>
												<a href="<?= site_url('download/' . $pembayaran['bukti_pembayaran']) ?>" download>
													<img src=<?= site_url('download/' . $pembayaran['bukti_pembayaran']) ?> alt="Gambar Item" style="max-width: 200px; height: auto;">
												</a>
											</td>
											<td>
												<a href="<?= site_url('download/' . $pembayaran['bukti_pembayaran_dp']) ?>" download>
													<img src=<?= site_url('download/' . $pembayaran['bukti_pembayaran_dp']) ?> alt="Gambar Item" style="max-width: 200px; height: auto;">
												</a>
											</td>
											<td>
												<button type="button" class="btn btn-sm btn-info show-button" data-toggle="modal" data-target="#modal-pesanan" data-id="<?= $pembayaran['transaction_id'] ?>">
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
	<div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
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
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
	let table1 = new DataTable('#myTable', {
		"columns": [{
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
			{
				"width": "10%"
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
			{
				"width": "10%"
			},
			{
				"width": "10%"
			},
		]
	});

	const checkAllCheckbox = document.getElementById('check-all');
	const checkboxes = document.querySelectorAll('input[name="idPembayarans[]"]');

	checkAllCheckbox.addEventListener('change', function() {
		checkboxes.forEach(checkbox => {
			checkbox.checked = checkAllCheckbox.checked;
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('.show-button').on('click', function() {
			var id = $(this).data('id');
			$.ajax({
				method: 'GET',
				url: '/confirm-transaksi-view/detail/' + id,
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