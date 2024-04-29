<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Menunggu Pembayaran</h4>
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
						<input type="hidden" name="action" value="update" />
						<?php if (session()->getFlashdata('error')) : ?>
							<p class="card-text"><em>Proses Gagal : </em> Sebelum melakukan <code>Submit Pembayaran / Cetak</code>, harap pastikan bahwa data pembayaran telah diverifikasi dengan memilih setidaknya satu catatan pembayaran.</p>
						<?php endif; ?>
						<?php if (session()->getFlashdata('success')) : ?>
							<p><span class="text-bold-600"><em> </em></span> <code></code> <strong><em></em></strong> </p>
						<?php endif; ?>
						<?php if (!session()->getFlashdata('success') && !session()->getFlashdata('error')) : ?>
							<p><span class="text-bold-600"><em>Pembayaran Dilakukan Ke : </em></p>
							<p><span class="text-bold-600"><em>Bank Mandiri <code>1120013926031</code> <strong><em>An.</em></strong> Ayu Triandha</em></p>
							<p><span class="text-bold-600"><em>Bank BCA <code>1510625834</code> <strong><em>An.</em></strong> Resno Ramadani</em></p>
							<p><span class="text-bold-600"><em>Bank Sumsel <code>17409000507</code> <strong><em>An.</em></strong> Resno Ramadani</em></p>
						<?php endif; ?>
						<div class="form-row align-items-center">
							<div class="col-auto my-1">
								<label>Tanggal Pembayaran</label>
							</div>
							<div class="col-auto my-1">
								<input type="date" class="form-control mr-sm-2" name="tanggalPembayaran" id="tanggalPembayaran" required>
							</div>
							<div class="col-auto my-1">
								<label>Bukti Pembayaran</label>
							</div>
							<div class="col-auto my-1">
								<input type="file" class="form-control mr-sm-2" name="bukti" accept="image/jpeg, image/png, image/gif" id="bukti" required>
							</div>
							<div class="col-auto my-1">
								<button type="submit" class="btn btn-primary" name="submit1">Submit Pembayaran</button>
							</div>
							<div class="btn-group col-auto my-1">
								<button type="button" class="btn btn-light"><i class="la la-print"></i>Pilih Metode Pembayaran</button>
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								</button>
								<div class="dropdown-menu">
									<button type="submit" class="dropdown-item" name="submit3" onClick="disableRequired()">DP</button>
									<button type="submit" class="dropdown-item" name="submit2" onClick="disableRequired()">Tanpa DP</button>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-borderless table-hover" id="myTable">
								<thead>
									<tr>
										<th><input type="checkbox" id="check-all"></th>
										<th>Alamat Kirim</th>
										<th>Tanggal Mulai Sewa</th>
										<th>Total Biaya</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $n = 0; ?>
									<?php foreach ($pembayaranBelumBayarList as $pembayaranBelumBayar) : ?>
										<tr>
											<td><input type="checkbox" value=<?= $pembayaranBelumBayar['id'] ?> name="idPembayarans[]"></td>
											<td><?= $pembayaranBelumBayar['alamat_kirim'] ?></td>
											<td><?= $pembayaranBelumBayar['tanggal_mulai_sewa'] ?></td>
											<td><?= $totalBiaya[$n] ?></td>
											<td>
												<button type="button" class="btn btn-sm btn-info show-button" data-toggle="modal" data-target="#modal-pesanan" data-id="<?= $pembayaranBelumBayar['id'] ?>">
													<i class="ft-edit"></i> Detail</a>
												</button>
											</td>
										</tr>
										<?php $n++; ?>
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
			{
				"width": "10%"
			},
			{
				"width": "10%"
			},
			{
				"width": "5%"
			}
		]
	});

	const checkAllCheckbox = document.getElementById('check-all');
	const checkboxes = document.querySelectorAll('input[name="idPembayarans[]"]');

	checkAllCheckbox.addEventListener('change', function() {
		checkboxes.forEach(checkbox => {
			checkbox.checked = checkAllCheckbox.checked;
		});
	});

	const checkAllCheckbox1 = document.getElementById('check-all1');
	const checkboxes1 = document.querySelectorAll('input[name="idPembayarans1[]"]');

	checkAllCheckbox1.addEventListener('change', function() {
		checkboxes1.forEach(checkbox => {
			checkbox.checked = checkAllCheckbox1.checked;
		});
	});

	function disableRequired() {
		document.getElementById('tanggalPembayaran').removeAttribute('required');
		document.getElementById('bukti').removeAttribute('required');
	}

	// var dynamicLink = document.getElementById('dynamicLink');
	// var dynamicInput = document.getElementById('dynamicInput');

	// dynamicInput.addEventListener('input', function() {
	//     var dynamicValue = dynamicInput.value;
	//     dynamicLink.href = '/value/' + dynamicValue;
	// });
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