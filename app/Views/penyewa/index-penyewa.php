<?= $this->extend('base-layout/admin-header-sidebar-footer') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Daftar Penyewa</h4>
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
					<div class="table-responsive">
						<table class="table table-striped table-borderless table-hover" id = "myTable">
							<thead>
								<tr>
									<th>No</th>
									<th style = "text-align : center">NIK</th>
									<th style = "text-align : center">Nama</th>
									<th style = "text-align : center">Alamat</th>
									<th style = "text-align : center">No Handphone</th>
									<th style = "text-align : center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1?>
                                <?php foreach($penyewaList as $penyewa): ?>
								<tr>
									<th scope="row"><?= $i ?></th>
									<td style = "text-align : center"><?= $penyewa['nik'] ?></td>
									<td style = "text-align : center"><?= $penyewa['nama'] ?></td>
									<td style = "text-align : center"><?= $penyewa['alamat'] ?></td>
									<td style = "text-align : center"><?= $penyewa['no_hp'] ?></td>
									<td style = "text-align : center">
                                    <form action="/edit-penyewa-view" method="post">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <input type="hidden" name = "penyewaId" value=<?= $penyewa['id'] ?>>
                                        <button type="submit" class="btn btn-sm btn-success"><i class="ft-edit"></i></button>
                                        <a style="color: white; text-decoration: none;" href = "penyewa/delete/<?=$penyewa['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete Data Penyewa <?=$penyewa['nama']?>? ')"><i class="ft-delete"></i></a>
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