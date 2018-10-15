<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../adodb/con_part_im.php";

$picknav_nik    = isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic    = isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$jobno          = isset($_POST['jobno'])	          ? $_POST['jobno']	            : '';
$jdate          = isset($_POST['jdate'])	          ? $_POST['jdate']	            : '';
$date = date('Y-m-d');
$time = date('H:i:s');


//echo 'zfeed tidak ada';
//upd status jobdetail = null (awal)
$sql_upd3	=  "update jobdetail set 
						sts_opstart = null, 
						unp_picknik = '{$picknav_nik}', 
						unp_pickname = '{$picknav_pic}',
						unp_pickdate = '{$date}', 
						unp_picktime = '{$time}' 
					where jobno = '{$jobno}' 
					and jobdate = '{$jdate}'
					and (partnumber <> '' or partnumber <> null)
					and sts_opstart is not null";
$rs_upd3 = $db->Execute($sql_upd3);
$rs_upd3->Close();

//upd status jobheader = null (awal)
$sql_upd4 	=  "update jobheaderinfo set 
						sts_opstart = null,
						unp_picknik = '{$picknav_nik}',
						unp_pickname = '{$picknav_pic}',
						unp_pickdate = '{$date}',
						unp_picktime = '{$time}'
					where jobno = '{$jobno}'
					and jobdate = '{$jdate}'";
$rs_upd4 = $db->Execute($sql_upd4);
$rs_upd4->Close();


$db->Close();
$db=null;
?>