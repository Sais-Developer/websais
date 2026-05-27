<?php
defined('APK') or exit('No Acces');

?>           
<div class="row">
   <div class="col-md-8">
		<div class="card">
			<div class="card-header">
					<h5 class="card-title"><?= strtoupper($user['nama']) ?></h5>
				</div>
			<div class="card-body">
				<?php if($user['foto'] !=''): ?>
				   <img src="../images/fotoguru/<?= $user['foto'] ?>" alt="" class="responsive-img">
				    <?php else: ?>
				     <img src="../images/user.png" alt="" class="responsive-img">
				    <?php endif; ?>
				</div>
			</div>
		</div>
<div class="col-md-4">
  <div class="card">
	  <div class="card-header">
		<h5 class="card-title">PROFILKU</h5>
	</div>
<div class="card-body">
	<form id='formedit' class="row g-2">	
		<label class="bold">N I P</label>
		  <div class="input-group">
		   <input type='text' name='nip' value="<?= $user['nip'] ?>" class='form-control' required='true' />
			<input type='hidden' name='idguru' value="<?= $user['id_guru'] ?>" class='form-control' required='true' />
			</div>	
		<label class="bold">Nama Lengkap</label>
		  <div class="input-group">
		   <input type='text' name='nama' value="<?= $user['nama'] ?>" class='form-control' required='true' />
			</div>
		<label class="bold">Username</label>
		  <div class="input-group">
			 <input type='text' name='username' value="<?= $user['username'] ?>" class='form-control' readonly />
			</div>
		<label class="bold">Password</label>
		  <div class="input-group">
			 <input type='text' name='password' value="<?= $user['password'] ?>"  class='form-control' >
			</div>
		<label class="bold">Jabatan</label>
		  <div class="input-group">
		  <select name="jenis" class="form-select" style="width:100%"  >
			  <option value="<?= $user['jabatan'] ?>"><?= $user['jabatan'] ?></option>
			  <option value="">Pilih Jabatan</option>
			  <option value="Guru Mapel">Guru Mapel</option>
			  <option value="Guru BK">Guru BK</option>
			  <option value="Guru Kelas">Guru Kelas</option>
		  </select>
			</div>
		<label class="bold">Nomor WA</label>
		  <div class="input-group">
			  <input type='number' name='nowa' value="<?= $user['nowa'] ?>" class='form-control' required='true' />
			</div>
		<label class="bold">Wali Kelas</label>
		  <div class="input-group">
		  <select name="walas" class="form-select" style="width:100%" >
		   <option value="<?= $user['walas'] ?>"><?= $user['walas'] ?></option>
		  <option value="Bukan Walas">Bukan Walas</option>
		   <?php $q = mysqli_query($koneksi, "select kelas from m_kelas");
				while ($data = mysqli_fetch_assoc($q)) { ?>
				<option value="<?= $data['kelas'] ?>"><?= $data['kelas'] ?></option>
				<?php } ?>
		  </select>
			</div>			
		<label class="bold">Foto Jika Ada</label>
		  <div class="input-group mb-3">
			 <input type='file' name='file' class='form-control'/>
			</div>	
		<div class="d-flex justify-content-end align-items-center mb-2">
				 <button type="submit" class="btn btn-primary">Simpan</button>
			   </div>
			</form>
		 </div>
	  </div>
	</div>
</div>
<script>
    $('#formedit').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'master/tguru.php?pg=edit',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="../images/animasi1.gif" ></div>');
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
                                  
								