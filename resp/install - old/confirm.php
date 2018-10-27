<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik    = isset($_SESSION['picknav_nik'])		? $_SESSION['picknav_nik'] 		: '';
$picknav_pic    = isset($_SESSION['picknav_pic'])		? $_SESSION['picknav_pic'] 		: '';
$picknav_levelno= isset($_SESSION['picknav_levelno'])	? $_SESSION['picknav_levelno']	: '';
$jobno          = isset($_POST['jobno'])				? $_POST['jobno']         		: '';
$jdate          = isset($_POST['jdate'])				? $_POST['jdate']         		: '';
$zfeed          = isset($_POST['zfeed'])				? $_POST['zfeed']         		: '';
$pos1           = isset($_POST['pos1'])					? $_POST['pos1']       			: '';
$pos2           = isset($_POST['pos2'])					? $_POST['pos2']       			: '';
$status         = isset($_POST['status'])				? $_POST['status']   			: '';
$date           = gmdate('Y-m-d');
$time           = date('H:i:s');

$sql  = "select count(*) from confinstall where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfd = '{$zfeed}';";
$rs   = $db->Execute($sql);
$exist=  $rs->fields[0];
$rs->Close();

if($status == "1"){
	if($exist == 0){
		$sql = "insert into confinstall (jobno, jobdate, zfd, posstart, confstart, picnik, picname, confdate, conftime)
				values ('{$jobno}','{$jdate}','{$zfeed}','{$pos1}','OK','{$picknav_nik}','{$picknav_pic}',
				CURRENT_DATE,CURRENT_TIME)";
		$rs  = $db->Execute($sql);
		$rs->Close();
	}
	else{
		$sql = "update confinstall set 
				posstart  = '{$pos1}',
				confstart = 'OK',
				picnik  = '{$picknav_nik}',
				picname = '{$picknav_pic}',
				confdate= CURRENT_DATE,
				conftime= CURRENT_TIME
			where jobdate = '{$jdate}'
			and  jobno  = '{$jobno}'
			and zfd = '{$zfeed}';";
	$rs  = $db->Execute($sql);
	$rs->Close();
	}
}
elseif($status == "2"){
	if($exist == 0){
		$sql = "insert into confinstall (jobno, jobdate, zfd, posend, confend, picnik, picname, confdate, conftime)
				values ('{$jobno}','{$jdate}','{$zfeed}','{$pos2}','OK','{$picknav_nik}','{$picknav_pic}',
				CURRENT_DATE,CURRENT_TIME)";
		$rs  = $db->Execute($sql);
		$rs->Close();
	}
	else{
		$sql = "update confinstall set 
					posend  = '{$pos2}',
					confend = 'OK',
					picnik  = '{$picknav_nik}',
					picname = '{$picknav_pic}',
					confdate= CURRENT_DATE,
					conftime= CURRENT_TIME
				where jobdate = '{$jdate}'
				and  jobno  = '{$jobno}'
				and zfd = '{$zfeed}';";
		$rs  = $db->Execute($sql);
		$rs->Close();
	}
}

$db->Close();
$db=null;
?>
