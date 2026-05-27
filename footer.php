<script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/pace/pace.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/highlight/highlight.pack.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/datatables/datatables.min.js"></script>
<script src="<?= $baseurl ?>/assets/js/sweetalert2.min.js"></script>
<script src='<?= $baseurl ?>/assets/zoom-master/jquery.zoom.js'></script>
<script src='<?= $baseurl ?>/assets/toastr/toastr.min.js'></script>	 
<script src='<?= $baseurl ?>/assets/mousetrap/mousetrap.min.js'></script>
<script src="<?= $baseurl ?>/assets/js/main.min.js"></script>
<script src="<?= $baseurl ?>/assets/js/custom.js"></script>
<script src="<?= $baseurl ?>/assets/js/pages/datatables.js"></script>
<script src="<?= $baseurl ?>/assets/js/pages/dashboard.js"></script>
 <script>
    var baseurl = '<?= $baseurl ?>';
$(window).keydown(function(event) {
    if (event.keyCode == 91) { // Windows key
        console.log("Win Key was clicked");
    }
});

$('body').on('contextmenu', function(e) { return false; });

$(document).on('selectstart dragstart', function(e) {
    e.preventDefault();
    return false;
});

$(document).keydown(function(e) {
    if (e.keyCode == 27) return false;
});

function selesai() {
    $.ajax({
        type: 'POST',
        url: 'selesai.php',
        data: {
            id_bank: '<?= $id_bank ?>',
            id_siswa: '<?= $id_siswa ?>'
        },
        dataType: 'json',
        success: function(response) {
            console.log("AJAX berhasil:", response);
            setTimeout(function() {
                window.location.href = '<?= $baseurl ?>'; 
            }, 300);
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error);
            console.log("Response text:", xhr.responseText);
            setTimeout(function() {
                window.location.href = '<?= $baseurl ?>'; 
            }, 300);
        }
    });
}


var elem = document.documentElement;

function openFullscreen() {
    if (elem.requestFullscreen) elem.requestFullscreen();
    else if (elem.mozRequestFullScreen) elem.mozRequestFullScreen();
    else if (elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
    else if (elem.msRequestFullscreen) elem.msRequestFullscreen();
}

Swal.fire({
    title: 'Info Ujian',
	icon:'warning',
	width:'320px',
    html: 'Selamat Mengerjakan',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Iya',
    allowOutsideClick: false
}).then((result) => {
    if (result.isConfirmed) openFullscreen();
});

document.addEventListener('fullscreenchange', exitHandler);
document.addEventListener('mozfullscreenchange', exitHandler);
document.addEventListener('webkitfullscreenchange', exitHandler);
document.addEventListener('MSFullscreenChange', exitHandler);

function exitHandler() {
    let fs =
        document.fullscreenElement ||
        document.mozFullScreenElement ||
        document.webkitFullscreenElement ||
        document.msFullscreenElement;

    if (fs) return; 

    <?php if($mapel['pelanggaran'] <> 0) { ?>

    var countdown = <?= $mapel['pelanggaran'] ?>;
    var msg = "Ujian terpaksa selesai dalam #1 detik lagi";

    Swal.fire({
        title: "Pelanggaran!",
		icon:'warning',
		width:'320px',
        text: msg.replace("#1", countdown),
        allowOutsideClick: false,
        confirmButtonText: 'Lanjut Ujian',
        timer: countdown * 1000,
        didOpen: () => {
            const htmlContainer = Swal.getHtmlContainer(); // FIX

        const interval = setInterval(() => {
            countdown--;

            if (htmlContainer) {
                htmlContainer.innerHTML = msg.replace("#1", countdown);
            }

            if (countdown <= 0) {
                clearInterval(interval);
                selesai();  
            }
        }, 1000);
    }
}).then((result) => {
    if (result.isConfirmed) openFullscreen();
});

    <?php } else { ?>
    Swal.fire({
        title: 'Ujian',
		icon:'warning',
		width:'320px',
        html: 'Silakan kembali ke fullscreen',
        confirmButtonText: 'Iya',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) openFullscreen();
    });

    <?php } ?>
}

window.history.pushState(null, "", window.location.href);
window.onpopstate = function() {
    window.history.pushState(null, "", window.location.href);
};

	var baseurl;
	baseurl = '<?= $baseurl ?>';
	$(document).ready(function() {
		$("#modalnosoal").on('shown.bs.modal', function() {
			var idmapel = '<?= $id_bank  ?>';
			var idsiswa = '<?= $id_siswa  ?>';                    
			$.ajax({
				type: 'POST',
				url: baseurl + '/nosoal.php',
				data: {
					id_bank: idmapel,
					id_siswa: idsiswa,
					idu: <?= $ac ?>
				},
				success: function(response) {
					
					$('#loadnosoal').html(response);

				}
			});
		});
	});


