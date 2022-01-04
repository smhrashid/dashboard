<?php
if(!isset($_SESSION['user']))
{
	header("Location: login");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: home");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location: login");
}
?>