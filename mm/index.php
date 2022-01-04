<?php

$email_add= $_GET['code'];
include_once 'db/db_connect_oracle.php';
$query = "select * from IPL.PL_REG_INFO where emailaddr ='$email_add'";
		$stid = OCIParse($conn, $query);
		
		OCIExecute($stid);
        while($row=oci_fetch_array($stid))
        { 
		$e_add = $row[0];
		$activation = $row[8];
		}
	//	echo $email_activation;

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include 'smtp/Send_Mail.php';

$m_base_url ="http://plil.pragatilife.com/payonline/activation?code=";
$to= $email_add;
//$to= "smhrashid@gmail.com";
$subject="Email verification";
$body='Hi, <br/> <br/> We need to make sure you are human. Please verify your email and get started using your Website account. <br/> <br/> <a href="'.$m_base_url.$activation.'">'.$m_base_url.$activation.'</a>';
//echo $body;
Send_Mail($to,$subject,$body);
header('Location: http://plil.pragatilife.com/payonline/massege');
?>