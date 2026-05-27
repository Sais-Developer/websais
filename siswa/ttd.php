<script type="text/javascript" src="<?= $baseurl ?>/assets/js/signature.js"></script>
<?php
defined('APK') or exit('No Access');
$ids = $_GET['ids'];
?>    
  <style>
img.responsive {max-width: 40%;height: auto;border-radius: 6px;display: block;margin: 10px auto;}
@media (max-width: 768px) {img.responsive {width: 70%;max-height: 300px;object-fit: cover;}}
@media (max-width: 480px) {img.responsive {max-height: 220px;border-radius: 4px;}}

</style>
  <div class="row">
	<div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="card">
		<div class="card-body">
			<div class="d-flex align-items-center flex-column mb-4">
                 <div class="sw-13 position-relative mb-3">
                    <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" class="responsive" alt="thumb" />
                 </div>
			<div class="h5" style="color:blue;">UPLOAD TTD INSTRUKTUR</div>
               <div class="h5 mb-0"><?= $setting['sekolah'] ?></div>
                  </div>
              <form id="formguru">	
                  <input type="hidden" name="ids" value="<?= $ids; ?>" >
				  <div class="col-md-12 mb-2">
			         <label class="form-label bold">NAMA INSTRUKTUR</label>
				<input type="text" name='guru'  class='form-control' required="true" >
				 </div>	
				  <div class="col-md-12 mb-2">
			         <label class="form-label bold">CATATAN INSTRUKTUR</label>
				<textarea name='catat' rows="4" class='form-control' required="true" ></textarea>
				 </div>	
				<div id="signature-pad">
					<div style="border:solid 1px teal; width:auto;height:110px;padding:3px;position:relative;">
						<div id="note" onmouseover="my_function();">The signature should be inside box</div>
						<canvas id="the_canvas" width="auto" height="100px"></canvas>
					</div>
					<div style="margin:10px;">
						<input type="hidden" id="signature" name="signature">
						<button type="button" id="clear_btn" class="btn btn-danger" data-action="clear"> Hapus</button>
						<button type="submit" id="save_btn" class="btn btn-primary" data-action="save-png"> Upload</button>
					</div>
				</div>
				
                <form>
              </div>             
            </div>
              
			</div>
	    </div>
        </div>        			
        </div>				
	<script>
    $('#formguru').submit(function(e){
		e.preventDefault();
		var data = new FormData(this);
		$.ajax(
		{
			type: 'POST',
             url: 'siswa/buatttd.php',
            data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
			$('#progressbox').html('<div><img src="images/animasi.gif" style="width:50px;"></div>');
			},			
			success: function(data){  			
			setTimeout(function()
				{
				window.location.replace("?pg=<?= enkripsi('prakerin') ?>");
						}, 500);
									  
						}
					});
				return false;
			});
		</script>	
             
			
<script>
var wrapper = document.getElementById("signature-pad");
var clearButton = wrapper.querySelector("[data-action=clear]");
var savePNGButton = wrapper.querySelector("[data-action=save-png]");
var canvas = wrapper.querySelector("canvas");
var el_note = document.getElementById("note");
var signaturePad;
signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
	document.getElementById("note").innerHTML="The signature should be inside box";
	signaturePad.clear();
});
savePNGButton.addEventListener("click", function (event){
	if (signaturePad.isEmpty()){
		alert("Please provide signature first.");
		event.preventDefault();
	}else{
		var canvas  = document.getElementById("the_canvas");
		var dataUrl = canvas.toDataURL();
		document.getElementById("signature").value = dataUrl;
	}
});
function my_function(){
	document.getElementById("note").innerHTML="";
}
</script>