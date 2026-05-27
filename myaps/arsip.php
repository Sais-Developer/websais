<style>
li.divider {
    margin: 5px 0;      
    padding: 0;          
    border-top: 1px solid #ccc; 
    list-style: none;    
}
</style>
<div class="app-content">
		<a href="#" class="content-menu-toggle btn btn-primary"><i class="material-icons">menu</i> content</a>
		<div class="content-menu content-menu-right">
			<ul class="list-unstyled">
				<li><a href="." class="active">Home</a></li>
				<li class="divider"></li>
				<li><a href="?pg=<?= enkripsi('arsip') ?>" class="active">Beranda</a></li>
				<li class="divider"></li>
				<?php if($user['level']=='admin' || $user['level']=='staff'): ?>
				<li><a href="?pg=<?= enkripsi('arsip') ?>&ac=<?= enkripsi('rapor') ?>">Cetak Arsip Rapor</a></li>
				<li><a href="?pg=<?= enkripsi('arsip') ?>&ac=<?= enkripsi('lampu8') ?>">IOT 8 Lampu (Multi Presensi)</a></li>
				<li><a href="?pg=<?= enkripsi('tabungan') ?>">Tabungan Siswa</a></li>
				<li><a href="?pg=<?= enkripsi('sapras') ?>">Sarana Prasarana</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="content-wrapper">
			<div class="container-fluid">
				<?php if (($ac ?? '') == ''): ?>
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Aplikasi Lainnya</h5>
								<p class="card-text">Meliputi berbagai macam aplikasi Non Akademik</p>
							</div>
						</div>
						
				</div>
			</div>
		</div>
		<?php
		$sql = "SELECT 
            SUM(debet) AS total_debit, 
            SUM(kredit) AS total_kredit, 
            (SUM(debet) - SUM(kredit)) AS saldo
        FROM saldo";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="row">
		<div class="col-xl-6">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['total_debit'], 0, ',', '.'); ?>
					</span>
					DATA SIMPANAN
					<span class="widget-bank-card-number mt-auto">
						<?= bulan_indo($tanggal); ?> <?= date('Y') ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['total_kredit'], 0, ',', '.'); ?>
					</span>
					DATA PENARIKAN
					<span class="widget-bank-card-number mt-auto">
						<?= bulan_indo($tanggal); ?> <?= date('Y') ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					MASTER CARD
					</span>
					<span class="widget-bank-card-balance">
						Rp. <?= number_format($data['saldo'], 0, ',', '.'); ?>
					</span>
					SALDO AKHIR
					<span class="widget-bank-card-number mt-auto">
						<?= bulan_indo($tanggal); ?> <?= date('Y') ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php 
	$sql = "SELECT COUNT(*) AS jumlah_on FROM lampu WHERE status = 'ON'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	?>
    <div class="col-xl-6">
       <div class="card widget widget-bank-card" style="height: 220px;">
         <div class="card-body">
				<div class="widget-bank-card-container widget-bank-card-mastercard d-flex flex-column">
					
					<span class="widget-bank-card-balance-title">
					INTERNET OF THINK
					</span>
					<span class="widget-bank-card-balance">
					 <?= $data['jumlah_on'] ?> Lampu
					</span>
					LAMPU SEDANG HIDUP
					<span class="widget-bank-card-number mt-auto">
						IOT 8 CH
					</span>
				</div>
			</div>
		</div>
	</div>
	</div>
		<?php elseif($ac == enkripsi('rapor')): ?>
		<?php 
			$ket = $_GET['ket'] ?? '';
			$tapel = $_GET['tp'] ?? '';
			$semester = $_GET['s'] ?? '';
		?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center flex-column mb-0">
				  <div class="sw-13 position-relative mb-3">
				<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" alt="Belajar" class="responsive-img">
				   </div>
				<div class="text-muted"><?= $setting['sekolah'] ?></div>
					<div class="text-muted mb-4">HIGH SCHOOL</div>
					<h5 class="card-title">Cetak Arsip Rapor Aktif</h5>
					<p class="card-text mb-4">Cetak Arsip Rapor. Jika database tidak direset maka semua data rapor dapat dicetak ulang di sini</p>
				   </div>
				   <?php if($ket=='PTS'): ?>
				   <form id="formcetak" class="row g-2" method="POST" action="arsip/rapor_pts" target="_blank">
				   <?php elseif($ket=='PAS'): ?>
				   <form id="formcetak" class="row g-2" method="POST" action="arsip/rapor_pas" target="_blank">
				   <?php elseif($ket=='PAT'): ?>
				   <form id="formcetak" class="row g-2" method="POST" action="arsip/rapor_pts" target="_blank">
				   <?php else: ?>
				    <form  class="row g-2">
				   <?php endif; ?>
				   <div class="col-md-4">	
					<label class="bold">Tahun Pelajaran</label>
						<select class="form-select" name="tapel" id="tapel" required style="width: 100%">
						   <option value="<?= htmlspecialchars($tapel) ?>"><?= $tapel ?></option>
							<option value="">Pilih Tapel</option>
							<?php
							$list_tapel = select("tanggal_rapor");
							foreach ($list_tapel as $tp) {
								$k = htmlspecialchars($tp['tapel']);
								echo "<option value='$k'>$k</option>";
							}
							?>
						</select>
					</div>		
				   <div class="col-md-4">	
					<label class="bold">Semester</label>
						<select class="form-select" name="semester" id="select1" onchange="updateSelect2()" required style="width: 100%">
							<option value="<?= $semester ?>"><?= $semester ?></option>
							<option value="">Pilih Semester</option>
							<option value="1">Semester 1</option>
							<option value="2">Semester 2</option>
						</select>
					</div>	
					 <div class="col-md-4">	
					<label class="bold">Jenis Rapor</label>
						<select class="form-select" name="ket" id="select2"  required style="width: 100%">
						<option value="<?= $ket ?>"><?= $ket ?></option>
						</select>
					</div>	
					<script type="text/javascript">
						$('#select2').change(function() {
						var ket = $('#select2').val();
						var tp = $('#tapel').val();
						var s = $('#select1').val();
						location.replace("?pg=<?= enkripsi('arsip') ?>&ac=<?= enkripsi('rapor') ?>&ket=" + ket + "&tp=" + tp + "&s=" + s);
						}); 
					</script>
					<div class="col-md-6">	
					<label class="bold">Kelas Saat itu</label>
						<select class="form-select" name="kelas" id="kelas" required style="width: 100%">
							<option value="">Pilih Kelas</option>
							<?php
							$list_kelas = select("m_kelas");
							foreach ($list_kelas as $kelas) {
								$k = htmlspecialchars($kelas['kelas']);
								echo "<option value='$k'>$k</option>";
							}
							?>
						</select>
						</div>
					<div class="col-md-6">	
					<label class="bold">Kelas Saat ini</label>
						<select class="form-select" id="sekarang" required style="width: 100%">
							<option value="">Pilih Kelas</option>
							<?php
							$list_kelas = select("m_kelas");
							foreach ($list_kelas as $kelas) {
								$k = htmlspecialchars($kelas['kelas']);
								echo "<option value='$k'>$k</option>";
							}
							?>
						</select>
						</div>
					<div class="col-md-12">	
						<label class="bold">Pilih Siswa</label>
							<select class="form-select" name="nis" id="siswa" required style="width: 100%">
							</select>
					</div>
					<div class="col-md-6">	
						<label class="bold">Wali Kelas Saat itu</label>
							<input type="text" name="walas" class="form-control" required>
					</div>
					<div class="col-md-6">	
						<label class="bold">NIP Wali Kelas Saat itu</label>
							<input type="text" name="nipwalas" class="form-control" required>
					</div>
					<div class="col-md-6">	
						<label class="bold">Kepsek Saat itu</label>
							<input type="text" name="kepsek" class="form-control" required>
					</div>
					<div class="col-md-6">	
						<label class="bold">NIP Kepsek Saat itu</label>
							<input type="text" name="nipkepsek" class="form-control" required>
					</div>
					<div class="d-flex justify-content-end align-items-center mb-3">
					<button id="pilih" class="btn btn-primary">Cetak</button>
				</div>	
				</form>
			  </div>
			</div>
		</div>
		<script>
		function updateSelect2() {
		let select1 = document.getElementById("select1").value;
		let select2 = document.getElementById("select2");
		select2.innerHTML = "";
		let options = [];
		if (select1 === "1") {
			options = ["", "PTS", "PAS"];
		} else if (select1 === "2") {
			options = ["", "PTS", "PAT"];
		}
		options.forEach(function(item){
			let opt = document.createElement("option");
			opt.value = item;
			opt.text = item;
			select2.appendChild(opt);
		});
	}
	
	</script>
    <script>
