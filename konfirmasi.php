<?php
require_once __DIR__ . "/konek/koneksi.php";
require_once __DIR__ . "/konek/function.php";
require_once __DIR__ . "/konek/crud.php";
$sekarang = date('Y-m-d H:i:s');
$ids = $_POST['ids'];
$idu= $_POST['idm'];

?>
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
	 <div class="card">
	  <div class="card-body">
		<h4 class="text-center mb-3">Konfirmasi Ujian</h4>
		<p>Pastikan Anda siap memulai ujian ini. Setelah menekan tombol Mulai Sekarang, waktu ujian akan berjalan.</p>
		<form id="formmulaiujian" action='' method='post'>
                        <input type='hidden' value='<?= $ids ?>' name='ids'>
                        <input type='hidden' value='<?= $idu ?>' name='idm'>
          <div class="widget-payment-request-actions m-t-lg d-flex">
		<button type='submit' class='btn btn-primary flex-grow-1 m-l-xxs'>Mulai Sekarang</button>
		 </div>
		 </form>
	  </div>
	</div>
	</div>
</div>
<script>
$('#formmulaiujian').submit(function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'cekkonfirmasi.php',
		data: $(this).serialize(),
		success: function(data) {
			toastr.success(data);
			
		}
	});
	return false;
});
</script>
