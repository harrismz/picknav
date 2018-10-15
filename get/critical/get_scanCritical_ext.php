<?php
//start session
ob_start();
session_start();
ob_end_clean();
date_default_timezone_set('Asia/Jakarta');

//	database connection
	include "../../../adodb/con_part_im.php";
	include "../../../adodb/con_smt_critical.php";

//	call session and post
	$picknav_pic 		= isset($_SESSION['picknav_pic']) ? $_SESSION['picknav_pic'] : '';
	$picknav_levelno    = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno'] : '';
	$date1 				= date("Y-m-d", strtotime("-7 Day"));
	$date2 				= date('Y-m-d');
	$picknav_nik 		= isset($_POST['nik']) ? $_POST['nik'] : '';
	$get_jobno   		= isset($_POST['jobno']) ? $_POST['jobno'] : '';
//	-- scann -------------------------------------------------------------------------------
 	$get_partnumber3  	= isset($_POST['scanpartno']) ? $_POST['scanpartno'] : '';
//	-- endof scann -------------------------------------------------------------------------

$sql2 	= "Exec checkCriticalStatus '{$get_partnumber3}'";
$rs2	= $conn->Execute($sql2);
$rs2->Close();
$criticalStatus = trim($rs2->fields['0']);

if($criticalStatus == '1' ){
	echo'<h4 class="warning" align="center" style="color: green; font-size: 70px;">CRITICAL OK</h4>
		<audio controls autoplay hidden="hidden">
		<source src ="asset/sound/OK.mp3" type="audio/mp3"></audio>';
}
else{
	echo'
		<h4 class="warning" align="center" style="color: red; font-size: 70px;">CRITICAL NG</h4>
		<audio controls autoplay hidden="hidden">
		<source src ="asset/sound/EXPIRED.mp3" type="audio/mp3"></audio>
	';
}

$conn->Close();
$conn=null;
?>