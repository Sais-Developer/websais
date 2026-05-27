<?php
defined('APK') or exit('No Access');
?>
<div class='row'>
   <div class="col-md-12">
		<div class="card-header" >	
				<h5 class="card-title">STATUS PESERTA</h5>
			    </div>				
			<div id="status-ujian">                    
		      
		</div>                     
	</div> 
</div> 
<script>
    var autoRefresh = setInterval(
        function() {
            <?php if (isset($_GET['idu'])) { ?>
                $('#status-ujian').load("<?= $baseurl ?>/mycbt/ujian_status.php?idu=<?= $_GET['idu'] ?>");
				
            <?php } ?>
        }, 3000
    );
</script>