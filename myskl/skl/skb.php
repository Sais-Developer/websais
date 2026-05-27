<?php
defined('APK') or exit('No Access');
$id = 1;
$sql = "SELECT * FROM skkb WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$skkb = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
 <div class="col-xl-8" >			
   <div class="card">
	  <div class="card-body">	
		<form id='formsekolah' class="row g-1">
				<div class='col-md-4'>
					  <label class="bold">NOMOR SURAT</label>
					   <input type="text" class="form-control" name="nosurat" value="<?= $skkb['nosurat'] ?>" >
					</div>
					
					<div class='col-md-8'>
					  <label class="bold">HEADER</label>
					 <textarea id='editor2' name='header' class='form-control' rows='1' cols='80' style='width:100%;'><?= $skkb['header'] ?></textarea>
			
					</div>
					
					 <div class='col-md-12'>
					  <label class="bold">ISI</label>          
						<textarea id='editor2' name='isi' class='editor1' rows='4' cols='80' style='width:100%;'><?= $skkb['isi'] ?></textarea>						
					</div>
				   
					 <div class='col-md-12'>
					  <label class="bold">FOOTER</label>
						<textarea id='editor1' name='foter' class='editor1' rows='4' cols='80' style='width:100%;'><?= $skkb['foter'] ?></textarea>
					</div>
					<div class='text-end'>		 
					 <button type='submit' name='submit1' onclick="tinyMCE.triggerSave(true,true);" class='btn btn-primary pull-right' > Simpan</button>			
					</div>
				</form>
			</div>
			
		</div>
	</div>
	<script>
    $('#formsekolah').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'skl/tskb.php',
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
						}, 200);
									  
						}
					});
				return false;
			});
		</script>	
<div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-3">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	<div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted mb-4">HIGH SCHOOL</div>
       </div>
        <div class="mb-4">
		<p class="text-small text-muted mb-4">ALAMAT</p>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">home</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['alamat'] ?></div>
		</div>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">star</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['desa'] ?></div>
		</div>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">sync</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
		</div>
	  </div>
	  <div class="mb-2">
		<p class="text-small text-muted mb-4">CONTACT</p>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
				<i class="material-icons text-info" style="font-size:18px">phone</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nowa'] ?></div>
		</div>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			   <i class="material-icons text-info" style="font-size:18px">inbox</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['email'] ?></div>
		</div>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">language</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['server'] ?></div>
		</div>
	  </div>
	  <div class="mb-0">
		<p class="text-small text-muted mb-4">KEPALA SEKOLAH</p>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			 <i class="material-icons text-info" style="font-size:18px">person</i>
			</div>
		  </div>
		  <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
		</div>
		<div class="row g-0 mb-3">
		  <div class="col-auto">
			<div class="sw-3 me-1">
			  <i class="material-icons text-info" style="font-size:18px">payment</i>
			</div>
		  </div>
		  <div class="col text-alternate"><?= $setting['nip'] ?></div>
		  </div>
		</div>
	  </div>
	</div>
  </div>             
</div>			
			
<script>
	tinymce.init({
		selector: '.editor1',
		
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
		],

		toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
		fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
		paste_data_images: true,

		images_upload_handler: function(blobInfo, success, failure) {
			success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
		},
		image_class_list: [{
			title: 'Responsive',
			value: 'img-responsive'
		}],
	});
</script>