$("#sekarang").change(function() {
    var sekarang = $(this).val();
    console.log(sekarang);

    $.ajax({
        type: "POST",
        url: "arsip/ambildata.php?pg=siswa",
        data: { sekarang: sekarang },
        success: function(response) {
            $("#siswa").html(response);
            console.log(response);
        }
    });
});
</script>
<?php elseif($ac == enkripsi('lampu8')): ?>
<style>
.lampu {
    width: 40px;
    height: 40px;
    background: #333;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;  /* agar angka di tengah */
    font-size: 14px;           /* ukuran angka */
    color: white;              /* warna angka */
    font-weight: bold;         /* tebal */
    margin-right: 20px;
    box-shadow: 0 0 15px #000;
    transition: 0.3s;
}
.switch {
    position: relative;
    display: inline-block;
    width: 70px;
    height: 34px;
}
.switch input { display: none; }

.slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0;
    right: 0; bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;

    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 12px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px; width: 26px;
    left: 4px; bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4caf50;
}

input:checked + .slider:before {
    transform: translateX(36px);
}

#lampuContainer {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: auto;
    gap: 20px 0; 
}

.switch-container {
    width: 45%;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 8px 10px;       
    gap: 25px;             


</style>
<div class="row">
	<div class="col-md-7">
		<div class="card">
			<div class="card-body" style="height:425px">

				<div id="lampuContainer"></div>
                   <div class="mb-4"></div>
				<div style="text-align:center;">
					<button id="tombolSemua" class="btn btn-primary">Hidup Semua</button>
				</div>
			</div>
		</div>
	</div>

<script>
const lampuContainer = document.getElementById("lampuContainer");
const tombolSemua = document.getElementById("tombolSemua");
const totalLampu = 8;

const lampuList = [];
const toggleList = [];
const labelList = [];

// Buat 8 lampu + switch (UI)
for (let i = 1; i <= totalLampu; i++) {
    const container = document.createElement("div");
    container.className = "switch-container";

    const lampu = document.createElement("div");
    lampu.className = "lampu";
    lampu.id = "lampu" + i;
    lampu.textContent = i;

    const label = document.createElement("label");
    label.className = "switch";

    const input = document.createElement("input");
    input.type = "checkbox";
    input.id = "toggleLampu" + i;

    const slider = document.createElement("span");
    slider.className = "slider";
    slider.id = "labelSwitch" + i;
    slider.textContent = "OF";

    label.appendChild(input);
    label.appendChild(slider);

    container.appendChild(lampu);
    container.appendChild(label);
    lampuContainer.appendChild(container);

    lampuList.push(lampu);
    toggleList.push(input);
    labelList.push(slider);

    input.addEventListener("change", function () {
        updateLampuUI(i, this.checked);
        kirimStatusKePHP(i);
        updateTombolSemua();
    });
}

// Fungsi untuk update UI lampu & switch
function updateLampuUI(index, isOn){
    const lampu = lampuList[index-1];
    const slider = labelList[index-1];

    if(isOn){
        lampu.style.background = "yellow";
        lampu.style.boxShadow = "0 0 30px yellow";
        slider.textContent = "ON";
        toggleList[index-1].checked = true;
    } else {
        lampu.style.background = "#333";
        lampu.style.boxShadow = "0 0 15px #000";
        slider.textContent = "OF";
        toggleList[index-1].checked = false;
    }
}

// Update tombol semua
function updateTombolSemua(){
    const semuaHidup = toggleList.every(t => t.checked);
    tombolSemua.textContent = semuaHidup ? "Mati Semua" : "Hidup Semua";
}

// Tombol Hidup/Mati Semua
tombolSemua.addEventListener("click", function(){
    const hidupSemua = toggleList.some(t => !t.checked);
    toggleList.forEach((t,i)=>{
        updateLampuUI(i+1, hidupSemua);
        kirimStatusKePHP(i+1);
    });
    updateTombolSemua();
});

function kirimStatusKePHP(idLampu){
    fetch(`tlampu.php?pg=status&id=${idLampu}`)
        .then(res=>res.text())
        .then(data=>console.log("PHP:", data))
        .catch(err=>console.error(err));
}

function loadLampuAwal(){
    fetch('tlampu.php?pg=getAll')
        .then(res=>res.json())
        .then(data=>{
            data.forEach(l=>{
                const isOn = (l.status.toUpperCase() === "ON");
                updateLampuUI(l.id, isOn);
            });
            updateTombolSemua();
        })
        .catch(err=>console.error(err));
}

loadLampuAwal();

</script>

	
<div class="col-md-5">
	<div class="card">
		<div class="card-body">
		<div class="d-flex align-items-center flex-column mb-4">
		<div class="sw-13 position-relative mb-3">
			<img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
				</div>
			<div class="h5" style="color:blue">UBAH NAMA LAMPU</div>
		<div class="text-muted"><?= $setting['sekolah'] ?></div>
	<div class="text-muted">HIGH SCHOOL</div>
</div>	
<style>

.lampu-bulat {
    width: 70px;
    height: 70px;
    background: #333;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: white;
    font-weight: bold;
    box-shadow: 0 0 10px #000;
    margin: 10px auto;
}

.nav-buttons {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
}

.nav-buttons button {
    width: 48%;
}

.hidden {
    display: none;
}
</style>
<?php
$stmt = $pdo->query("SELECT id, nama FROM lampu ORDER BY id ASC");
$lampuList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="editWrapper">
<?php
foreach ($lampuList as $index => $lampu) {
    $i = $lampu['id'];
    $hiddenClass = ($i === 1) ? "" : "hidden";
    $isLast = ($i === count($lampuList));
    ?>
    <div class="edit-box <?= $hiddenClass ?>" id="lampuEdit<?= $i ?>">
        <div class="lampu-bulat"><?= $i ?></div>
        <input type="text" class="form-control" name="lampu[<?= $i ?>]" value="<?= htmlspecialchars($lampu['nama']) ?>">
        <div class="nav-buttons">
            <button type="button" onclick="prevLampu()" class="btn btn-secondary" <?= ($i === 1 ? "disabled" : "") ?>>Prev</button>
            <?php if (!$isLast) { ?>
                <button type="button" onclick="nextLampu()" class="btn btn-primary">Next</button>
            <?php } else { ?>
                <button type="submit" class="btn btn-success">Selesai</button>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>
<script>
let current = 1;
const total = <?= count($lampuList) ?>;

function showLampu(n) {
    for (let i = 1; i <= total; i++) {
        document.getElementById("lampuEdit" + i).classList.add("hidden");
    }
    document.getElementById("lampuEdit" + n).classList.remove("hidden");
}

function nextLampu() {
    if (current < total) {
        saveLampu(current); // simpan sebelum lanjut
        current++;
        showLampu(current);
    }
}

function prevLampu() {
    if (current > 1) {
        saveLampu(current); // simpan sebelum balik
        current--;
        showLampu(current);
    }
}

function saveLampu(idLampu) {
    const input = document.querySelector(`#lampuEdit${idLampu} input`);
    const nama = input.value.trim();

    fetch('tlampu.php?pg=edit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: idLampu, nama: nama })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            console.log(`Lampu ${idLampu} berhasil disimpan`);
        } else {
            console.error(`Lampu ${idLampu} gagal disimpan: ${data.error}`);
        }
    })
    .catch(err => console.error(err));
}

const btnSelesai = document.querySelector(`#lampuEdit${total} button[type="submit"]`);
btnSelesai.addEventListener('click', function(e){
    e.preventDefault();
    saveLampu(total);
     Swal.fire({
        icon: 'success',
		width:'320px',
        title: 'Berhasil!',
        text: 'Semua lampu sudah disimpan!',
        confirmButtonText: 'OK'
    });
});
</script>

			</div>
		</div>
	</div>
</div>


<?php endif; ?>
	</div>
</div>