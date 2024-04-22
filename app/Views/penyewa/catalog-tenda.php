<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
<section id="header-footer">
	<div class="row match-height">
		<?php foreach($tendaList as $tenda): ?>
		<div class="col-lg-4 col-md-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><?= $nomor++;?>. <?= $tenda['nama'] ?> <?= $tenda['ukuran'] ?></h4>
					<h6 class="card-subtitle text-muted"><?= $tenda['nama_kategori'] ?></h6>
				</div>
				<img class="" src=<?= site_url('download/' . $tenda['gambar']) ?> alt="Card image cap" style = "width: auto; max-height: 300px;">
				<div class="card-body">
				<?php if ($tenda['sisa'] == 0) : ?>
					<form>
						<div class="form-row align-items-center">
							<div class="col-auto my-1">
							<p class="mr-sm-2"><span class="text-bold-600"><code>Stock Habis</code></p> 
							</div>
						</div>
					</form>
				<?php else :?> 
					<form>
						<div class="form-row align-items-center">
							<div class="col-auto my-1">
							<input type="number" value = "0" class="form-control mr-sm-2" id="quantityInput<?= $tenda['id'] ?>" min="0" max= <?= $tenda['sisa'] ?> oninput="checkInputValue(this)">
							</div>
							<div class="col-auto my-1">
								<?php if (session()->get('user')) : ?>
									<button type = "button" class="btn btn-primary" onclick="addToCart(<?= $tenda['id'] ?>)">Add To Cart</button>
								<?php else :?> 
									<button type = "button" class="btn btn-primary" onclick="alert('Tolong Login Terlebih Dahulu')">Add To Cart</button>
								<?php endif; ?>								
							</div>
						</div>
					</form>
				<?php endif; ?>	
				</div>
				<div class="card-footer border-top-blue-grey border-top-lighten-5 text-muted">
					<span class="float-left">IDR <?= number_format($tenda['harga'] , 2, '.', ',');?>/Hari</span>
					<span class="float-right">Sisa <?= $tenda['sisa'] ?> </span>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<!-- Display pagination links -->
	<div class="row justify-content-end" style="margin-right: 0.1%;">
			<?= $pager->links('tenda', 'pagination'); ?>
	</div>
</section>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function checkInputValue(input) {
  let value = parseFloat(input.value);

  if (value > parseFloat(input.max)) {
    input.value = input.max;
	alert('Stock Melebihi Batas');
  }
}

function addToCart(tendaId) {
	let tenda = (JSON.parse(`<?= json_encode($tendaList) ?>`)).find((value)=> value.id == tendaId);
    let newQuantity = parseInt(document.getElementById('quantityInput'+tendaId).value);
	let tendaList = JSON.parse(localStorage.getItem('cartTendaList'));

	if(newQuantity!=0){
		tenda.newQuantity = newQuantity;
		if(tendaList){
			if(tendaList.some(value => value.id === tenda['id'])){
				tendaList = tendaList.map(value =>{
					if(value.id === tenda['id']){
						return tenda;
					}
	
					return value;
				});
			}else{
				tendaList.push(tenda)
			}
			localStorage.setItem('cartTendaList', JSON.stringify(tendaList));
		}else{
			localStorage.setItem('cartTendaList', JSON.stringify([tenda]));
		}
	
		alert(newQuantity+' Tenda '+tenda.nama+' '+tenda.ukuran+' '+tenda.nama_kategori+' Ditambahkan ke Keranjang');
		console.log('Item'+tendaId+' added to cart: ' + newQuantity + ' units');
		console.log('tenda: ' + localStorage.getItem('cartTendaList'));
	}else{
		alert("Kuantitas Kosong");
	}
}

</script>
<?= $this->endSection() ?>