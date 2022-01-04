<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>Free HTML5 Bootstrap Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link href='<?php echo base_url();?>asset/css/bootstrap-cerulean.min.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/charisma-app.css' rel="stylesheet">
    <link href='<?php echo base_url();?>asset/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='<?php echo base_url();?>asset/bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/jquery.noty.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/elfinder.min.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/uploadify.css' rel='stylesheet'>
    <link href='<?php echo base_url();?>asset/css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>asset/bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>asset/img/favicon.ico">
    
    <!-- external javascript -->

<script src="<?php echo base_url();?>asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="<?php echo base_url();?>asset/js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='<?php echo base_url();?>asset/bower_components/moment/min/moment.min.js'></script>
<script src='<?php echo base_url();?>asset/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?php echo base_url();?>asset/js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="<?php echo base_url();?>asset/bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo base_url();?>asset/bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="<?php echo base_url();?>asset/js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="<?php echo base_url();?>asset/bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="<?php echo base_url();?>asset/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="<?php echo base_url();?>asset/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo base_url();?>asset/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="<?php echo base_url();?>asset/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="<?php echo base_url();?>asset/js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo base_url();?>asset/js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo base_url();?>asset/js/charisma.js"></script>


<?php
if(isset($_POST['btn-login']))
{
	$email = $_POST['email'];
	$upass = $_POST['pass'];
	$query = "select * from IPL.PL_REG_INFO where emailaddr ='$email'";				
	$stid = OCIParse($conn, $query);
	  OCIExecute($stid);
	while($row=oci_fetch_array($stid))
        { 
	if($row[5]==md5($upass))
	{
		$_SESSION['user'] = $row[0];
		if($row[7]==1 && $row[9]==1)
		{
		header("Location: home");
		}

	}
	elseif($row[8]==md5($upass))
	{
		$_SESSION['user'] = $row[0];
		if($row[7]==1 && $row[9]==1)
		{
				session_start(); 
				$_SESSION['email_add']=$email;
				header("Location: changepass");
		}
	}
	else
	{
		?>
        <script>alert('wrong details');</script>
        <?php
	}}}
?>
	<style type="text/css">

	  .login-header {
    height: 185px !important;
    padding-top: 0px !important;
	}
	</style>
</head>

<body>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
				<div class="span12 center login-header">
                                        <img src="<?php echo base_url();?>asset/images/pragati_life_insurance_limited.png" alt="Pragati Life Insurance Limited">
					<h2>Welcome to Pragati Life Insurance Limited</h2>
                                        <h3 style="color:#286100">Online Payment Management System</h3>
				</div><!--/span-->
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Please login with your Username and Password.
            </div>
            <form class="form-horizontal" method="post" action="login">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" name="pass" class="form-control" placeholder="Your Password" required>
                    </div>
                    <div class="clearfix"></div>
<!--/
                    <div class="input-prepend">
                        <label class="remember" for="remember"><input type="checkbox" id="remember"> Remember me</label>
                    </div>
                    -->
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary" name="btn-login">Sign In</button>
                    </p>
                    		<a href="perinfo">Sign Up for new user </a> </br>
							<a href="lostpass">Lost your Password ? </a>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->

                                 <footer class="">
                    <div class=" " style="min-height: 68px; border-radius:0 0 10px 10px; "> 
                        <div class="span12" style="text-align: center; padding-left: 50px;">2014 &copy; Pragati Life Insurance Limited - IT Department ALL Rights Reserved.</div>
                        <div class="span10" style="text-align: center; padding-left: 90px;">Powered by: <image src='<?php echo base_url();?>asset/images/pragati_life_office_circular.png' /></div>
                    </div>
	</footer>


</body>
</html>
