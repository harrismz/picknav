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
$zfeed          = isset($_POST['zfeed'])	          ? $_POST['zfeed']	            : '';
$date = date('Y-m-d');
$time = date('H:i:s');

if(empty($zfeed)){
	//echo 'zfeed tidak ada';
	//upd status jobdetail = 1 (proses)
	$sql_upd3	=  "update jobdetail set 
							sts_opstart = '1', 
							unf_nik = '{$picknav_nik}', 
							unf_name = '{$picknav_pic}',
							unf_date = '{$date}', 
							unf_time = '{$time}' 
						where jobno = '{$jobno}' 
						and jobdate = '{$jdate}'
						and (partnumber <> '' or partnumber <> null)
						and sts_opstart is not null";
    $rs_upd3 = $db->Execute($sql_upd3);
    $rs_upd3->Close();
	
	//upd status jobheader = 1 (proses)
	$sql_upd4 	=  "update jobheaderinfo set 
							sts_opstart = '1',
							unf_nik = '{$picknav_nik}',
							unf_name = '{$picknav_pic}',
							unf_date = '{$date}',
							unf_time = '{$time}'
						where jobno = '{$jobno}'
						and jobdate = '{$jdate}'";
    $rs_upd4 = $db->Execute($sql_upd4);
    $rs_upd4->Close();
}
elseif(!empty($zfeed)){
	//echo 'zfeed ada';
	//upd status jobdetail = 1 (proses)
	$sql_upd = "update jobdetail set 
					sts_opstart = '1',
					unf_nik = '{$picknav_nik}',
					unf_name = '{$picknav_pic}',
					unf_date = '{$date}', 
					unf_time = '{$time}' 
				where jobno = '{$jobno}' 
					and jobdate = '{$jdate}'
					and (partnumber <> '' or partnumber <> null)
					and zfeeder containing '{$zfeed}'";
	
	$rs_sql_upd = $db->Execute($sql_upd);
	$rs_sql_upd->Close();
	
	//check data status 2,4 di jobdetail
	$sql_chk    	=  "select * from jobdetail 
						where jobno = '$jobno' 
							and jobdate = '$jdate'
							and (partnumber <> '' or partnumber <> null)
							and (sts_opstart = '2' or sts_opstart = '4')";
										
	$rs_sql_chk 	= $db->Execute($sql_chk);
	$exst_sql_chk	= $rs_sql_chk->RecordCount();
	$rs_sql_chk->Close();
	
	if($exst_sql_chk == 0){
		$sql_upd2	=  "update jobheaderinfo set
							sts_opstart = '1',
							unf_nik = '{$picknav_nik}', 
							unf_name = '{$picknav_pic}',
							unf_date = '{$date}',
							unf_time = '{$time}'
						where jobno = '{$jobno}'
							and jobdate = '{$jdate}'";
									
		$rs_sql_upd2 = $db->Execute($sql_upd2);
		$rs_sql_upd2->Close();
	}
	elseif($exst_sql_chk >= 1){
		$sql_upd2	=  "update jobheaderinfo set
							sts_opstart = '5',
							unf_nik = '{$picknav_nik}', 
							unf_name = '{$picknav_pic}',
							unf_date = '{$date}',
							unf_time = '{$time}'
						where jobno = '{$jobno}' 
							and jobdate = '{$jdate}'";
									
		$rs_sql_upd2 = $db->Execute($sql_upd2);
		$rs_sql_upd2->Close();
	}
}

$db->Close();
$db=null;
?>