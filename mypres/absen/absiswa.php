<?php
defined('APK') or exit('No Access');
?>

<style>
.table-wrapper {
    overflow: auto;
}

.text-center {
    text-align: center;
}

.table-siswa, .table-date {
    border-collapse: collapse;
    width: 100%;
    margin: 0;
    padding: 0;
}

.table-siswa td {
    border: 1px solid silver;
    position: relative;
    padding: 5px;
}

/* Kotak radio custom */
.label-checkbox {
    position: relative;
    display: block;
    width: 100%;
    height: 30px;
    background: #cecece;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
}

.label-checkbox input {
    display: none; 
}

.label-checkbox:hover {
    background: #bff8ff;
}

.label-checkbox input:checked + .checkmark {
    background-color: #2196F3;
    color: #fff;
}

.checkmark {
    position: absolute;
    top: 0; left: 0;
    right: 0; bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: transparent;
    border-radius: 4px;
}

.label-checkbox input:checked + .checkmark::before {
    content: "✔";
    color: #fff;
    font-size: 16px;
}
</style>
<div class="row">
<div class="col-xl-8">
	<div class="card">
		<div class="card card-header">
			<h5 class="card-title bold">INPUT MANUAL</h5>
		</div>
		<div class="card-body">
			<form id="formabsen">
		<input type="hidden" name="kelasmu" value="<?= $kelas; ?>">
		<div class="table-wrapper">
			<table class="table-siswa">
			<thead>
				<tr>
					<td width="10%" class="text-center bold">NO</td>
					<td class="text-center bold">N I S</td>
					<td class="text-center bold">NAMA LENGKAP</td>
					<td class="text-center bold">JK</td>
					<td width="6%" class="text-center bold">S</td>
					<td width="6%" class="text-center bold">I</td>
					<td width="6%" class="text-center bold">A</td>
				</tr>
			</thead>
				<tbody class="table-body-content">
				<?php
				$no = 0;
				$tanggal = date('Y-m-d'); 
				$kelas = $_GET['kelas'] ?? '';

				if (!empty($kelas)) {
					$sql = "SELECT * FROM siswa 
							WHERE kelas = :kelas 
							AND blok = '0'
							AND NOT EXISTS (
								SELECT 1 FROM absensi 
								WHERE siswa.id_siswa = absensi.idsiswa 
								AND absensi.tanggal = :tanggal
							)";
					$stmt = $db->prepare($sql);
					$stmt->execute([
						'kelas' => $kelas,
						'tanggal' => $tanggal
					]);

					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$no++;
				?>
				<tr>
					<input type="hidden" name="tanggal[]" value="<?= htmlspecialchars($tanggal) ?>">
					<input type="hidden" name="kelas[]" value="<?= htmlspecialchars($data['kelas']) ?>">
					<input type="hidden" name="level[]" value="siswa">
					<input type="hidden" name="bulan[]" value="<?= date('m') ?>">
					<input type="hidden" name="tahun[]" value="<?= date('Y') ?>">

					<td><?= $no; ?> <input type="checkbox" name="idsiswa[]" value="<?= intval($data['id_siswa']) ?>"></td>
					<td class="text-center"><?= htmlspecialchars($data['nis']) ?></td>
					<td><?= htmlspecialchars($data['nama']) ?></td>
					<td class="text-center"><?= htmlspecialchars($data['jk']) ?></td>
					<td>
						<label class="label-checkbox">
							<input type="radio" name="ket[<?= intval($data['id_siswa']) ?>]" value="S">
							<span class="checkmark"></span>
						</label>
					</td>
					<td>
						<label class="label-checkbox">
							<input type="radio" name="ket[<?= intval($data['id_siswa']) ?>]" value="I">
							<span class="checkmark"></span>
						</label>
					</td>
					<td>
						<label class="label-checkbox">
							<input type="radio" name="ket[<?= intval($data['id_siswa']) ?>]" value="A">
							<span class="checkmark"></span>
						</label>
					</td>
				</tr>
				<?php endwhile; } ?>
				</tbody>
			</table>
				<div class="mb-3"></div>
				<?php if ($kelas !== ''): ?>
				<div class="d-flex justify-content-end align-items-center">
					<button type="submit" class="btn btn-primary">SIMPAN</button>
				</div>
				<?php endif; ?>
			</div>
		</form>
	  </div>
	</div>
</div>
<div class="col-md-4">
  <div class="card">
  <div class="card-body">
	<div class="d-flex align-items-center flex-column mb-0">
      <div class="sw-13 position-relative mb-0">
    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
       </div>
	     <div class="text-muted"><?= $setting['sekolah'] ?></div>
        <div class="text-muted">HIGH SCHOOL</div>
       </div>
           <div class="widget-payment-request-info m-t-md"> 	 
			<div class="col-md-12 mb-4">
				<label class="bold">KELAS</label>
				<select class="form-select kelas">
					<option value=''>Pilih Kelas</option>
					<?php
					$sql = "SELECT DISTINCT kelas FROM siswa ORDER BY kelas ASC";
					$stmt = $db->query($sql);
					$kelas_selected = $kelas ?? '';

					while ($kls = $stmt->fetch(PDO::FETCH_ASSOC)) :
						$selected = ($kelas_selected == $kls['kelas']) ? "selected" : "";
					?>
						<option value="<?= htmlspecialchars($kls['kelas']) ?>" <?= $selected ?>>
							<?= htmlspecialchars($kls['kelas']) ?>
						</option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="d-grid gap-2 mb-4">
				<button id="pilih" class="btn btn-primary">PILIH</button>
			</div>
			<div class="mb-4">
				<p class="text-small text-muted mb-2">ALAMAT</p>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">home</i></div>
					<div class="col text-alternate"><?= $setting['alamat'] ?></div>
				</div>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">star</i></div>
					<div class="col text-alternate"><?= $setting['desa'] ?></div>
				</div>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">sync</i></div>
					<div class="col text-alternate"><?= $setting['kecamatan'] ?></div>
				</div>
			</div>
			<div class="mb-4">
				<p class="text-small text-muted mb-2">CONTACT</p>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">phone</i></div>
					<div class="col text-alternate"><?= $setting['nowa'] ?></div>
				</div>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">inbox</i></div>
					<div class="col text-alternate"><?= $setting['email'] ?></div>
				</div>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">language</i></div>
					<div class="col text-alternate"><?= $setting['server'] ?></div>
				</div>
			</div>
			<div class="mb-4">
				<p class="text-small text-muted mb-2">KEPALA SEKOLAH</p>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">person</i></div>
					<div class="col text-alternate"><?= $setting['kepsek'] ?></div>
				</div>
				<div class="row g-0 mb-2">
					<div class="col-auto"><i class="material-icons text-info" style="font-size:18px">payment</i></div>
				<div class="col text-alternate"><?= $setting['nip'] ?></div>
			 </div>
		  </div>
		</div>
	 </div>
  </div>
 </div>
</div>

<script>

$('#pilih').click(function() {
    var kelas = $('.kelas').val();
    location.replace("?pg=<?= enkripsi('absiswa') ?>&kelas=" + kelas);
});

if ($("#formabsen").length) {
    $('#formabsen').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'absen/input.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#progressbox').html('<div><img src="<?= $baseurl ?>/images/animasi.gif" style="width:50px;"></div>');
            },
            success: function(data) {
                setTimeout(function() {
                    window.location.replace('?pg=<?= enkripsi("presis") ?>');
                }, 2000);
            }
        });
        return false;
    });
}
</script>
