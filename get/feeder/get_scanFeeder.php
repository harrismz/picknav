<?php
//start session
ob_start();
session_start();
ob_end_clean();
date_default_timezone_set('Asia/Jakarta');

//	database connection
	include "../../../adodb/con_part_im.php";
	include "../../../adodb/con_smt_feeder.php";

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

$feederno1    	= isset($_POST['feederno']) ? $_POST['feederno'] : '';
$feederno 		= intval($feederno1) - 1;
if($feederno < 0){ $feederno = 0; }

$sql_zfeed	= "select first 1 skip {$feederno} distinct zno_ins from diff_zfeeder_install2('{$get_jobno}') group by zno_ins";
$rs_zfeed	= $db->Execute($sql_zfeed);
$zfeed_ins	= $rs_zfeed->fields[0];
$rs_zfeed->Close();


	$sql2 	= "Exec checkFeederStatus '{$get_partnumber3}'";
	$rs2	= $db_feeder->Execute($sql2);
	$rs2->Close();
	$feederStatus = trim($rs2->fields['0']);
	
	if($feederStatus == '1' ){
		echo'<h4 class="warning" align="center" style="color: green; font-size: 70px;">FEEDER OK</h4>
			<audio controls autoplay hidden="hidden">
			<source src ="asset/sound/OK.mp3" type="audio/mp3"></audio>';
	}
	elseif($feederStatus == '2' ){
		echo'<h4 class="warning" align="center" style="color: red; font-size: 70px;">FEEDER NG</h4>
			<audio controls autoplay hidden="hidden">
			<source src ="asset/sound/NG.mp3" type="audio/mp3"></audio>';
	}
	elseif($feederStatus == '0' ){
		echo'
			<h4 class="warning" align="center" style="color: red; font-size: 70px;">FEEDER NG</h4>
			<audio controls autoplay hidden="hidden">
			<source src ="asset/sound/NG.mp3" type="audio/mp3"></audio>';
	}
	else{
		echo'
			<h4 class="warning" align="center" style="color: red; font-size: 70px;">FEEDER TIDAK TERDAFTAR</h4>
			<audio controls autoplay hidden="hidden">
			<source src ="asset/sound/fider_tidak_ada.mp3" type="audio/mp3"></audio>';
	}
	

$rs2->Close();

$db_feeder->Close();
$db_feeder=null;
?>