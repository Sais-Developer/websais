<?php
defined('APK') or exit('No accsess');
?>           
<div class="row">
  <div class="col-md-8">
   <div class="card">
    <div class="card-header" >
         <h5 class="card-title">MATA PELAJARAN</h5>
	   </div>
     <div class="card-body">
		<div class="card-box table-responsive">
			<table id="datatable1" class="table table-bordered">
			  <thead>
				<tr>
					<th>NO</th>
					<th>KODE</th>
					<th>NAMA MAPEL</th>					
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
					$no = 1;
					$stmt = $db->prepare("SELECT id, kode, nama_mapel FROM mapel");
					$stmt->execute();
					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach ($rows as $row) : ?>
					<tr>
					<td><?= $no++ ?></td>
					<td><?= htmlspecialchars($row['kode']) ?></td>
					<td><?= htmlspecialchars($row['nama_mapel']) ?></td>
					<td>
						<button 
							class="hapus btn btn-sm btn-danger"
							data-id="<?= $row['id'] ?>"
							data-bs-toggle="tooltip"
							title="Hapus">
							<i class="material-icons">delete</i>
						</button>
					</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	   </div>
	</div>
 </div>	
</div>
<script>
$('#datatable1').on('click', '.hapus', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data akan dihapus",
    icon: 'warning',
    width: '320px',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    customClass: {
      popup: 'swal-mini',
      confirmButton: 'swal-btn-mini',
      cancelButton: 'swal-btn-mini'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: 'master/tmapel.php',
        method: "POST",
        data: { id: id },
        success: function() {
          Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus.',
            timer: 1200,
            showConfirmButton: false,
            width: '280px',
            customClass: { popup: 'swal-mini' }
          });
          setTimeout(() => window.location.reload(), 1200);
        }
      });
    }
  });
});
</script>		
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
    <div class="widget-payment-request-info m-t-md"> 						      
	<form id='formmapel'>	
		<label class="bold">Pilih File</label>
			<a href="master/M_MAPEL.xlsx" class="btn btn-sm btn-link float-end mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Format">  
			<i class="material-icons">download</i> Format</a>	   				            
		<div class="input-group mb-3">
		  <input type='file' name='file' class='form-control' required accept=".xlsx">
			<span class="input-group-text">
				<button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">upload</i></button>
				</span>
			</div>	
		</form>
	</div>                  
	<div class="mb-2">
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
	  <div class="mb-2">
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
	  <div class="mb-0">
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
<script>
    $('#formmapel').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
            url: 'master/import_mapel.php',
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

	<script src="../assets/js/chart.js"></script>
<script>
  const ctx = document.getElementById('chartjs1').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun'],
      datasets: [{
        label: 'Pendapatan',
        data: [1200, 1500, 1700, 1800, 2000, 2400],
        borderColor: '#007bff',
        backgroundColor: 'rgba(0,123,255,0.1)',
        tension: 0.3,
        fill: true,
        pointRadius: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        x: { display: false },
        y: { display: false }
      }
    }
  });
</script>
