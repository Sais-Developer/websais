<?php
defined('APK') or exit('No Access');
$soal  = countRows($db, "soal");
$jawaban = countRows($db, "arsip_jawaban");
$nilai   = countRows($db, "nilai");
?>
<?php
$dir_foto = '../foto/';
$peserta_folders = array_filter(glob($dir_foto . '*'), 'is_dir');
$limit = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$total_peserta = count($peserta_folders);
$total_pages = ceil($total_peserta / $limit);
$offset = ($page - 1) * $limit;
$peserta_page = array_slice($peserta_folders, $offset, $limit);
?>
<style>

#grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px;
    padding: 15px;
}
.peserta {
    border: 1px solid #333;
    padding: 10px;
    text-align: center;
    background: #f9f9f9;
    border-radius: 10px;
}
.peserta img {
    width: 160px;
    height: 120px;
    border: 1px solid #000;
    margin-bottom: 5px;
}
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin: 20px 0;
    gap: 5px;
}
.pagination form {
    display: inline-block;
}
.pagination button {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 8px 14px;
    margin: 3px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.3s;
}
.pagination button:hover {
    background-color: #0056b3;
}
.pagination button.active {
    background-color: #dc3545;
    font-weight: bold;
}
</style>
<div class="row">
   <div class="col-xl-8">
		<div class="card widget widget-action-list">
			<div class="card-body">
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<!--  <li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypres">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">select_all</i>
								</span>
								<span class="widget-action-list-item-title">
									Presensi
								</span>
							</a>
						</li> --> 
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mycbt">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">wifi</i>
								</span>
								<span class="widget-action-list-item-title">
									Asesmen
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykbm">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">auto_stories</i>
								</span>
								<span class="widget-action-list-item-title">
									K B M
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myrapor">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">rate_review</i>
								</span>
								<span class="widget-action-list-item-title">
									Rapor SP
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myskl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">school</i>
								</span>
								<span class="widget-action-list-item-title">
									Graduation
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="widget-action-list-container">
					<ul class="list-unstyled d-flex no-m">
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mylearn">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-primary">library_books</i>
								</span>
								<span class="widget-action-list-item-title">
									Elearn
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mykonsel">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-success">laptop</i>
								</span>
								<span class="widget-action-list-item-title">
									Konseling
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypkl">
								<span class="widget-action-list-item-icon">
									<i class="material-icons-outlined text-danger">extension</i>
								</span>
								<span class="widget-action-list-item-title">
									Prakerin
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/mypayment">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-info">money</i>
								</span>
								<span class="widget-action-list-item-title">
									Payment
								</span>
							</a>
						</li>
						<li class="widget-action-list-item">
							<a href="<?= $baseurl ?>/myaps">
								<span class="widget-action-list-item-icon">
									<i class="material-icons text-warning">apps</i>
								</span>
								<span class="widget-action-list-item-title">
									Dashboard
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	  <div class="col-xl-4">
        <div class="card widget widget-info">
			<div class="card-body">
				<div class="widget-info-container">
					<div class="widget-info-image" style="background: url('../images/<?= $setting['logo'] ?>')"></div>
					 <form id="formoptimasi">
					 <div class="col-md-12 mb-3">
						<label class="bold">Pilih Tabel</label>
						<select name="tabel" class="form-select" style="width:100%">
							<option value="soal">Soal</option>
						   <option value="jawaban">Jawaban</option>
						   <option value="nilai">Nilai</option>
						  </select>
						</div>
						<div class="col-md-12 mb-2">
                     <button type='submit' name='submit' class='btn btn-primary kanan' >Optimize</button>
                         </div>
			   </form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-primary">
						<i class="material-icons-outlined">wallet</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Data Soal</span>
						<span class="widget-stats-amount"><?= $soal ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-warning">
						<i class="material-icons-outlined">restart_alt</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Data Jawaban</span>
						<span class="widget-stats-amount"><?= $jawaban ?></span>
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4">
		<div class="card widget widget-stats">
			<div class="card-body">
				<div class="widget-stats-container d-flex">
					<div class="widget-stats-icon widget-stats-icon-success">
						<i class="material-icons-outlined">alarm</i>
					</div>
					<div class="widget-stats-content flex-fill">
						<span class="widget-stats-title">Data Nilai</span>
						<span class="widget-stats-amount"><?= $nilai ?> </span>
						
					</div>
					<div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
						<i class="material-icons">keyboard_arrow_down</i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='row'>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h5 class="card-title">MONITORING WEBCAM</h5>
         <form id="formhapus">
    <button type="submit" name="hapus" class="btn btn-sm btn-danger">
        Hapus Semua
    </button>
