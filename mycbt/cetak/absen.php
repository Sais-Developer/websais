<?php
defined('APK') or exit('No Access');
?>
<div class="row"> 
        <div class="col-md-8">
            <div class="card">
			<div class="card card-header">
			<h5 class="card-title">DAFTAR HADIR PESERTA </h5>
			 </div>
              <div class="card-body">
				<p></p>			  
                    <div class="row mb-2">
                       <label  class="col-sm-3 control-label bold">Pilih Mapel</label>
                        <div class="col-sm-9">
						<select id="absenmapel" class="form-select" required onchange="printabsen();">
							<option value="">Pilih Jadwal Ujian</option>
							<?php
							$stmt_mapel = $pdo->prepare("
								SELECT u.*, b.kode, b.tingkat, b.id_bank
								FROM ujian u 
								JOIN banksoal b ON b.id_bank = u.idbank
							");
							$stmt_mapel->execute();
							$mapelList = $stmt_mapel->fetchAll(PDO::FETCH_ASSOC);

							foreach ($mapelList as $mapel):
							?>
								<option value="<?= $mapel['id_bank']; ?>">
									<?= htmlspecialchars($mapel['kode'] . " Tingkat " . $mapel['tingkat']); ?>
								</option>
							<?php endforeach; ?>
						</select>
                    </div>
                   </div>
				 
                  <div class="row mb-2">
                       <label  class="col-sm-3 control-label bold">Pilih Ruang</label>
						<div class="col-sm-9">
                        <select id='absenruang' class='form-select' onchange="printabsen();" >

                        </select>
                    </div>
					</div>
					 <div class="row mb-2">
                       <label  class="col-sm-3 control-label bold">Pilih Sesi</label>
						<div class="col-sm-9">
                        <select id='absensesi' class='form-select' onchange="printabsen();" >
                        </select>
                    </div>
					</div>
					 <div class="row mb-2">
                       <label  class="col-sm-3 control-label bold">Pilih Kelas</label>
						<div class="col-sm-9 mb-4">
                        <select id='absenkelas' class='form-select' onchange="printabsen();" >
                        </select>
                    </div>
					</div>
					<div class="row mb-2">
                        <label  class="col-sm-2 control-label bold"></label>
				        <div class="col-md-10 text-end"> 
							<button id="btnabsen" class="btn btn-primary" onclick="frames['frameresult'].print()">
								<i class="material-icons">print</i> Print
							</button>

						   
							<iframe id="loadabsen" name="frameresult" src="cetak/print_absen.php"
									style="display:none; width:0; height:0; border:none;"></iframe>
						</div>
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
                  <div class="mb-4">
                    <p class="text-small text-muted mb-2">ALAMAT</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i class="material-icons text-info" style="font-size:18px">home</i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?= $setting['alamat'] ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                            <i class="material-icons text-info" style="font-size:18px">star</i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?= $setting['desa'] ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                           <i class="material-icons text-info" style="font-size:18px">sync</i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <p class="text-small text-muted mb-2">CONTACT</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                            <i class="material-icons text-info" style="font-size:18px">phone</i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?= $setting['nowa'] ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                           <i class="material-icons text-info" style="font-size:18px">inbox</i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?= $setting['email'] ?></div>
                    </div>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                          <i class="material-icons text-info" style="font-size:18px">language</i>
                        </div>
                      </div>
                      <div class="col text-alternate"><?= $setting['server'] ?></div>
                    </div>
                  </div>
                  <div class="mb-4">
                    <p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
                    <div class="row g-0 mb-2">
                      <div class="col-auto">
                        <div class="sw-3 me-1">
                         <i class="material-icons text-info" style="font-size:18px">person</i>
                        </div>
                      </div>
                      <div class="col text-alternate align-middle"><?= $setting['kepsek'] ?></div>
                    </div>
                    <div class="row g-0 mb-2">
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
    function printabsen() {
        var idsesi = $('#absensesi option:selected').val();
        var idmapel = $('#absenmapel option:selected').val();
        var idruang = $('#absenruang option:selected').val();
        var idkelas = $('#absenkelas option:selected').val();
        if (!idkelas) {
            idkelas = '';
        }
        if (!idsesi) {
            idsesi = '';
        }
        $('#loadabsen').attr('src', 'cetak/print_absen.php?id_sesi=' + idsesi + '&id_ruang=' + idruang + '&id_bank=' + idmapel + '&id_kelas=' + idkelas);
    }
    $("#absenmapel").change(function() {
        var mapel_id = $(this).val();
        console.log(mapel_id);
        $.ajax({
            type: "POST", 
            url: "cetak/ambildata.php?pg=ambil_ruang", 
            data: "mapel_id=" + mapel_id, 
            success: function(response) { 
                $("#absenruang").html(response);
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $("#absensesi").change(function() {
        var sesi = $(this).val();
        var mapel_id = $("#absenmapel").val();
        var ruang = $("#absenruang").val();
        console.log(sesi + ruang + mapel_id);
        $.ajax({
            type: "POST",
            url: "cetak/ambildata.php?pg=ambilkelas", 
            data: "mapel_id=" + mapel_id + '&sesi=' + sesi + '&ruang=' + ruang, 
            success: function(response) { 
                $("#absenkelas").html(response);
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $("#absenruang").change(function() {

        var ruang = $(this).val();
        console.log(ruang);
        $.ajax({
            type: "POST", 
            url: "cetak/ambildata.php?pg=ambil_sesi", 
            data: "ruang=" + ruang, 
            success: function(response) { 
                $("#absensesi").html(response);
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
</script>