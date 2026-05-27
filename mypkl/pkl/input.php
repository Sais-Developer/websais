<?php
defined('APK') or exit('No Access');
 $kelas = $_GET['k'] ?? '';
 $guru = $_GET['g'] ?? '';
 $dudi = $_GET['d'] ?? '';
?>     
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"> PILIH SISWA</h5>
            </div>
            <div class="card-body">									
                <form id="formsiswa" class="row g-2">
					<input type="hidden" name="dudi" value="<?= $dudi ?>" >
					<input type="hidden" name="kelas" value="<?= $kelas ?>" >
					<input type="hidden" name="guru" value="<?= $guru ?>" >
                    <table id="datatable1" class="table table-bordered" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">&nbsp;<input type="checkbox" id="check-all"></th>                                               
                                <th class="text-center">NIS</th>
                                <th>NAMA PESERTA</th>
                                <th class="text-center">KELAS</th>	
                                <th class="text-center">JK</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$sql = "
								SELECT id_siswa, nis, nama, jk
								FROM siswa s
								WHERE s.kelas = :kelas
								  AND NOT EXISTS (
									  SELECT 1 
									  FROM pkl_siswa p 
									  WHERE p.idsiswa = s.id_siswa
								  )
							";

							$stmt = $pdo->prepare($sql);
							$stmt->execute(['kelas' => $kelas]);

							$no = 0;
							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
								$no++;
							?>
							<tr>
								<td class="text-center">
									<input type="checkbox" name="idsiswa[]" id="check<?= $no; ?>" 
										   class="checkbox" value="<?= htmlspecialchars($data['id_siswa']); ?>">
								</td>
								<td class="text-center"><?= htmlspecialchars($data['nis']); ?></td>
								<td><?= htmlspecialchars($data['nama']); ?></td>
								<td class="text-center"><?= htmlspecialchars($kelas); ?></td>
								<td class="text-center"><?= htmlspecialchars($data['jk']); ?></td>
							</tr>
							<?php
							endwhile;
							$stmt = null;
							?>
                        </tbody>
                    </table>
					<div class="d-flex justify-content-end">
						<?php if($kelas != ''): ?>
							<button type="submit" class="btn btn-primary">Simpan</button>
						<?php endif; ?>
					</div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-column mb-4">
                        <div class="sw-13 position-relative mb-3">
                            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                        </div>
                        <div class="text-muted"><?= $setting['sekolah'] ?? '' ?></div>
                        <div class="text-muted">HIGH SCHOOL</div>
                    </div>
                     <div class="col-md-12 mb-1">
						<label class="bold">GURU PEMBIMBING</label>
							<select  id="guru" class="form-select" style="width:100%" required>
								<option value="">Pilih Guru</option>
								<?php
								$level = 'guru';
								$stmt = $pdo->prepare("SELECT id_guru, nama FROM guru WHERE level = :level");
								$stmt->execute(['level' => $level]);

								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$selected = ($guru == $data['id_guru']) ? 'selected' : '';
									?>
									<option value="<?= htmlspecialchars($data['id_guru']); ?>" <?= $selected; ?>>
										<?= htmlspecialchars($data['nama']); ?>
									</option>
								<?php
								}
								$stmt = null;
								?>
							</select>
					</div>
                      <div class="col-md-12 mb-1">
						<label class="bold">KELAS</label>
							<select  id="kelas" class="form-select" style="width:100%" required>
								<option value="">Pilih Kelas</option>
								<?php
									$stmt = $pdo->prepare("SELECT kelas FROM m_kelas");
									$stmt->execute();

									while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
										$selected = ($kelas == $data['kelas']) ? 'selected' : '';
										?>
										<option value="<?= htmlspecialchars($data['kelas']); ?>" <?= $selected; ?>>
											<?= htmlspecialchars($data['kelas']); ?>
										</option>
									<?php
									}
									$stmt = null;
									?>
							</select>
					</div>
					  <div class="col-md-12 mb-1">
						<label class="bold">NAMA DUDI</label>
							<select  id="dudi" class="form-select" style="width:100%" required>
								<option value="">Pilih Dudi</option>
								<?php
								$stmt = $pdo->prepare("SELECT id, nama_dudi FROM pkl_dudi");
								$stmt->execute();

								while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$selected = ($dudi == $data['id']) ? 'selected' : '';
									?>
									<option value="<?= htmlspecialchars($data['id']); ?>" <?= $selected; ?>>
										<?= htmlspecialchars($data['nama_dudi']); ?>
									</option>
								<?php
								}
								$stmt = null;
								?>
							</select>
					</div>
					<div class="widget-payment-request-actions m-t-lg d-flex">
						<button id="pilih" class="btn btn-primary flex-grow-1 m-l-xxs">Pilih</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript">
	$('#pilih').click(function() {
	var g = $('#guru').val();	
	var k = $('#kelas').val();
	var d = $('#dudi').val();
	
	location.replace("?pg=<?= enkripsi('pembina') ?>&k=" + k + "&g=" + g + "&d=" + d);
	}); 
</script>
		
<script>
$('#formsiswa').submit(function(e){
e.preventDefault();
var data = new FormData(this);
$.ajax(
{
	type: 'POST',
	 url: 'pkl/tpkl.php?pg=tambah',
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
$(function(){ 
$("#check-all").click(function(){
if ( (this).checked == true ){
$('.checkbox').prop('checked', true);
} else {
$('.checkbox').prop('checked', false);
}
 });
});
</script>