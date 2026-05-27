<?php
defined('APK') or exit('No Access');
?>
<div class='row'>
	<div class="col-xl-8" >
		<div class="card" >
			<div class="card-header" >	
			<h5 class="card-title">JENIS ASESMEN</h5>
			</div>				
		<div class="card-body">                    
		  <div class="table-responsive">
		   <table id="datatable1" class="table  table-bordered table-analisis edis2">
			<thead>
				<tr>
				<th width="10%">NO</th>
				<th>SERVER</th>
				<th>KODE</th>
				 <th>NAMA UJIAN</th>		
				</tr>
			</thead>
			<tbody>
			  <tr>
				 <td>1</td>
				  <td><?= $setting['kode_server'] ?></td>
				 <td><?= $setting['kode_ujian'] ?></td>
				 <td><?= $setting['jenis_ujian'] ?></td>							
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
		  <form id='formjenis' class="row g2" enctype='multipart/form-data'>
		  <div class="col-md-12 mb-2">
			  <label class="bold">ID Server</label>
				<input type='text' name='server' class='form-control' value="<?= $setting['kode_server'] ?>" required >
			  </div>
			<div class="col-md-12 mb-2">
			  <label class="bold">Kode</label>
				<input type='text' name='kode' class='form-control' value="<?= $setting['kode_ujian'] ?>" required >
			  </div>
						   
			<div class="col-md-12 mb-4">
			  <label class="bold">Nama Ujian</label>
				<input type='text' name='nama' class='form-control' value="<?= $setting['jenis_ujian'] ?>" required >
			  </div>
			 <div class="d-flex justify-content-end align-items-center mb-3">
			     <button type="submit" class="btn btn-primary">Simpan</button>
		       </div>
			</form> 		
		 </div>
      </div>
   </div>
</div>
<script>
$('#formjenis').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
             url: 'tjenis.php',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
            },
            success: function(data) {
               
                setTimeout(function() {
                    window.location.reload();
                }, 200);
            }
        })
        return false;
    });
	</script>
