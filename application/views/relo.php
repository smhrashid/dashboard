<script src="<?php echo base_url();?>asset/js/jquery-2.1.1.min.js"></script>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-home"></i> Home</h2>

                <div class="box-icon">

                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
            
    <div class="row">
    <div class="container">
<div id="screen"></div>
  </div>
</div>  
<script>
$(document).ready(function(){
   
   $('#screen').load('banners');

});
</script>    
<script>
$(document).ready(function(){
	setInterval(function(){
		$("#screen").load('banners')
    }, 90000);
});
</script>