</form>
        <div class="checkbox" style="margin:0;">
            <input 
                type="checkbox" 
                name="webcam" 
                id="webcam"
                onchange="kirim_form();" 
                <?= ($setting['webcam'] == 1 ? 'checked' : '') ?>
            >
            <label for="webcam">
                <?= ($setting['webcam'] == 1 ? 'Webcam Aktif' : 'Tidak Aktif'); ?>
            </label>
        </div>
    </div>
            <?php if ($setting['webcam'] == 1): ?>
			
            <div id="grid">
                <?php foreach ($peserta_page as $folder): 
                    $id = basename($folder);
                    $foto = $folder . '/terbaru.jpg';
                ?>
                <div class="peserta" id="peserta_<?php echo $id; ?>">
                    <img src="<?php echo $foto; ?>?t=<?php echo time(); ?>" id="foto_<?php echo $id; ?>" />
                    <p style="font-size:11px;color:blue"><?php echo $id; ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="pagination">
                <?php if ($page > 1): ?>
                <form method="get" action="">
                    <input type="hidden" name="pg" value="<?= $pg ?>">
                    <input type="hidden" name="page" value="<?= $page - 1 ?>">
                    <button>&laquo; Sebelumnya</button>
                </form>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <form method="get" action="">
                    <input type="hidden" name="pg" value="<?= $pg ?>">
                    <input type="hidden" name="page" value="<?= $i ?>">
                    <button type="submit" class="<?= ($i == $page) ? 'active' : ''; ?>">
                        <?= $i ?>
                    </button>
                </form>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <form method="get" action="">
                    <input type="hidden" name="pg" value="<?= $pg ?>">
                    <input type="hidden" name="page" value="<?= $page + 1 ?>">
                    <button>Selanjutnya &raquo;</button>
                </form>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
	<div class="col-xl-4">
	<div class="card widget widget-list">
		<div class="card card-header">
			<h5 class="card-title">Logs Asesmen</h5>
		</div>
		<div class="card-body" id="live" style="height:670px">

		</div>
	</div>
</div>
</div>
<script>
function loadLiveContent() {
    fetch('logs.php') 
        .then(response => response.text())
        .then(data => {
            document.getElementById('live').innerHTML = data;
        })
        .catch(err => console.error('Error:', err));
}
loadLiveContent();

setInterval(loadLiveContent, 5000);
</script>

 <script>
function refreshGridFotos() {
    const pesertaImgs = document.querySelectorAll('#grid .peserta img');

    pesertaImgs.forEach(img => {
        let src = img.src.split('?')[0];
        img.src = src + '?t=' + new Date().getTime();
    });
}
refreshGridFotos();
setInterval(refreshGridFotos, 5000);

</script>
<script>
function kirim_form() {
    var webcamAktif = $('#webcam').is(':checked') ? 1 : 0;

    $.ajax({
        type: 'POST',
        url: 'tweb.php',
        data: { webcam: webcamAktif },
        success: function(response) {
            location.reload();
        },
        error: function() {
            alert('Gagal mengirim data ke server.');
        }
    });
}
</script>
<script>
$('#formoptimasi').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
             url: 'optimasi.php',
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
$('#formhapus').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
             url: 'hapussemua.php',
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
