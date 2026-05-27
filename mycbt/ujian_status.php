<style>
table {
    width: 100%; 
    border-collapse: collapse; 
}

td {
    padding: 8px 12px; 
    line-height: 0.8; 
    height: auto; 
    border: 1px solid #ccc; 
    text-align: left; 
	font-size: 12px;
}

th {
    padding: 8px 12px;
    background-color: #f2f2f2; 
    border: 1px solid #ccc;
}

table, th, td {
    border: 1px solid #ccc;
}
.mini-card {
      display: flex;
      align-items: center;
      justify-content: start;
      padding: 10px;
      border-radius: 12px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.05);
      margin: 5px;
      background: #fff;
      min-width: auto;   /* kecil */
      max-width: auto;
    }
    .mini-icon {
      font-size: 24px;
      border-radius: 10px;
      padding: 5px;
      margin-right: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .mini-text {
      font-size: 12px;
      color: #666;
      margin: 0;
    }
    .mini-value {
      font-size: 18px;
      font-weight: bold;
      margin: 0;
      color: #0d1b2a;
    }
   .bg-soft-green { background: #e6f8ed; color: #2e7d32; }
	.bg-soft-red   { background: #fde8e8; color: #d32f2f; }
	.bg-soft-blue  { background: #e7f1ff; color: #1565c0; }
	.bg-soft-purple{ background: #f3e8fd; color: #6a1b9a; }
	
</style>
<?php
include "../konek/koneksi.php";
include "../konek/function.php";
?>
<?php
$idu = $_GET['idu'] ?? '';

if (!$idu) {
    die("ID Jadwal ujian tidak ditemukan. (idu kosong)");
}

$stmtUji = $pdo->prepare("
    SELECT u.*, b.*, m.* 
    FROM ujian u
    LEFT JOIN banksoal b ON b.id_bank = u.idbank
    LEFT JOIN mapel m ON m.id = b.idmapel
    WHERE u.id_jadwal = ?
");
$stmtUji->execute([$idu]);
$uji = $stmtUji->fetch(PDO::FETCH_ASSOC);

if (!$uji) {
    die("Data ujian tidak ditemukan untuk id_jadwal = $idu");
}

$id_bank = $uji['idbank'] ?? '';
$sesi    = $uji['sesi'] ?? '';
$zer0 = 0;
$two = 2;
$one = 1;

if (!$id_bank || !$sesi) {
    die("Parameter id_bank atau sesi kosong. id_bank=[$id_bank], sesi=[$sesi]");
}

$stmtBelumLogin = $pdo->prepare("
    SELECT COUNT(*) 
    FROM siswa s
    WHERE s.sesi = ? 
      AND NOT EXISTS (
          SELECT 1 FROM nilai n 
          WHERE n.id_siswa = s.id_siswa 
            AND n.id_bank = ?
           
      )
");
$stmtBelumLogin->execute([$sesi, $id_bank]);
$belum_login = $stmtBelumLogin->fetchColumn();



$stmtReset = $pdo->prepare("
    SELECT COUNT(*) 
    FROM nilai n LEFT JOIN siswa s ON s.id_siswa=n.id_siswa
    WHERE s.sesi = ? 
     AND n.id_bank = ?
     AND n.hapus = ?
");
$stmtReset->execute([$sesi, $id_bank, $one]);
$mintareset = $stmtReset->fetchColumn();


$stmtSedangUjian = $pdo->prepare("
    SELECT COUNT(*) 
    FROM nilai n
    JOIN siswa s ON s.id_siswa = n.id_siswa
    WHERE n.id_bank = ?
      AND s.sesi = ?
      AND n.ujian_selesai IS NULL
      AND n.hapus = ?
");
$stmtSedangUjian->execute([$id_bank, $sesi, $two]);
$sedang_ujian = $stmtSedangUjian->fetchColumn();

$stmtSelesaiUjian = $pdo->prepare("
    SELECT COUNT(*) 
    FROM nilai n
    JOIN siswa s ON s.id_siswa = n.id_siswa
    WHERE n.id_bank = ?
      AND s.sesi = ?
      AND n.ujian_selesai IS NOT NULL
      AND n.hapus = 0
");
$stmtSelesaiUjian->execute([$id_bank, $sesi]);
$selesai_ujian = $stmtSelesaiUjian->fetchColumn();


$stmtNilaiTinggi = $pdo->prepare("
    SELECT s.nama, n.nilai 
    FROM nilai n
    JOIN siswa s ON s.id_siswa = n.id_siswa
    WHERE n.id_bank = ?
      AND s.sesi = ?
      AND n.hapus = 0
    ORDER BY n.nilai DESC
    LIMIT 1
");
$stmtNilaiTinggi->execute([$id_bank, $sesi]);
$nilaiTinggi = $stmtNilaiTinggi->fetch(PDO::FETCH_ASSOC);

$nama_tertinggi  = $nilaiTinggi['nama'] ?? '-';
$nilai_tertinggi = $nilaiTinggi['nilai'] ?? 0;

?>


  <div class="row">
       <div class="row g-1">
    <div class="col-6 col-md-3">
      <div class="mini-card">
        <div class="mini-icon bg-soft-green">
          <i class="material-icons">login</i>
        </div>
        <div>
          <p class="mini-text">Belum Login || Minta Reset</p>
          <p class="mini-value">		  
		   <?= $belum_login; ?> <small>Siswa</small> || <?= $mintareset; ?> <small>Siswa</small>
		  </p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="mini-card">
        <div class="mini-icon bg-soft-purple">
          <i class="material-icons">person</i>
        </div>
        <div>
          <p class="mini-text">Sedang Ujian</p>
          <p class="mini-value">
		  <?= $sedang_ujian; ?> <small>Siswa</small>
		  </p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="mini-card">
        <div class="mini-icon bg-soft-blue">
          <i class="material-icons">home</i>
        </div>
        <div>
          <p class="mini-text">Selesai Ujian</p>
          <p class="mini-value">
		  <?= $selesai_ujian; ?> <small>Siswa</small>
		  </p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
     <div class="mini-card">
        <div class="mini-icon bg-soft-blue">
          <img src="<?= $baseurl ?>/images/siswa.png" style="max-width:30px">
        </div>
        <div>
          <p class="mini-text"><?= ucwords(strtolower($nama_tertinggi)) ?> </p>
          <p class="mini-value">
		  <?= number_format($nilai_tertinggi, 2, '.', ''); ?> 
		  </p>
        </div>
      </div>
    </div>
	</div>
<div class="col-md-12">				   
<div class='table-responsive'>
    <table class="table-analisis" id="status">
        <thead>
            <tr>
                <th width='5px'>#</th>
                <th>Kelas</th>
				<th>Nama Siswa</th>
                <th>IP Address</th>				
                <th>Lama Ujian</th>
				 <th>Nilai</th>
                <th>Status</th>
				
                <th>Action</th>
				
            </tr>
        </thead>
        <tbody>
		<?php
				$no = 0;
				$stmt = $pdo->prepare("
					SELECT n.*, s.* 
					FROM nilai n
					LEFT JOIN siswa s ON s.id_siswa = n.id_siswa
					WHERE n.id_ujian = ?
					ORDER BY n.id_nilai DESC
				");
				$stmt->execute([$idu]);
				$nilaiList = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($nilaiList as $data) {
					$no++;
					$ket = '';
					$lama = $nilai = '--';
					$ujian_mulai = $data['ujian_mulai'];
					$ujian_selesai = $data['ujian_selesai'];

					if ($ujian_mulai && $ujian_selesai) {
						$seconds = strtotime($ujian_selesai) - strtotime($ujian_mulai);
						$lama = lamaujian($seconds);
					}

					if (!empty($data['ujian_selesai'])) {
						if ($data['hapus'] == 1) {
							$btn = "<button data-id='{$data['id_nilai']}' class='reset btn btn-sm btn-icon btn-danger'>
										<i class='material-icons'>delete</i> Reset
									</button>";
							$ket = "<span class='badge bg-danger'>Minta Reset</span>";
						} else {
							if ($uji['kkm'] >= $data['nilai']) {
								$ket = "<span class='badge bg-warning'>Tidak Lulus</span>";
								$btn = "<button data-id='{$data['id_nilai']}' class='ulang btn btn-sm btn-icon btn-danger'>
											<i class='material-icons'>delete</i> Ulang
										</button>";
							} else {
								$ket = "<span class='badge bg-success'>Lulus</span>";
								$btn = "<button class='btn btn-sm btn-icon btn-icon-only btn-light' disabled>
											<i class='material-icons'>lock</i>
										</button>";
							}
						}
					} else {
						$ket = "<span class='badge bg-primary'>Sedang Ujian</span>";
						$btn = "<button class='btn btn-sm btn-icon btn-icon-only btn-light' disabled>
									<i class='material-icons'>lock</i>
								</button>";
					}
				
				?>

				<tr>
				<td><?= $no ?></td>
				<td><?= $data['kelas'] ?></td>
				<td><?= ucwords(strtolower($data['nama'])) ?></td>
				<td><?= $data['ipaddress'] ?></td>
				<td><?= $lama; ?></td>
				<td><?= number_format($data['nilai'], 2, '.', '') ?></td>
				<td><?= $ket ?></td>
				<td><?= $btn ?></td>
			</tr>
			<?php } ?>
        </tbody>
      </table>
	 </div>
   </div>
  </div>

<script>
$('#status').on('click', '.reset', function() {
	var id = $(this).data('id');
	Swal.fire({
		title: 'Reset Ujian',
		text: "Data Ujian akan direset",
		icon: 'warning',
		width: '320px',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Reset',
		cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: 'treset.php?pg=hapus',
				method: "POST",
				data: {id:id},
				
			});
		}
	});
});
</script>    
<script>
$('#status').on('click', '.ulang', function() {
	var id = $(this).data('id');
	Swal.fire({
		title: 'Ulang Ujian',
		text: "Data Ujian akan direset",
		icon: 'warning',
		width: '320px',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Ulang',
		cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: 'treset.php?pg=ulang',
				method: "POST",
				data: {id:id},
				
			});
		}
	});
});
</script>    
