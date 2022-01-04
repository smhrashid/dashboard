<?php
	@session_start();
    require "ebl/configuration.php";
    require "ebl/skypay.php";

	echo "<h1>Payment Cancelled</h1>";

    $skypay = new skypay($configArray);
    $skypay->pr($skypay->RetrieveOrder($_GET["order"]));
?>