<style>
/* Default: mobile tabs disembunyikan di desktop */
.wizard-tabs-mobile {
    display: none;
}

/* Mobile (≤ 768px) */
@media(max-width: 768px) {

    /* Tampilkan tombol mobile */
    .wizard-tabs-mobile {
        display: flex !important;
        overflow-x: auto;
        gap: 10px;
        padding: 10px 0;
    }

    /* Sembunyikan sidebar */
    .wizard-sidebar {
        display: none !important;
    }

    .wizard-wrapper {
        flex-direction: column;
    }

    .wizard-step {
        flex-direction: column;
        padding: 8px;
        min-width: 70px;
        background: #f1f1f1;
        border-radius: 6px;
        text-align: center;
        cursor: pointer;
    }

    .wizard-step .circle {
        margin-bottom: 5px;
    }

    .wizard-step.active {
        background: #0d6efd;
        color: #fff;
    }
}

</style>
<div class="card wizard-tabs-mobile">
    <div class="card-header">
        <h5 class="card-title">MY PROFIL</h5>
    </div>

    <div class="card-body">
        <form id="formedit">
          <input type="hidden" name="ids" value="<?= $siswa['id_siswa'] ?>" >
            <div class="wizard-wrapper">

                <!-- SIDEBAR -->
                <div class="wizard-tabs-mobile">
                    <div class="wizard-step active" onclick="showStep(1)">
                        <div class="circle">1</div>
                        <div>Person</div>
                    </div>
                    <div class="wizard-step" onclick="showStep(2)">
                        <div class="circle">2</div>
                        <div>Lahir</div>
                    </div>
                    <div class="wizard-step" onclick="showStep(3)">
                        <div class="circle">3</div>
                        <div>Alamat</div>
                    </div>
                    <div class="wizard-step" onclick="showStep(4)">
                        <div class="circle">4</div>
                        <div>Orang Tua</div>
                    </div>
                    <div class="wizard-step" onclick="showStep(5)">
                        <div class="circle">5</div>
                        <div>Foto Profil</div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="wizard-content">

                    <!-- STEP 1 -->
                    <div id="step1" class="step-content">
                        <h5 class="card-title">Personal Info</h5>

                        <div class="mb-3">
                            <label class="bold">Nama Lengkap</label>
                            <input type="text" name="nama" value="<?= $siswa['nama'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Username</label>
                            <input type="text" value="<?= $siswa['username'] ?>" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Password</label>
                            <input type="text" name="password" value="<?= $siswa['password'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Nomor WA</label>
                            <input type="number" name="nowa" value="<?= $siswa['nowa'] ?>" class="form-control" required>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div id="step2" class="step-content d-none">
                        <h5 class="card-title">Lahir</h5>

                        <div class="mb-3">
                            <label class="bold">Tempat Lahir</label>
                            <input type="text" name="tlahir" value="<?= $siswa['t_lahir'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Tanggal Lahir</label>
                            <input type="text" name="tgl_lahir" value="<?= $siswa['tgl_lahir'] ?>" class="form-control" required placeholder="12 Agustus 2000">
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div id="step3" class="step-content d-none">
                        <h5 class="card-title">Alamat</h5>

                        <div class="mb-3">
                            <label class="bold">Alamat</label>
                            <input type="text" name="alamat" value="<?= $siswa['alamat'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Desa</label>
                            <input type="text" name="desa" value="<?= $siswa['desa'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Kecamatan</label>
                            <input type="text" name="kec" value="<?= $siswa['kec'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Kabupaten</label>
                            <input type="text" name="kab" value="<?= $siswa['kab'] ?>" class="form-control" required>
                        </div>
                    </div>

                    <!-- STEP 4 -->
                    <div id="step4" class="step-content d-none">
                        <h5 class="card-title">Orang Tua</h5>

                        <div class="mb-3">
                            <label class="bold">Nama Ayah</label>
                            <input type="text" name="ayah" value="<?= $siswa['ayah'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Pekerjaan</label>
                            <input type="text" name="pek_ayah" value="<?= $siswa['pek_ayah'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Nama Ibu</label>
                            <input type="text" name="ibu" value="<?= $siswa['ibu'] ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="bold">Pekerjaan Ibu</label>
                            <input type="text" name="pek_ibu" value="<?= $siswa['pek_ibu'] ?>" class="form-control" required>
                        </div>
                    </div>

                    <!-- STEP 5 -->
                    <div id="step5" class="step-content d-none">
                        <h5 class="card-title">Foto Profil</h5>

                        <div class="mb-3">
                            <label class="bold">Foto Baru</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <?php if($siswa['foto'] !=''): ?>
                                <img src="images/fotosiswa/<?= $siswa['foto'] ?>" class="responsive-img">
                            <?php else: ?>
                                <img src="images/user.png" class="responsive-img">
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-success btn-md mt-2">Simpan</button>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>

<script>
function showStep(step) {
    document.querySelectorAll(".step-content").forEach(div => div.classList.add("d-none"));
    document.querySelector("#step" + step).classList.remove("d-none");
    document.querySelectorAll(".wizard-step").forEach(btn => btn.classList.remove("active"));
    let desktopBtn = document.querySelectorAll(".wizard-sidebar .wizard-step")[step - 1];
    if (desktopBtn) desktopBtn.classList.add("active");
    let mobileBtn = document.querySelectorAll(".wizard-tabs-mobile .wizard-step")[step - 1];
    if (mobileBtn) mobileBtn.classList.add("active");
}
</script>

 <script>
    $('#formedit').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/tsiswa.php?pg=edit',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="images/animasi.gif" style="width:50px;"></div>');
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