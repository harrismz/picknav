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
$jobno_ins          = isset($_POST['jobno_ins'])	      ? $_POST['jobno_ins']	        : '';
$jdate_ins          = isset($_POST['jdate_ins'])	      ? $_POST['jdate_ins']	        : '';
///$get_zfeed_ins4     = isset($_POST['zfeed_ins']) 		  ? $_POST['zfeed_ins'] 		: '';
///$get_zfeed_ins3		= str_replace("+"," ",$get_zfeed_ins4);
///$zfeed_ins			= str_replace("::","#",$get_zfeed_ins3);
$date_ins 			= date('Y-m-d');
$time_ins 			= date('H:i:s');

$feederno1    	 = isset($_POST['feederno']) 		  ? $_POST['feederno'] 		: '';
$feederno 		 = intval($feederno1) - 1;


$sql_zfeed = "select first 1 skip {$feederno} distinct zno_ins from diff_zfeeder_install2('{$jobno_ins}') group by zno_ins";
$rs_zfeed = $db->Execute($sql_zfeed);
$zfeed_ins = $rs_zfeed->fields[0];
$rs_zfeed->Close();


if(!empty($zfeed_ins)){
	$sql_jobdetail1 = "select * from jobdetail
						where jobno = '{$jobno_ins}'
							and jobdate = '{$jdate_ins}' 
							and zfeeder containing '{$zfeed_ins}'
							and (partnumber <> '' or partnumber <> null)
							and (sts_install = '2')";
	$rs_jobdetail1 = $db->Execute($sql_jobdetail1);
	$jobdetail1 = $rs_jobdetail1->RecordCount();
	$rs_jobdetail1->Close();

	if($jobdetail1 == 0){
		$sql_jobdetail2 = "select * from jobdetail
							where jobno = '{$jobno_ins}'
								and jobdate = '{$jdate_ins}' 
								and zfeeder containing '{$zfeed_ins}'
								and (partnumber <> '' or partnumber <> null)
								and (sts_install = '4')";
		$rs_jobdetail2 = $db->Execute($sql_jobdetail2);
		$jobdetail2 = $rs_jobdetail2->RecordCount();
		$rs_jobdetail2->Close();
		
		if($jobdetail2 == 0){
			$sql_chkdt = "select distinct sts_ins_startdate from jobdetail
								where jobno = '{$jobno_ins}'
									and jobdate = '{$jdate_ins}' 
									and zfeeder containing '{$zfeed_ins}'
									and (partnumber <> '' or partnumber <> null)";
			$rs_chkdt = $db->Execute($sql_chkdt);
			$chkdt = $rs_chkdt->fields[0];
			$rs_chkdt->Close();

			if($chkdt == null or $chkdt == "" ){
				$sql_jobdetail = "update jobdetail set
									sts_install = '1',
									sts_ins_nik = '{$picknav_nik}',
									sts_ins_name = '{$picknav_pic}',
									sts_ins_startdate = '{$date_ins}',
									sts_ins_starttime = '{$time_ins}'
								where jobno = '{$jobno_ins}'
									and jobdate = '{$jdate_ins}' 
									and zfeeder containing '{$zfeed_ins}'";
				//					and (partnumber <> '' or partnumber <> null)";
				$rs_jobdetail = $db->Execute($sql_jobdetail);
				$rs_jobdetail->Close();
			}
			else{
				$sql_jobdetail = "update jobdetail set
									sts_install = '1',
									sts_ins_nik = '{$picknav_nik}',
									sts_ins_name = '{$picknav_pic}'
								where jobno = '{$jobno_ins}'
									and jobdate = '{$jdate_ins}' 
									and zfeeder containing '{$zfeed_ins}'";
				//					and (partnumber <> '' or partnumber <> null)";
				$rs_jobdetail = $db->Execute($sql_jobdetail);
				$rs_jobdetail->Close();
			}
		}
	}

	$sql_jobdetail_chk = "select * from jobdetail
						where jobno = '{$jobno_ins}'
							and jobdate = '{$jdate_ins}'
							and (sts_install = '2' or sts_install = '4')
							and zfeeder containing '{$zfeed_ins}'";
	$rs_jobdetail_chk = $db->Execute($sql_jobdetail_chk);
	$jobdetail_chk = $rs_jobdetail_chk->RecordCount();
	$rs_jobdetail_chk->Close();

	$sql_chkdt2 = "select distinct sts_ins_sdate from jobheaderinfo
						where jobno     = '{$jobno_ins}' 
							and jobdate = '{$jdate_ins}'";
	$rs_chkdt2 = $db->Execute($sql_chkdt2);
	$chkdt2 = $rs_chkdt2->fields[0];
	$rs_chkdt2->Close();

	if($chkdt2 == null or $chkdt2 == "" ){
	
		if ($jobdetail_chk>=1){
			
			$sql_updstatus = "update jobheaderinfo set
									sts_install = '5', 
									sts_ins_snik = '{$picknav_nik}',
									sts_ins_sname = '{$picknav_pic}',
									sts_ins_sdate = '{$date_ins}',
									sts_ins_stime = '{$time_ins}'
								where jobno     = '{$jobno_ins}' 
									and jobdate = '{$jdate_ins}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
			
		}
		else{
			$sql_updstatus = "update jobheaderinfo set
									sts_install = '1', 
									sts_ins_snik = '{$picknav_nik}',
									sts_ins_sname = '{$picknav_pic}',
									sts_ins_sdate = '{$date_ins}',
									sts_ins_stime = '{$time_ins}'
								where jobno     = '{$jobno_ins}' 
									and jobdate = '{$jdate_ins}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
		}
	}
	else{
		if ($jobdetail_chk>=1){
			
			$sql_updstatus = "update jobheaderinfo set
									sts_install = '5', 
									sts_ins_snik = '{$picknav_nik}',
									sts_ins_sname = '{$picknav_pic}'
								where jobno     = '{$jobno_ins}' 
									and jobdate = '{$jdate_ins}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
			
		}
		else{
			$sql_updstatus = "update jobheaderinfo set
									sts_install = '1', 
									sts_ins_snik = '{$picknav_nik}',
									sts_ins_sname = '{$picknav_pic}'
								where jobno     = '{$jobno_ins}' 
									and jobdate = '{$jdate_ins}'";
			$rs_updstatus = $db->Execute($sql_updstatus);
			$rs_updstatus->Close();
		}
	}
}
$db->Close();
$db=null;
?>
