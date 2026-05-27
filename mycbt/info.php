<?php
defined('APK') or exit('No Access');
$stmt = $pdo->prepare("SELECT * FROM pengumuman ORDER BY tanggal DESC");
$stmt->execute();
$pengumuman = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class='row'>
  <div class="col-xl-7">
      
      <?php if (count($pengumuman) > 0):  ?>
        <?php foreach ($pengumuman as $row): ?>
		<div class="card widget widget-popular-blog">
			<div class="card-body">
				<div class="widget-popular-blog-container">
					<div class="widget-popular-blog-image">
						<img src="../images/corong.png" alt=""> 
					</div>
					<div class="widget-popular-blog-content ps-4">
						<span class="widget-popular-blog-title">
							<?= $row['judul'] ?>
						</span>
						<span>
							<?= $row['isi'] ?> 
						</span>
					</div>
				</div>
			</div>
			<div class="card-footer d-flex justify-content-between align-items-center" id="datata">
				<span class="widget-popular-blog-date">
					Date: <?= htmlspecialchars($row['tanggal']) ?>
				</span>
				<button data-id="<?= htmlspecialchars($row['id']) ?>" class="hapus btn btn-danger" 
					data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
				   Hapus
				</button>
			</div>
		</div>
       <?php endforeach; ?>
     <?php else: ?>
        <div class="card widget widget-popular-blog">
			<div class="card-body">
				<div class="widget-popular-blog-container">
					<div class="widget-popular-blog-image">
						<img src="../images/corong.png" alt=""> 
					</div>
					<div class="widget-popular-blog-content ps-4">
						<span class="widget-popular-blog-title">
							INFORMASI HARI INI
						</span>
						<span class="widget-popular-blog-text">
							Belum ada informasi.....
						</span>
					</div>
				</div>
			</div>
			<div class="card-footer d-flex justify-content-between align-items-center">
				<span class="widget-popular-blog-date">
					Date: <?= date('d-m-Y H:i:s') ?>
				</span>
				<button  class="btn btn-secondary" disabled>
				   Hapus
				</button>
			</div>
		</div>
   <?php endif; ?>
</div>
<div class="col-xl-5">
    <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                    </div>
                <div class="text-muted"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                    </div>
                   <form id='forminfo' class="row g2" enctype='multipart/form-data'>
				  <div class="col-md-12 mb-2">
                      <label class="bold">Judul</label>
                        <input type='text' name='judul' class='form-control'  required >
                      </div>
					<div class="col-md-12 mb-2">
                      <label class="bold">Isi Informasi</label>
                       <textarea id='editor1' name='isi' class='editor1'  style='width:100%;' required><?= $soal['soal'] ?></textarea>
                      </div>
                   		
                    <div class="text-end">
                     <button type='submit' name='submit' class='btn btn-primary' onclick="tinyMCE.triggerSave(true,true);">Simpan</button>
                       </div>
                    </form>                  
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
<script>
  $('#forminfo').submit(function(e) {
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		type: 'POST',
		 url: 'tinfo.php?pg=simpan',
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
<script>
$('#datata').on('click', '.hapus', function() {
var id = $(this).data('id');
	console.log(id);
	Swal.fire({
	title: 'Hapus Data',
	text: "Hapus Data Informasi",
	icon: 'warning',
	width:'320px',
	showCancelButton: true,
	confirmButtonColor: '#3085d6',
	cancelButtonColor: '#d33',
	confirmButtonText: 'Ya, Hapus!',
	cancelButtonText: "Batal"				  
}).then((result) => {
	if (result.value) {
	$.ajax({
	url: 'tinfo.php?pg=hapus',
	method: "POST",
	data: 'id=' + id,
	success: function(data) {
	$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
	setTimeout(function() {
	window.location.reload();
	}, 200);
		}
	});
	}
	return false;
	})

	});

</script>