function soalpertama() {
	var idmapel = '<?= $id_bank  ?>';
	var idsiswa = '<?= $id_siswa  ?>';
   
	$.ajax({
		type: 'POST',
		url: baseurl + '/soal.php',
		data: {
			pg: 'soal',
			id_bank: idmapel,
			id_siswa: idsiswa,
			no_soal: 0,
			idu: <?= $ac ?>
		},
		success: function(response) {
			num = 1;
			$('#displaynum').html(num);
			$('#loadsoal').html(response);
			$('.fa-spin').hide();
			
			soalFont(fontSize);
			
		}
	});
}
soalpertama();
/* Font Adjusments */
let defaultFontSize = 10;
let fontSize = 0;
fontSize = localStorage.getItem('fontSize');
if (!fontSize) {
	fontSize = defaultFontSize;
	localStorage.setItem('fontSize', fontSize);
}
soalFont(fontSize);

function soalFont(fontSize) {
	$('div.soal > p > span').css({
		fontSize: fontSize + 'pt'
	});
	$('span.soal > p > span').css({
		fontSize: fontSize + 'pt'
	});
	$('.soal').css({
		fontSize: fontSize + 'pt'
	})
	$('.callout soal').css({
		fontSize: fontSize + 'pt'
	})
}

$(document).ready(function() {
	$('#smaller_font').on('click', function() {
		fontSize = localStorage.getItem('fontSize')
		fontSize--;
		localStorage.setItem('fontSize', fontSize)
		soalFont(fontSize)
	});

	$('#bigger_font').on('click', function() {
		fontSize = localStorage.getItem('fontSize')
		fontSize++;
		localStorage.setItem('fontSize', fontSize)
		soalFont(fontSize)
	});

	$('#reset_font').on('click', function() {
		fontSize = defaultFontSize
		localStorage.setItem('fontSize', fontSize)
		soalFont(fontSize)
	});
	
	$(document).on('click', '.done-btn', function() {
		var idmapel = '<?= $id_bank  ?>';
		var idsiswa = '<?= $id_siswa  ?>';
		$.ajax({
			type: 'POST',
			url: baseurl + '/cekselesai.php',
			data: {
				id_bank: idmapel,
				id_siswa: idsiswa,
				id_ujian: <?= $ac ?>
			},
			success: function(response) {
				if (response == 'ok') {
					Swal.fire({
						title: 'Apa kamu yakin telah selesai?',
						html: 'Pastikan telah menyelesaikan semua dengan benar!',
						icon: 'warning',
						width:'320px',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Iya'
					}).then((result) => {
						if (result.value) {
							
						   selesai();
						}
					})
				} else if (response == 'ragu') {
					Swal.fire({
						type: 'warning',
						width:'320px',
						title: 'Peringatan',
						html: 'Masih ada soal yang masih ragu!!',
					})
				} else {
					Swal.fire({
						icon: 'warning',
						width:'320px',
						title: 'Peringatan',
						html: 'Masih ada soal yang belum dikerjakan!!',
					})
				}

			}
		});

	});
	
               

	var jam = $('#htmljam').html();
	var menit = $('#htmlmnt').html();
	var detik = $('#htmldtk').html();

	function hitung() {
		setTimeout(hitung, 1000);
		$('#countdown').html(jam + ':' + menit + ':' + detik);
		detik--;
		if (detik < 0) {
			detik = 59;
			menit--;
			if (menit < 0) {
				menit = 59;
				jam--;
				if (jam < 0) {
					jam = 0;
					menit = 0;
					detik = 0;
					selesai();
				}
			}
		}
	}
	hitung();

});

function waktuhabis() {
	Swal.fire({
		title: 'Peringatan!',
		text: 'Waktu Ujian Telah Habis',
		timer: 1000,
		onOpen: () => {
			swal.showLoading()
		}
	}).then((result) => {
		selesai();
	});
}

function loadsoal(idmapel, idsiswa, nosoal) {

	if (nosoal >= 0 && nosoal<<?= $jumsoal ?>) {
		curnum = $('#displaynum').html();
		if (nosoal == curnum) {
			$('#spin-next').show();
		}
		if (nosoal > curnum) {
			$('#spin-next').show();
		}
		if (nosoal < curnum) {
			$('#spin-prev').show();
		}
		
		$.ajax({
			type: 'POST',
			url: baseurl + '/soal.php',
			data: {
				pg: 'soal',
				id_bank: idmapel,
				id_siswa: idsiswa,
				no_soal: nosoal
			},
			success: function(response) {
				num = nosoal + 1;
				$('#displaynum').html(num);
				$('#loadsoal').html(response);
				$('.fa-spin').hide();
				$("#modalnosoal").modal('hide');
				soalFont(fontSize);
				
			}
		});
	}
}

