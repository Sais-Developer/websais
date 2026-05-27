<?php
defined('APK') or exit('No Access');
if($setting['mesin']=='1'){$mesinku='RFID';}
if($setting['mesin']=='2'){$mesinku='MULTI RFID';}
if($setting['mesin']=='3'){$mesinku='BARCODE';}
if($setting['mesin']=='4'){$mesinku='FINGER PRINT';}
if($setting['mesin']=='5'){$mesinku='FACE RECOGNITION';}
?>              
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">                                
                <h5 class="card-title">MESIN PRESENSI</h5>
            </div>
            <div class="card-body">									
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">NO</th>                                               
                                <th>MESIN PRESENSI</th>
                                <th>JAM NOTIF PENGINGAT</th>
                            </tr>
                        </thead>
                        <tbody>
					<tr>
					   <td>1</td>
					   <td><?= $mesinku; ?></td>
					   <td><?= $setting['notif']; ?></td>
					</tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<div class="col-md-4">
  <div class="card">
    <div class="card-body">
	   <div class="d-flex align-items-center flex-column mb-4">
      <div class="sw-13 position-relative mb-3">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
			<form id='formwaktu' class="row g-2">										 
				<div class="col-md-12 mb-1">
					<label class="bold">Mesin Presensi</label>
					<select name='mesin' class='form-select' required='true'>
					<option value="<?= $setting['mesin'] ?>"><?= $mesinku ?></option>
					<option value='1'>RFID</option>
				    <option value='2'>MULTI RFID</option>
					<option value='3'>BARCODE</option>
					<option value='4'>FINGER PRINT</option>
					<option value='5'>FACE RECOGNITION</option>
					</select>
				</div>	
				<label class="bold">Jam Pengingat Jadwal Guru</label>
				<div class="input-group mb-2">
				<input type="text" name="jam" class="timer form-control" value="<?= $setting['notif'] ?>" autocomplete="off" required>
				</div>
				<div class="d-flex justify-content-end align-items-center">
			     <button type="submit" class="btn btn-primary">Simpan</button>
		       </div>
			</form>
			</div>
		</div>
	</div>
</div>
<script>
$('#formwaktu').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'twaktu.php?pg=mesin',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
        },			
        success: function(data){  			
            setTimeout(function(){ window.location.reload(); }, 500);
        }
    });
    return false;
});
</script>
