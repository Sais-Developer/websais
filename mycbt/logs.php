<ul class="widget-list-content list-unstyled">
			<?php
			require("../konek/koneksi.php");
			$yesterday = date('Y-m-d', strtotime('-1 day'));
			$delStmt = $pdo->prepare("DELETE FROM log_ujian WHERE DATE(waktu) = :yesterday");
			$delStmt->execute(['yesterday' => $yesterday]);

			$sql = "
				SELECT l.*, s.nama, s.jk, s.foto,
				b.id_bank, 
				m.kode as kode_mapel
				FROM log_ujian l
				JOIN siswa s ON s.id_siswa = l.id_siswa
				LEFT JOIN banksoal b ON b.id_bank = l.id_bank
				LEFT JOIN mapel m ON m.id = b.idmapel
				ORDER BY l.id DESC
				LIMIT 9
			";
			$stmt = $pdo->query($sql);
			$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($logs) > 0):
				foreach ($logs as $log):
				if(!empty($log['foto'])) {
                $foto = "../images/fotosiswa/" . htmlspecialchars($log['foto']);
				}else{
					if($log['jk']=='L'){
						$foto = "../images/siswa.png";
					}else{
						$foto = "../images/wanita.png";
					}
				}
			?>
		<li class="widget-list-item widget-list-item-purple">
			<span class="widget-list-item-avatar">
				<div class="avatar avatar-rounded">
					<img src="<?= $foto ?>" >
				</div>
			</span>
			<span class="widget-list-item-description">
				<a href="#" class="widget-list-item-description-title">
					<?= ucwords(strtolower($log['nama'])) ?>
				</a>
				<span class="badge badge-light badge-style-light">
				<?= htmlspecialchars($log['aktivitas']) ?>
				<?= htmlspecialchars($log['kode_mapel']) ?>
				
				</span>
				<span class="badge badge-success badge-style-light">
			    <?= date('H:i:s', strtotime($log['waktu'])) ?>
			     </span>
			</span>

		</li>
		<?php
		endforeach;
		else:
		echo' <li class="widget-list-item widget-list-item-purple">
			<span class="widget-list-item-avatar">
				<div class="avatar avatar-rounded">
					<img src="../images/animasi.gif" alt="">
				</div>
			</span>
			<span class="widget-list-item-description">
				<a href="#" class="widget-list-item-description-title text-muted">
					Tidak ada aktifitas
				</a>
		</li>';
		endif;
		?>
	</ul>