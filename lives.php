 <?php
 require("konek/koneksi.php"); 
 ?>
 <html lang="id" translate="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="id">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sandik All in One">
    <meta name="keywords" content="Sandik All in One">
    <meta name="author" content="sandik">   
    <title><?= $setting['sekolah'] ?></title>
    <link href="<?= $baseurl ?>/font/material.css" rel="stylesheet">
     <link href="<?= $baseurl ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
	
	<link rel="stylesheet" href="<?= $baseurl ?>/assets/css/sweetalert2.min.css"> 
	<link href="<?= $baseurl ?>/assets/css/main.css" rel="stylesheet">
    <link href="<?= $baseurl ?>/assets/css/custom.css" rel="stylesheet"> 
    <link id="darkTheme" href="<?= $baseurl ?>/assets/css/darktheme.css" rel="stylesheet" disabled>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" />
    <script src="face/jquery.min.js"></script>
   <script src="face/bootstrap.min.js"></script>
   <script src="face/face-api.js"></script>
   <script src="<?= $baseurl ?>/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
   
<style>
.edis2 {
  background-size: 180px;
  background-image: url('images/tutwuri2.png');
  background-repeat: no-repeat;
  background-position: top right; 
}
</style>
</head>
<body style="background-color:#f2f4f4">

<link href="assets/css/horizontal-menu/horizontal-menu.css" rel="stylesheet">
    <div class="app horizontal-menu align-content-stretch d-flex flex-wrap">

        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
						 <ul class="navbar-nav">
                                <li class="nav-item active">
                                  <a class="nav-link" href="#" style="color:#fff;">LIVE PRESENSI</a>
                                </li> 
                            </ul>
                        </div>
						<div class="d-flex" id='progressbox'></div>
                        <div class="d-flex align-items-center gap-3">
							<style>
							.dropdown-item i.material-icons {
							font-size: 18px;
							margin-right: 8px;
							transform: translateY(2px);
							}
						</style>
				<span id="toggleSandik" class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					light
				</span>
				<span id="toggleTheme"
					  class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					dark_mode
				</span>             
				
		      <span id="toggleFullscreen"
					  class="material-icons me-2"
					  style="cursor:pointer; font-size:26px;">
					fullscreen
				</span>
                
				</div>
			</div>
		</nav>
	</div>
	<div class="app-content">
		<div class="content-wrapper" style="margin-top:-50px;padding:10px">
				<div class="row">
				   <div class="col-md-12">
				   <div class="card-header mb-2">
					  <marquee style="font-size:20px;color:red;">
					  Selamat datang di halaman Live Presensi <?= $setting['sekolah'] ?> menggunakan sistem Presensi Digital dan auto Notifikasi
					  </marquee>
				       </div>
					</div>
				  </div>
		<div class="row">
			<div class="col-md-4">
			<div id="data"></div>
		 </div>
	 <div class="col-md-8">
	<div class="card-body">
	   <div class="row">
          <div id="parent1" style="float:left; position:relative; width:100%; height:auto;" class="mb-4">
				<video id="vidDisplay" style="width:100%; height:100%; display:inline-block;" onloadedmetadata="onPlay(this)" autoplay></video>
				<canvas id="overlay" style="position:absolute; top:0; left:0; width:100%; height:100%;"></canvas>
			</div>
			<div class="col-xl-12 mb-4">
				<div id="parent2"> 
					<button id="login" class="button button1" hidden></button>
						<img id="prof_img" style="height:200px;width:200px;border:1px solid blue;border-radius:10px;" hidden>
				</div>
                    <div id="log_disp mb-4">
                                <div id="logname" name="logname" style="font-size:15px;text-align:center;" hidden></div>
                                <input id="idface" name="idface" type="hidden">
                            </div>
                            <div id="kartu" hidden></div>                         
                        </div>
                    </div>
	            </div>
	       </div>
		   
	   </div>
	 </div>
		</div>
	</div>
</div>
</div>
<script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/pace/pace.min.js"></script>
<script src="<?= $baseurl ?>/assets/plugins/highlight/highlight.pack.js"></script>
<script src="<?= $baseurl ?>/assets/js/sweetalert2.min.js"></script>
<script src="<?= $baseurl ?>/assets/js/main.min.js"></script>
<script src="<?= $baseurl ?>/assets/js/custom.js"></script>
<script src="<?= $baseurl ?>/assets/js/pages/datatables.js"></script>
<script src="<?= $baseurl ?>/assets/js/pages/dashboard.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	setInterval(function(){
		$("#kartu").load('wajah/nokartu.php');
		$("#data").load('wajah/log_data.php');
	}, 1000);  
});
</script>
<script>
  var waitingDialog = waitingDialog || (function ($) {
    var $dialog = $(
      );
  return {
    show: function (message, options) {
      if (typeof options === 'undefined') {
        options = {};
      }
      if (typeof message === 'undefined') {
        message = 'Loading';
      }
      var settings = $.extend({
        dialogSize: 'm',
        progressType: '',
        onHide: null 
      }, options);
      $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
      $dialog.find('.progress-bar').attr('class', 'progress-bar');
      if (settings.progressType) {
        $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
      }
      $dialog.find('h3').text(message);
      if (typeof settings.onHide === 'function') {
        $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
          settings.onHide.call($dialog);
        });
      }
      $dialog.modal();
    },
    hide: function () {
      $dialog.modal('hide');
    }
  };

})(jQuery);
</script>


