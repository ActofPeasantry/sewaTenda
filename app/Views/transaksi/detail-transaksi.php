<?= $this->extend('base-layout/admin-header-sidebar-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Transaksi Penyewa <?= $penyewa['nama'] ?? "" ?> (<?= $status==1?"Approved":($status==2?"progress":"Rejected") ?? ""?> List)</h4>
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
					<input type="hidden" name="action" id="action"  value="update" />
					<input type="hidden" name="penyewaId"  value=<?= $penyewa['id'] ?? "" ?>/>
						<?php if (session()->getFlashdata('error')) : ?>
						<p><code class="highlighter-rouge"><?= session()->getFlashdata('error') ?></code></p>                    
						<?php endif; ?> 				
						<div class="form-row align-items-center">
								<div class="col-auto my-1">									
									<label>Status Pembayaran</label>
								</div>
								<div class="col-auto my-1">									
									<select class="form-control" id="basicSelect" name="sudahBayar" required <?= $status!=2?"disabled":""?>>
                                        <option value = 1 <?= $status==1?"selected":""?>>Approved</option>
										<option value = 0 <?= $status==0?"selected":""?>>Rejected</option>
                                    </select>
								</div>
								<div class="col-auto my-1">									
									<label>Catatan</label>
								</div>
								<div class="col-auto my-1">									
									<textarea name="catatan" cols="35" rows="3" class="form-control" required  <?= $status!=2?"disabled":""?>><?= isset($pembayaranList[0]['catatan'])?$pembayaranList[0]['catatan']:"" ?></textarea>
								</div>
								<?php if ($status==2) : ?>
								<div class="col-auto my-1">
									<button type = "submit" class="btn btn-primary" onclick = "return confirm('Submit Data Transaksi?')">Submit</button>							
								</div>
								<?php else : ?>
								<div class="col-auto my-1">
									<button type = "submit" class="btn btn-primary" onclick = "document.getElementById('action').value = 'export'; return confirm('Cetak Data Transaksi?');">Cetak</button>							
								</div>
								<?php endif; ?> 
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-borderless table-hover" id="myTable">
								<thead>
									<tr>
										<th><input type="checkbox" id="check-all"></th>
										<th>No</th>
										<th>Tenda</th>
										<th>Lama Sewa</th>
										<th>Jumlah Tenda</th>
										<th>Alamat Kirim</th>
										<th>Tanggal Mulai Sewa</th>
										<th>Tanggal Pembayaran</th>
										<th>Bukti Pembayaran</th>
									</tr>
								</thead>
								<tbody>
										<?php $i = 1?>
										<?php foreach($pembayaranList as $pembayaran): ?>
											<tr>
												<td><input type="checkbox" value=<?= $pembayaran['id'] ?> name="idPembayarans[]"></td>
												<th scope="row"><?= $i ?></th>
												<td><?= $pembayaran['nama'] ?> <?= $pembayaran['ukuran'] ?></td>
												<td><?= $pembayaran['lama_sewa'] ?> Hari</td>
												<td><?= $pembayaran['jumlah_tenda'] ?></td>
												<td><?= $pembayaran['alamat_kirim'] ?></td>
												<td><?= $pembayaran['tanggal_mulai_sewa'] ?></td>
												<td><?= $pembayaran['tanggal_pembayaran'] ?></td>
												<td><a href="<?= site_url('download/' . $pembayaran['bukti_pembayaran']) ?>" download>
													    <img src= <?= site_url('download/' . $pembayaran['bukti_pembayaran']) ?> alt="Gambar Tenda" style = "max-width: 200px; height: auto;">
												    </a>
											    </td>
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
    let table1 = new DataTable('#myTable', {
		"columns": [
					{ "width": "5%" },
					{ "width": "10%" },
					{ "width": "5%" },
					{ "width": "5%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "10%" },
					{ "width": "10%" }
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
<?= $this->endSection() ?>