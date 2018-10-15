<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik    	= isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic    	= isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno	= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$feederno   	    = isset($_POST['feederno']) 		  ? $_POST['feederno'] 			: '';
$jobno_chk          = isset($_POST['jobno_chk'])	      ? $_POST['jobno_chk']	        : '';
$jdate_chk          = isset($_POST['jdate_chk'])	      ? $_POST['jdate_chk']	        : '';
$date_chk 			= date('Y-m-d');
$time_chk 			= date('H:i:s');
$feederno1    		= isset($_POST['feederno']) 		  ? $_POST['feederno'] 		: '';
$feederno 		 	= intval($feederno1) - 1;

echo '::  <>>1<<  '.$sql_zfeed = "select first 1 skip {$feederno} distinct zno from checked_slctjob('{$jobno_chk}') group by zno";
$rs_zfeed  = $db->Execute($sql_zfeed);
$zfeed_chk = $rs_zfeed->fields[0];
$rs_zfeed->Close();


if(!empty($zfeed_chk)){
	echo '::  <>>2<<  '.$sql_jobdtl = "select * from jobdetail
						where jobno = '{$jobno_chk}'
							and jobdate = '{$jdate_chk}' 
							and zfeeder containing '{$zfeed_chk}'
							and (partnumber <> '' or partnumber <> null)
							and (sts_checked = '2')";
	$rs_jobdtl = $db->Execute($sql_jobdtl);
	$jobdtl = $rs_jobdtl->RecordCount();
	$rs_jobdtl->Close();

	if($jobdtl == 0){
		echo '::  <>>3<<  '.$sql_jobdtl2 = "select * from jobdetail
							where jobno = '{$jobno_chk}'
								and jobdate = '{$jdate_chk}' 
								and zfeeder containing '{$zfeed_chk}'
								and (partnumber <> '' or partnumber <> null)
								and (sts_checked = '4')";
		$rs_jobdtl2 = $db->Execute($sql_jobdtl2);
		$jobdtl2 = $rs_jobdtl2->RecordCount();
		$rs_jobdtl2->Close();
		
		if($jobdtl2 == 0){
			echo '::  <>>4<<  '.$sql_chkdt = "select distinct sts_chk_sdate from jobdetail
								where jobno = '{$jobno_chk}'
									and jobdate = '{$jdate_chk}' 
									and zfeeder containing '{$zfeed_chk}'
									and (partnumber <> '' or partnumber <> null)";
			$rs_chkdt = $db->Execute($sql_chkdt);
			$chkdt = $rs_chkdt->fields[0];
			$rs_chkdt->Close();

			if($chkdt == null or $chkdt == "" ){
				echo '::  <>>5<<  '.$sql_jobdetail = "update jobdetail set
									sts_checked = '1',
									sts_chk_snik = '{$picknav_nik}',
									sts_chk_sname = '{$picknav_pic}',
									sts_chk_sdate = '{$date_chk}',
									sts_chk_stime = '{$time_chk}'
								where jobno = '{$jobno_chk}'
									and jobdate = '{$jdate_chk}' 
									and zfeeder containing '{$zfeed_chk}'";
				//					and (partnumber <> '' or partnumber <> null)";
				$rs_jobdetail = $db->Execute($sql_jobdetail);
				$rs_jobdetail->Close();
			}
			else{
				echo '::  <>>6<<  '.$sql_jobdetail = "update jobdetail set
									sts_checked = '1',
									sts_chk_snik = '{$picknav_nik}',
									sts_chk_sname = '{$picknav_pic}'
								where jobno = '{$jobno_chk}'
									and jobdate = '{$jdate_chk}' 
									and zfeeder containing '{$zfeed_chk}'";
				//					and (partnumber <> '' or partnumber <> null)";
				$rs_jobdetail = $db->Execute($sql_jobdetail);
				$rs_jobdetail->Close();
			}
		}
	}

	echo '::  <>>7<<  '.$sql_jobdetail_chk = "select * from jobdetail
						where jobno = '{$jobno_chk}'
							and jobdate = '{$jdate_chk}'
							and (sts_checked = '2' or sts_checked = '4')
							and zfeeder containing '{$zfeed_chk}'";
	$rs_jobdetail_chk = $db->Execute($sql_jobdetail_chk);
	$jobdetail_chk = $rs_jobdetail_chk->RecordCount();
	$rs_jobdetail_chk->Close();

	echo '::  <>>8<<  '.$sql_chkdt2 = "select distinct sts_chk_sdate from jobheaderinfo
						where jobno     = '{$jobno_chk}' 
							and jobdate = '{$jdate_chk}'";
	$rs_chkdt2 = $db->Execute($sql_chkdt2);
	$chkdt2 = $rs_chkdt2->fields[0];
	$rs_chkdt2->Close();

	if($chkdt2 == null or $chkdt2 == "" ){
	
		if ($jobdetail_chk>=1){
			
			echo '::  <>>9<<  '.$sql_updstatus = "update jobheaderinfo set
									sts_checked = '5', 
									sts_chk_snik = '{$picknav_nik}',
									sts_chk_sname = '{$picknav_pic}',
									sts_chk_sdate = '{$date_chk}',
									sts_chk_stime = '{$time_chk}'
								where jobno     = '{$jobno_chk}' 
									and jobdate = '{$jdate_chk}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
			
		}
		else{
			echo '::  <>>10<<  '.$sql_updstatus = "update jobheaderinfo set
									sts_checked = '1', 
									sts_chk_snik = '{$picknav_nik}',
									sts_chk_sname = '{$picknav_pic}',
									sts_chk_sdate = '{$date_chk}',
									sts_chk_stime = '{$time_chk}'
								where jobno     = '{$jobno_chk}' 
									and jobdate = '{$jdate_chk}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
		}
	}
	else{
		if ($jobdetail_chk>=1){
			
			echo '::  <>>11<<  '.$sql_updstatus = "update jobheaderinfo set
									sts_checked = '5', 
									sts_chk_snik = '{$picknav_nik}',
									sts_chk_sname = '{$picknav_pic}'
								where jobno     = '{$jobno_chk}' 
									and jobdate = '{$jdate_chk}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
			
		}
		else{
			echo '::  <>>12<<  '.$sql_updstatus = "update jobheaderinfo set
									sts_checked = '1', 
									sts_chk_snik = '{$picknav_nik}',
									sts_chk_sname = '{$picknav_pic}'
								where jobno     = '{$jobno_chk}' 
									and jobdate = '{$jdate_chk}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
		}
	}
}
$db->Close();
$db=null;
?>
