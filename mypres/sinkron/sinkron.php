<style>
    h3 {
        text-align: center;
        margin-bottom: 16px;
        color: #333;
    }

    form {
        display: flex;
        flex-direction: column;
    }
    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .checkbox-group label {
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
        padding-left: 35px;
        user-select: none;
        color: #555;
        font-weight: 500;
    }

    .checkbox-group input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        left: 0;
        top: 0;
        height: 22px;
        width: 22px;
        background-color: #e5e5e5;
        border-radius: 6px;
        transition: 0.3s;
    }

    .checkbox-group label:hover input ~ .checkmark {
        background-color: #d1d1d1;
    }

    .checkbox-group input:checked ~ .checkmark {
        background-color: #4CAF50;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-group input:checked ~ .checkmark:after {
        display: block;
    }

    .checkbox-group .checkmark:after {
        left: 8px;
        top: 4px;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

.widget-payment-request-info-item .right {
    text-align: right;
	margin-top:15px;
    color: #6c757d; 
    white-space: nowrap;
}

</style>
<div class="row">
<div class="col-md-8">
<div class="card">
  <div class="card-body">
   <div class="text-center mb-2">
	<?php
		defined('APK') or exit('No Access');
		$datax = http_request($setting['server'] . "/sinkron/sincek.php?token=" . $setting['token_api']);
		$r = json_decode($datax, TRUE);
		if ($r <> null) {
		  echo "<div class='spinner-border text-success' role='status'>
				<span class='visually-hidden'>Loading...</span>
				</div> <label style='color:green'>TERHUBUNG KE SERVER</label>";
		} else {
		   echo "<div class='spinner-border text-danger' role='status'>
				<span class='visually-hidden'>Loading...</span>
				</div> <label style='color:red'>KONEKSI KE SERVER TERPUTUS</label>";
		}
		?>  
</div>
    <h3>Sinkronisasi Data Presensi</h3>
    <form id="formsinkron">
	   <input type="hidden" name="tokenapi" value="<?= $setting['token_api'] ?>" >
	    <div class="text-center mb-2">
			<button type="submit" class="btn btn-success"><i class="material-icons">sync</i>Sinkron</button>
		</div>
		<div class="mb-4"></div>
        <div class="checkbox-group">
            <label>
                <input type="checkbox" name="data[]" value="reg">
                <span class="checkmark"></span>
               Data Registrasi
            </label>
			<label>
                <input type="checkbox" name="data[]" value="absensi">
                <span class="checkmark"></span>
                Data Presensi KBM
            </label>
            <label>
                <input type="checkbox" name="data[]" value="eskul">
                <span class="checkmark"></span>
                Data Presensi Eskul
            </label>
			<label>
                <input type="checkbox" name="data[]" value="jjm">
                <span class="checkmark"></span>
                Data Presensi JJM
            </label>
            <label>
                <input type="checkbox" name="data[]" value="waktu">
                <span class="checkmark"></span>
                Pengaturan Waktu
            </label>
            
        </div>
    </form>
</div>
</div>
</div>
<script>
    $('#formsinkron').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax(
    {
        type: 'POST',
        url: 'sinkron/sinkron_master.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function() {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
			},	
			success: function(data){ 
            setTimeout(function()
            {
                window.location.reload();
            }, 500);
		  
        }
    });
    return false;
});
</script>	
<div class="col-xl-4">
	<div class="card widget widget-list">
		<div class="card-header">
			<h5 class="card-title">Request Sinkron Data Master</h5>
		</div>
		<div class="card-body">
			<ul class="widget-list-content list-unstyled">
				  <?php
					function hari_indonesia($tanggal) {
						$hariInggris = date('D', strtotime($tanggal));
						$hariIndo = [
							'Sun' => 'Minggu',
							'Mon' => 'Senin',
							'Tue' => 'Selasa',
							'Wed' => 'Rabu',
							'Thu' => 'Kamis',
							'Fri' => 'Jumat',
							'Sat' => 'Sabtu'
						];
						return $hariIndo[$hariInggris];
					}

					$stmt = $pdo->prepare("SELECT * FROM sinkron WHERE id BETWEEN 9 AND 13");
					$stmt->execute();

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :

						$tgl = $data['tanggal'];
					?>
					
					<li class="widget-list-item widget-list-item-blue">
						<span class="widget-list-item-icon">
							<i class="material-icons-outlined">sync</i>
						</span>
						<span class="widget-list-item-description">
							<a href="#" class="widget-list-item-description-title">
								<?= $data['kode'] ?>
							</a>
							<span class="widget-list-item-description-date">
                              <?php if (!empty($tgl)) : ?>   
								<?= $tanggal_format = hari_indonesia($tgl) . ", " . date('d-m-Y', strtotime($tgl));?>
								<?php endif; ?>
                            </span>
						</span>
						<span class="widget-list-item-transaction-amount-positive"><?= $data['jumlah'] ?> Data</span>
					</li>
					<?php endwhile; ?>
					
                     </ul>
				</div>
			</div>
		</div>
	</div>
