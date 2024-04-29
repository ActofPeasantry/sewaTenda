<?= $this->extend('base-layout/penyewa-header-footer') ?>
<?= $this->section('content') ?>
<section>
    <div class="row match-height" id="form-row">
        <!-- cart -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Penyewa</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <span id="totalPayment">Total Pembayaran : IDR 0.00 </span>
                        <div class="col-md-6 mx-auto text-center">
                            <form class="form" id="myForm">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="inputTanggalMulaiSewa">Tanggal Mulai Sewa</label><strong style="color: red"> *</strong>
                                        <input type="date" class="form-control" name="tanggalMulaiSewa" id="inputTanggalMulaiSewa" required min="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAlamat">Alamat</label><strong style="color: red"> *</strong>
                                        <textarea name="alamat" id="inputAlamat" cols="30" rows="10" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="form-actions center">
                                    <button type="button" class="btn btn-info btn-min-width mr-1 mb-1" onclick="if(document.getElementById('myForm').reportValidity()){submitPesanan()}">Submit Pesanan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    let tendaList = localStorage.getItem('cartTendaList') != null ? JSON.parse(localStorage.getItem('cartTendaList')) : null;
    // Format the integer as a currency value
    const currencyFormatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'IDR',
    });
    const loadTendaList = () => {

        const tendaContainer = document.getElementById('form-row');

        if (tendaList != null && tendaList.length > 0) {
            tendaList.forEach(tendaObj => {
                tendaObj.jumlahHari = 0;
                let cart = `<div class="col-lg-4 col-md-12">
                                <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">` + tendaObj.nama + ` ` + tendaObj.ukuran + `</h4>
                                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="close" onclick = "deleteTenda(` + tendaObj.id + `)"><i class="ft-x"></i></a></li>
                                            </ul>
                                        </div>
                                </div>
                                    <img class="" src="download/` + tendaObj.gambar + `" alt="Card image cap" style = "width: auto; max-height: 300px;">
                                    <div class="card-body">
                                    <h6 class="card-subtitle text-muted">` + tendaObj.nama_kategori + `</h6>
                                        <h6 class="card-subtitle text-muted">Jumlah : ` + tendaObj.newQuantity + `</h6>
                                        <form>
                                            <div class="form-row align-items-center">
                                                <div class="col-3 my-1">
                                                <input type="number" value="0" id = "inputTendaHari" min="0" max="365" class="form-control mr-sm-2" oninput="checkInputValue(this,` + tendaObj.id + ` )">
                                                </div>
                                                <div class="col-auto my-1">
                                                    Hari
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer border-top-blue-grey border-top-lighten-5 text-muted">
                                        <span class="float-left">` + currencyFormatter.format(tendaObj.harga) + `/Hari</span>
                                        <span class="float-right" id = "total` + tendaObj.id + `">Total : IDR 0.00 </span>
                                    </div>
                                </div>
                            </div>`

                tendaContainer.innerHTML += cart;
            });
        }
    }
    loadTendaList();

    function checkInputValue(input, tendaId) {
        let value = parseFloat(input.value);

        if (value > parseFloat(input.max)) {
            input.value = input.max;
        }

        const tendaObj = tendaList.find((tenda) => tenda.id == tendaId);
        document.getElementById("total" + tendaId).innerText = "Total : " + currencyFormatter.format(tendaObj.harga * tendaObj.newQuantity * input.value);

        tendaList = tendaList.map(tenda => {
            if (tenda.id == tendaId) {
                return {
                    ...tenda,
                    jumlahHari: input.value
                };
            }

            return tenda;
        });
        // console.log(tendaList);

        document.getElementById("totalPayment").innerText = "Total Pembayaran : " + currencyFormatter.format(tendaList.reduce((total, tenda) => total + (tenda.harga * tenda.newQuantity * tenda.jumlahHari), 0));
    }

    const deleteTenda = (idTenda) => {
        tendaList = tendaList.filter((tenda) => tenda.id != idTenda);
        localStorage.setItem('cartTendaList', JSON.stringify(tendaList));
        if (tendaList.length == 0) {
            document.getElementById("totalPayment").innerText = "Total Pembayaran : IDR 0.00 ";
        }
    }

    const submitPesanan = () => {

        if (tendaList != null && tendaList.length > 0) {
            if (tendaList.some(value => value.jumlahHari != 0)) {
                $.ajax({
                    url: 'submit-pembayaran',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    data: {
                        tendaList: JSON.stringify(tendaList),
                        alamat: document.getElementById('inputAlamat').value,
                        tanggalMulaiSewa: document.getElementById('inputTanggalMulaiSewa').value
                    },
                    success: function(response) {
                        alert("Pesanan Berhasil Disubmit");
                        localStorage.removeItem('cartTendaList');
                        window.location.href = "/pesanan";
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending data:', error);
                    }
                });
            } else {
                alert("Hari Penyewaan Tenda Harus Lebih Dari 0");
            }
        } else {
            alert("Cart Kosong");
        }
    }
</script>
<?= $this->endSection() ?>