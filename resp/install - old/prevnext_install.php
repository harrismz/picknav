<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../adodb/con_part_im.php";

$picknav_nik    	= isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic    	= isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno	= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$jobno_ins          = isset($_POST['jobno_ins'])	          ? $_POST['jobno_ins']	            : '';
$jdate_ins          = isset($_POST['jdate_ins'])	          ? $_POST['jdate_ins']	            : '';
$get_zfeed_ins4     = isset($_POST['zfeed_ins']) 			  ? $_POST['zfeed_ins'] 			: '';
$get_zfeed_ins3		= str_replace("+"," ",$get_zfeed_ins4);
$get_zfeed_ins2		= str_replace("::","#",$get_zfeed_ins3);
$zfeed_ins      	= explode("|",$get_zfeed_ins2);
$total_ins	    	= count($zfeed_ins);
$date_ins 			= date('Y-m-d');
$time_ins 			= date('H:i:s');
$zno_feedergroup	= "";
$zno_zfd        	= "";

for($i=0; $i<$total_ins; $i++){
	
	$sql_jobdetail1 = "select * from jobdetail
						where jobno = '{$jobno_ins}'
							and jobdate = '{$jdate_ins}' 
							and zfeeder containing '{$zfeed_ins[$i]}'
							and (partnumber <> '' or partnumber <> null)
							and (sts_install = '2')";
	$rs_jobdetail1 = $db->Execute($sql_jobdetail1);
	$jobdetail1 = $rs_jobdetail1->RecordCount();
	$rs_jobdetail1->Close();
	
	if($jobdetail1 == 0){
		$sql_jobdetail2 = "select * from jobdetail
							where jobno = '{$jobno_ins}'
								and jobdate = '{$jdate_ins}' 
								and zfeeder containing '{$zfeed_ins[$i]}'
								and (partnumber <> '' or partnumber <> null)
								and (sts_install = '4')";
		$rs_jobdetail2 = $db->Execute($sql_jobdetail2);
		$jobdetail2 = $rs_jobdetail2->RecordCount();
		$rs_jobdetail2->Close();
		
		if($jobdetail2 == 0){
			$sql_jobdetail = "update jobdetail set
								sts_install = '1',
								sts_ins_nik = '{$picknav_nik}',
								sts_ins_name = '{$picknav_pic}',
								sts_ins_startdate = '{$date_ins}',
								sts_ins_starttime = '{$time_ins}'
							where jobno = '{$jobno_ins}'
								and jobdate = '{$jdate_ins}' 
								and zfeeder containing '{$zfeed_ins[$i]}'
								and (partnumber <> '' or partnumber <> null)";
			$rs_jobdetail = $db->Execute($sql_jobdetail);
			$rs_jobdetail->Close();
		}
	}
	
}

for($j=0; $j<$total_ins; $j++){
	$zno_feedergroup 	= $zno_zfd. " zfeeder containing '".$zfeed_ins[$j]."'";
	$zno_zfd 			= $zno_zfd. " zfeeder containing '".$zfeed_ins[$j]."' or";
}

if ($i == $total_ins){
	$zno_feedergroup;
	$sql_jobdetail_chk = "select * from jobdetail
						where jobno = '{$jobno_ins}'
							and jobdate = '{$jdate_ins}'
							and (sts_install = '2' or sts_install = '4')
							and ({$zno_feedergroup})";
	$rs_jobdetail_chk = $db->Execute($sql_jobdetail_chk);
	$jobdetail_chk = $rs_jobdetail_chk->RecordCount();
	$rs_jobdetail_chk->Close();
	
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
$db->Close();
$db=null;
?>