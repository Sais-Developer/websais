<?php
defined('APK') or exit('No Access');
?>     
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"> PESERTA PRAKERIN </h5>
            </div>
            <div class="card-body">									
                <div class="card-box table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                                <th width="5%">NO</th>                                               
                                <th>NAMA SISWA</th>
                                <th>NAMA DUDI</th>
								<th>ALAMAT DUDI</th>
                                <th>GURU<br>PEMBIMBING</th>	
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							$sql = "
								SELECT p.*, s.nama AS nama_siswa, s.kelas,
									   g.nama AS nama_guru, d.nama_dudi, d.alamat
								FROM pkl_siswa p
								LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
								LEFT JOIN pkl_dudi d ON d.id = p.dudi
								LEFT JOIN guru g ON g.id_guru = p.idguru
							";

							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$no = 0;

							while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
								$no++;
							?>
							<tr>
								<td><?= $no; ?></td>
								<td><?= htmlspecialchars($data['nama_siswa']); ?></td>
								<td><?= htmlspecialchars($data['nama_dudi']); ?></td>
								<td><?= htmlspecialchars($data['alamat']); ?></td>
								<td><?= htmlspecialchars($data['nama_guru']); ?></td>
								<td>
									<button data-id="<?= $data['id']; ?>" class="hapus btn btn-sm btn-danger" 
											data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
										<i class="material-icons">delete</i> 
									</button>
								</td>
							</tr>
							<?php
							endwhile;
							$stmt = null;
							?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>
	<script>
	$('#datatable1').on('click', '.hapus', function() {
	var id = $(this).data('id');
		console.log(id);
		Swal.fire({
		title: 'Hapus Data',
		text: "Hapus Data Peserta",
		icon: 'warning',
		width:'320px',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Hapus!',
		cancelButtonText: "Batal"				  
	}).then((result) => {
		if (result.value) {
		$.ajax({
		url: 'pkl/tpkl.php?pg=hapus',
		method: "POST",
		data: 'id=' + id,
		success: function(data) {
		$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
		setTimeout(function() {
		 window.location.reload(true);
		}, 200);
			}
		});
		}
		return false;
		})

		});

	</script>