function jawabsoal(idmapel, idsiswa, idsoal, jawab, jenis) {                
	$.ajax({
		type: 'POST',
		url: baseurl + '/soal.php',
		data: {
			pg: 'jawab',
			id_bank: idmapel,
			id_siswa: idsiswa,
			id_soal: idsoal,
			jawaban: jawab,
			jenis: jenis
		   
		},
		success: function(response) {
		  
			if (response == 'OK') {
				$('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
				$('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
				$('#nomorsoal #badge' + idsoal).addClass('bg-green');
				$('#nomorsoal #jawabtemp' + idsoal).html(jawabQ);
				$('#ketjawab').load(window.location.href + ' #ketjawab');
			}
		}
	});
}
     
	function jawabmulti(idmapel, idsiswa, idsoal, jawab, jenis) {
    var jawaban = [];

    $('input[name="jawab[]"]:checked').each(function() {
        jawaban.push($(this).val());  
    });

    console.log("Jawaban yang dikirim:", jawaban);  
    $.ajax({
        type: 'POST',
        url: baseurl + '/soal.php',  
        data: {
            pg: 'multi',  
            id_bank: idmapel,
            id_siswa: idsiswa,
            id_soal: idsoal,
            jawaban: jawaban,  
            jenis: jenis
        },
        success: function(response) {
            console.log("Response dari server:", response);  

            if (response.status === 'success') {
                $('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
                $('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
                $('#nomorsoal #badge' + idsoal).addClass('bg-green');
                $('#nomorsoal #jawabtemp' + idsoal).html(jawaban.join(','));  // Tampilkan jawaban yang dipilih
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

   function jawabbs(id_bank, id_siswa, id_soal, jenis, no_soal) {
    var jawaban = [];
    for (let i = 0; i < 5; i++) {
        let val = $(`input[name="jawab[${no_soal}][${i}]"]:checked`).val();
        if (val) {
            jawaban.push(val); // hanya push jika user memilih
        }
    }

    var hasil = jawaban.join(',');

    console.log("Kirim jawaban:", hasil);

    $.ajax({
        type: 'POST',
        url: baseurl + '/soal.php',
        data: {
            pg: 'bs',
            id_bank: id_bank,
            id_siswa: id_siswa,
            id_soal: id_soal,
            jawaban: hasil, // hanya kirim yang terisi
            jenis: jenis
        },
        success: function(response) {
            console.log('Respon server:', response);
        },
        error: function(xhr, status, error) {
            console.error("Gagal simpan:", error);
        }
    });
}

   function simpanJawabanJodoh(idmapel, idsiswa, idsoal, jenis, jawabanString, warnaString) {
			$.ajax({
			type: 'POST',
			url: baseurl + '/soal.php',
			data: {
			pg: 'jodoh',
			id_bank: idmapel,
		    id_siswa: idsiswa,
			id_soal: idsoal,
			jawaban: jawabanString, 
			warna: warnaString,     
			jenis: jenis
		},
		
		success: function(response) {
            console.log('Respon server:', response);
        },
        error: function(xhr, status, error) {
            console.error("Gagal simpan:", error);
        }
    });
}

function jawabesai(idmapel, idsiswa, idsoal, jenis) {
	var jawab = $('#jawabesai').val();
	$.ajax({
		type: 'POST',
		url: baseurl + '/soal.php',
		data: {
			pg: 'esai',
			id_bank: idmapel,
			id_siswa: idsiswa,
			id_soal: idsoal,
			jawaban: jawab,
			jenis: jenis,
			idu: <?= $ac ?>
		},
		success: function(response) {
			if (response == 'OK') {
				toastr.success("jawaban berhasil disimpan");
				$('#badge' + idsoal).removeClass('bg-gray');
				$('#badge' + idsoal).removeClass('bg-yellow');
				$('#badge' + idsoal).addClass('bg-green');
				$('#ketjawab').load(window.location.href + ' #ketjawab');
			}

		}
	});
}

	function radaragu(idmapel, idsiswa, idsoal) {
		cekclass = $('#nomorsoal #badge' + idsoal).attr('class');
		if (cekclass != 'btn btn-app bg-gray') {
			$.ajax({
				type: 'POST',
				url: baseurl + '/soal.php',
				data: {
					pg: 'ragu',
					id_bank: idmapel,
					id_siswa: idsiswa,
					id_soal: idsoal
				},
				success: function(response) {
					console.log(response);
					if (response == 'OK') {
						if (cekclass == 'btn btn-app bg-green') {
							$('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
							$('#nomorsoal #badge' + idsoal).removeClass('bg-green');
							$('#nomorsoal #badge' + idsoal).addClass('bg-yellow');
							console.log('kuning');
						}
						if (cekclass == 'btn btn-app bg-yellow') {
							$('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
							$('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
							$('#nomorsoal #badge' + idsoal).addClass('bg-green');
							console.log('hijau');
						}
					}
				}
			});
		} else {
			$('#load-ragu input').removeAttr('checked');
		}
	}
</script>

</body>
</html>