<script>
  var faceMatcher = undefined
  
  $("#parent1").hide();
  $("#parent2").hide();
  Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri('models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri('models'),
    faceapi.nets.tinyFaceDetector.loadFromUri('models')
  ]).then(start)

  async function start() {
    $.ajax({
        datatype: 'json',
        url: "fetch.php",
        data: ""
    }).done(async function(data) {
        if(data.length > 2){
          var json_str = "{\"parent\":" + data  + "}"
          content = JSON.parse(json_str)
          for (var x = 0; x < Object.keys(content.parent).length; x++) {
            for (var y = 0; y < Object.keys(content.parent[x]._descriptors).length; y++) {
              var results = Object.values(content.parent[x]._descriptors[y])
              content.parent[x]._descriptors[y] = new Float32Array(results)
            }
          }
          faceMatcher = await createFaceMatcher(content);
        }
        waitingDialog.hide()
        $('#parent1').show()
        $('#parent2').show()        
        run();
    });
  }

  async function createFaceMatcher(data) {
    const labeledFaceDescriptors = await Promise.all(data.parent.map(className => {
      const descriptors = [];
      for (var i = 0; i < className._descriptors.length; i++) {
        descriptors.push(className._descriptors[i]);
      }
      return new faceapi.LabeledFaceDescriptors(className._label, descriptors);
    }))
    return new faceapi.FaceMatcher(labeledFaceDescriptors,0.6);
  }

let shownMatches = {};
let lastDetectionTime = 0;
const detectionInterval = 1000; 

async function onPlay() {
    const videoEl = $('#vidDisplay').get(0);
    if(videoEl.paused || videoEl.ended) return setTimeout(() => onPlay());

    const now = Date.now();
    if(now - lastDetectionTime >= detectionInterval) {
        lastDetectionTime = now;

        $("#overlay").show();
        const canvas = $('#overlay').get(0);

        if($("#login").hasClass('active') && faceMatcher) {
            const input = document.getElementById('vidDisplay');
            const displaySize = { width: 480, height: 320 };
            faceapi.matchDimensions(canvas, displaySize);

            const detections = await faceapi.detectAllFaces(input).withFaceLandmarks().withFaceDescriptors();
            const resizedDetections = faceapi.resizeResults(detections, displaySize);
            const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

            results.forEach((result, i) => {
                const box = resizedDetections[i].detection.box;
                const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() });
                drawBox.draw(canvas);

                var str = result.toString();
                var nokartu = $("#lname").val();
                let rating = parseFloat(str.substring(str.indexOf('(') + 1, str.indexOf(')')));
                str = str.substring(0, str.indexOf('('));
                str = str.substring(0, str.length - 1);

                if(str != "unknown" && rating < 0.5 && nokartu != "") {
                    if(!shownMatches[str]) {
                        shownMatches[str] = true;
                        $("#logname").html(str);
                        $("#prof_img").attr('src',"data/" + str + "/image0.png");
                        $('#idface').val(str);

                        var idface = $("#idface").val();
                       $.ajax({
							  type: "POST",
							  url: "ajaxface.php",
							  data: {idface : idface, nokartu : nokartu}
						  }).done(async function(data) {
							 if (data == 'OK') {		
								Swal.fire({
									icon: 'success',
									title: 'SUKSES!',
									text: 'FACE SESUAI',
									background: '#0000FF', 
									color: '#FFFF00', 
									confirmButtonColor: '#FFFF00', 
									position: 'top-right',
									showConfirmButton: false,
									timer: 500
								});
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Gagal!',
									text: 'ID FACE TIDAK SESUAI',
									background: '#8b0000',
									color: '#FFFF00', 
									confirmButtonColor: '#FFFF00',
									position: 'top-right',
									showConfirmButton: false,
									timer: 500
									
								});
							}
                        });
                        setTimeout(() => { delete shownMatches[str]; }, 3000);
                    }
                }
            });
        }
    }

    setTimeout(() => onPlay());
}

    
  async function run() {
      const stream = await navigator.mediaDevices.getUserMedia({ video: {} })
      const videoEl = $('#vidDisplay').get(0)
      videoEl.srcObject = stream
  }
  let inputSize = 160
  let scoreThreshold = 0.4

  function getFaceDetectorOptions() {
    return  new faceapi.TinyFaceDetectorOptions({ inputSize, scoreThreshold });
  }

  async function load_neural(){
    waitingDialog.show('Initializing neural data....', {dialogSize: 'sm', progressType: 'success'})
    $.ajax({
        datatype: 'json',
        url: "fetch.php",
        data: ""
    }).done(async function(data) {
        if(data.length > 2){
          var json_str = "{\"parent\":" + data  + "}"
          content = JSON.parse(json_str)
          console.log(content)
          for (var x = 0; x < Object.keys(content.parent).length; x++) {
            for (var y = 0; y < Object.keys(content.parent[x]._descriptors).length; y++) {
              var results = Object.values(content.parent[x]._descriptors[y]);
              content.parent[x]._descriptors[y] = new Float32Array(results);
            }
          }
          faceMatcher = await createFaceMatcher(content);
        }
        waitingDialog.hide()
    });
  }

</script>

<script>
  
  $(document).ready(async function(){

    var counter = 2;
    const descriptions = [];
    $("#login").css('background-color','yellow');
    $("#login").addClass('active');
    $("#register").css('background-color','white');
    $("#register").removeClass('active');

    if($("#register").hasClass('active')){
        $("#reg_disp").show();
        $("#log_disp").hide();
    }
    else if($("#login").hasClass('active')){
        $("#reg_disp").hide();
        $("#log_disp").show();
    }
    

   

});
</script>
<script type="text/javascript">    
    <?php echo $jsArray; ?>  
    function changeValue(x){  
    document.getElementById('fname').value = prdName[x].fname;   
    };  
    </script> 



</body>
</html>