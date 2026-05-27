<?php
defined('APK') or exit('No Access');
?>
<?php
$query = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY tanggal DESC");
?>


    <div class='row'>
      <div class="col-xl-7">
            
<div class="container" id="datata">
  <?php if (mysqli_num_rows($query) > 0): ?>
    <?php while ($p = mysqli_fetch_assoc($query)): ?>
	  <div class="no-log"><?= $p['tanggal'] ?>
	  <button data-id="<?= $p['id'] ?>"  class="hapus btn btn-sm btn-danger kanan" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="material-icons">delete</i> </button>
	  </div>
      <div class="profile">
	    <img src="../images/amplop.png" alt="Foto Peserta"> 
		
	  <div class="log-item">
        <h4><?= $p['judul'] ?></h4>
        <p><?= $p['isi'] ?></p>
        
        </div>
		
      </div>
	 
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center; color:#777;">Belum ada pengumuman untuk saat ini.</p>
  <?php endif; ?>
</div>
			  </div>
  
       
	 <div class="col-xl-5">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                <div class="d-flex align-items-center flex-column">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" alt="thumb" />
                    </div>
                <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                    </div>
                  </div>
                <div class="d-flex justify-content-between mb-2">
                   <form id='forminfo' class="row g2" enctype='multipart/form-data'>
				  <div class="col-md-12 mb-2">
                      <label class="bold">Judul</label>
                        <input type='text' name='judul' class='form-control'  required >
                      </div>
					<div class="col-md-12 mb-2">
                      <label class="bold">Isi Informasi</label>
                       <textarea id='editor1' name='isi' class='editor1' rows='10' cols='80' style='width:100%;' required><?= $soal['soal'] ?></textarea>
                      </div>
                   		
                    <div class="col-md-12 mb-2">
                     <button type='submit' name='submit' class='btn btn-primary kanan' onclick="tinyMCE.triggerSave(true,true);">Simpan</button>
                         </div>
                    </form>                  
                  
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
	<script>
      $('#forminfo').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
             url: 'info/tinfo.php?pg=simpan',
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
						swal({
						title: 'Hapus Data',
						text: "Hapus Data Informasi",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ya, Hapus!',
						cancelButtonText: "Batal"				  
					}).then((result) => {
						if (result.value) {
						$.ajax({
						url: 'info/tinfo.php?pg=hapus',
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
