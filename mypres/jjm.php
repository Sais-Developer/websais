<?php
defined('APK') or exit('No Access');
?>              

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">                                
                <h5 class="card-title">JUMLAH JAM MENGAJAR</h5>
            </div>
            <div class="card-body">									
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="10%">NO</th>                                               
                                <th>JJM</th>
                                <th>HONOR PER JJM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?= $setting['jjm'] ?? '' ?> Menit</td>
                                <td>Rp <?= number_format($setting['honor'], 0, ',', '.') ?></td>                                
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
        <form id='formjjm'>										 
            <div class="col-md-12 mb-1">
                <label class="bold">Waktu per 1 JJM (menit)</label>
               <input type="number" name="jjm" class="form-control" value="<?= $setting['jjm'] ?>" required>
            </div>	
            <div class="col-md-12 mb-3">
                <label class="bold">Honor per 1 JJM</label>
                 <input type="number" name="honor" class="form-control" value="<?= $setting['honor'] ?>" required>
               </div>	
            <div class="d-flex justify-content-end align-items-center">
			     <button type="submit" class="btn btn-primary">Simpan</button>
		       </div>
			</form>
		</div>
	</div>
</div>
	
<script>
$('#formjjm').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
        type: 'POST',
        url: 'tjjm',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
        },
        success: function(data){   		
            setTimeout(function() {
                window.location.reload();
            }, 200);
        }
    });
    return false;
});
</script>

</div>
