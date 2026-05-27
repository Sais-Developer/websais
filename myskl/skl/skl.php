<?php
defined('APK') or exit('No Access');
$id_skl = 1;
$sql = "SELECT * FROM skl WHERE id_skl = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);
if ($skl) {
    if ($skl['kuri'] == 1) {
        $kuri = 'K 13';
    } elseif ($skl['kuri'] == 2) {
        $kuri = 'Merdeka';
    }
}
?>

<div class="col-xl-12" >
   <div class="card">
		<div class="card-body">	
				<form id='formsekolah' class="row g-2">
				<div class='col-md-2'>
					  <label class="bold">TINGKAT</label>
					  <select class="form-select" name="level" required style="width: 100%">
						<option value="<?= $skl['tingkat'] ?>"><?= $skl['tingkat'] ?></option>
						<?php
						$stmt = $pdo->query("SELECT level FROM m_kelas GROUP BY level");
						while ($kelas = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<option value='{$kelas['level']}'>{$kelas['level']}</option>";
						}
						?>
					</select>
					</div>
					<div class='col-md-2'>
					  <label class="bold">KURIKULUM</label>
					  <select class="form-select" name="kuri" required style="width: 100%">
						<option value="<?= $skl['kuri'] ?>"><?= $kuri ?></option>
						<option value="1">K 13</option>
						<option value="2">Merdeka</option>
					</select>
					</div>
					<div class='col-md-4'>
					  <label class="bold">PENGUMUMAN DIBUKA</label>
					   <input type="text" class="tgl form-control" name="buka" value="<?= $skl['dibuka'] ?>" >
					</div>
					<div class='col-md-4'>
					  <label class="bold">PENGUMUMAN DITUTUP</label>
					   <input type="text" class="tgl form-control" name="tutup" value="<?= $skl['ditutup'] ?>" >
					</div>
					<div class='col-md-4'>
					  <label class="bold">NAMA SURAT</label>
					   <input type="text" class="form-control" name="nama" value="<?= $skl['nama_surat'] ?>" >
					</div>
					
					<div class='col-md-4'>
					  <label class="bold">NOMOR SURAT</label>
					   <input type="text" class="form-control" name="no_surat" value="<?= $skl['no_surat'] ?>" >
					</div>
					
					<div class='col-md-4'>
					  <label class="bold">TANGGAL SURAT</label>
					  <input type="text" class="form-control" name="tgl_surat" value="<?= $skl['tgl_surat'] ?>" >
					</div>
					<div class='col-md-4'>
					  <label class="bold">HEADER SURAT</label>
					  <input type="file" class="form-control" name="file" >
					</div>
					<div class='col-md-8'>
					 <?php if(!empty($skl['header'])): ?>
					 <img src="../images/<?= $skl['header'] ?>" style="max-width:200px">
					 <?php endif; ?>
					</div>
					
					<div class='col-md-6'>
					  <label class="bold">PEMBUKA SURAT</label>
					  <textarea name="pembuka"  class='editor1'><?= $skl['pembuka'] ?></textarea>
					</div>
					
					 <div class='col-md-6'>
					  <label class="bold">ISI SURAT</label>
					  <textarea name="isi"  class='editor1'><?= $skl['isi_surat'] ?></textarea>
					</div>
				   
					 <div class='col-md-12'>
					  <label class="bold">PENUTUP SURAT</label>
						 <textarea name="penutup" class='editor1'><?= $skl['penutup'] ?></textarea>
					</div>
					<div class='col-md-3'>
						<label class="bold">TTD</label><br>
						<input type="hidden" name="std" value="0"> 
						<input type="checkbox" name="std" value="1" <?php if($skl['sttd']==1) echo 'checked'; ?>>
						<?= ($skl['sttd']==1) ? 'Ya' : 'Tidak'; ?>
					</div>

					 <div class='col-md-4'>
					  <label class="bold">TTD</label>
					  <input type="file" class="form-control" name="ttd" >
					</div>
					<div class='col-md-5'>
					 <?php if(!empty($skl['ttd'])): ?>
					 <img src="../images/<?= $skl['ttd'] ?>" style="max-width:80px">
					 <?php endif; ?>
					</div>
					
					
					<div class='col-md-3'>
						<label class="bold">STEMPEL</label><br>
						<input type="hidden" name="sstp" value="0"> 
						<input type="checkbox" name="sstp" value="1" <?php if($skl['sstp']==1) echo 'checked'; ?>>
						<?= ($skl['sstp']==1) ? 'Ya' : 'Tidak'; ?>
					</div>
					<div class='col-md-4'>
					  <label class="bold">STEMPEL</label>
					  <input type="file" class="form-control" name="stp" >
					</div>
					<div class='col-md-5'>
					 <?php if(!empty($skl['stempel'])): ?>
					 <img src="../images/<?= $skl['stempel'] ?>" style="max-width:80px">
					 <?php endif; ?>
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
             url: 'skl/tskl.php',
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
