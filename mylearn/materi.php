<?php defined('APK') or exit('No Access'); ?>

    <div class='row'>
        <div class='col-md-8'>
		 <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0">MATERI BELAJAR</h5>
					<a href="?pg=<?= enkripsi('inputmateri') ?>" class="btn btn-link">
						<i class="material-icons">add</i>Materi
					</a>
				</div>
				 <div class="card-body">	
                    <div id='tablemateri' class='table-responsive'>
                        <table id="datatable1" class="table table-bordered table-hover edis2" style="width:100%;font-size:12px">
                                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>MAPEL</th>                                 
                                    <th>BERAKHIR</th>
                                    <th>KELAS</th>
                                    <th>FILE</th>
									<th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
								$no = 0;
								$query = "SELECT * FROM materi m 
										  LEFT JOIN guru g ON g.id_guru = m.guru
										  LEFT JOIN mapel p ON p.id = m.mapel";

								$stmt = $pdo->prepare($query);
								$stmt->execute();
								$materiList = $stmt->fetchAll(PDO::FETCH_ASSOC);

								foreach ($materiList as $materi) :
									$no++;
								?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $materi['kode'] ?></td>
										<td><?= $materi['sampai'] ?></td>
                                        <td>
                                            <?php $kelas = unserialize($materi['kelas']);
                                            foreach ($kelas as $kelas) {
                                                echo $kelas . " ";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($materi['file'] <> null) { ?>
                                                <a href="../materi/<?= $materi['file'] ?>" target="_blank">Lihat</a>
                                            <?php } ?>
                                        </td>										
                                        <td style="text-align:center">         
                                            <a href='?pg=<?= enkripsi('inputmateri') ?>&ac=<?= enkripsi('edit') ?>&id=<?= $materi['idm'] ?>' class='btn btn-sm btn-primary'  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Materi"><i class='material-icons'>edit</i></a>
                                            <button data-id='<?= $materi['idm'] ?>' class="hapus btn btn-danger btn-sm"  data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="material-icons">delete</i></button>                                           
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
        console.log(id);
        Swal.fire({
            title: 'Hapus Materi',
            text: "Menghapus materi ini",
            icon:'warning',
			width:'320px',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'hapus.php',
                    method: "POST",
                    data: 'id=' + id,
					 beforeSend: function() {
					$('#progressbox').html('<div><img src="../images/animasi.gif" style="width:50px;"></div>');
                   },
                    success: function(data) {                      
                        setTimeout(function() {
                            window.location.reload();
                        }, 200);
                    }
                });
            }
            return false;
        })

    });
	 
</script>
	
 <div class="col-md-4 mb-4">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive-img" alt="thumb" />
                    </div>
                <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
                      <div class="text-muted">HIGH SCHOOL</div>
                  </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">NPSN</p>
                      <p><?= $setting['npsn'] ?></p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">SMT</p>
                      <p><?= $setting['semester'] ?></p>
                    </div>
                    <div class="text-center">
                      <p class="text-small text-muted mb-1">TP</p>
                      <p><?= $setting['tp'] ?></p>
                    </div>                    
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
