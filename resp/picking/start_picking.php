<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik    = isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic    = isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$jobno          = isset($_POST['jobno'])	          ? $_POST['jobno']	            : '';
$jdate          = isset($_POST['jdate'])	          ? $_POST['jdate']	            : '';
$get_zfeed4     = isset($_POST['zfeed']) 			  ? $_POST['zfeed'] 			: '';
$get_zfeed3     = str_replace("+"," ",$get_zfeed4);
$get_zfeed2     = str_replace("::","#",$get_zfeed3);
$zfeed          = explode("|",$get_zfeed2);
$total          = count($zfeed);
$date           = date('Y-m-d');
$time           = date('H:i:s');
$zno_feedergroup= "";
$zno_zfd        = "";

for($i=0; $i<$total; $i++){
	
	$sql_jobdetail1 = "select * from jobdetail
						where jobno = '{$jobno}'
							and jobdate = '{$jdate}' 
							and zfeeder containing '{$zfeed[$i]}'
							and (partnumber <> '' or partnumber <> null)
							and (sts_opstart = '2')";
	$rs_jobdetail1 = $db->Execute($sql_jobdetail1);
	$jobdetail1 = $rs_jobdetail1->RecordCount();
	$rs_jobdetail1->Close();
	if($jobdetail1 == 0){
		$sql_jobdetail2 = "select * from jobdetail
							where jobno = '{$jobno}'
								and jobdate = '{$jdate}' 
								and zfeeder containing '{$zfeed[$i]}'
								and (partnumber <> '' or partnumber <> null)
								and (sts_opstart = '4')";
		$rs_jobdetail2 = $db->Execute($sql_jobdetail2);
		$jobdetail2 = $rs_jobdetail2->RecordCount();
		$rs_jobdetail2->Close();
		
		if($jobdetail2 == 0){
			
			//$sql_jobdetailstatus = "select distinct sts_opstart from jobdetail
			//					where jobno = '{$jobno}'
			//						and jobdate = '{$jdate}' 
			//						and zfeeder containing '{$zfeed[$i]}'
			//						and (partnumber <> '' or partnumber <> null)";
			//$rs_jobdetailstatus = $db->Execute($sql_jobdetailstatus);
			//$jobdetailstatus = $rs_jobdetailstatus->fields[0];
			//$rs_jobdetailstatus->Close();
			//
			//if($jobdetailstatus != 1){
				$sql_jobdetail = "update jobdetail set
									sts_opstart = '1',
									op_nik = '{$picknav_nik}',
									op_name = '{$picknav_pic}',
									op_startdate = '{$date}',
									op_starttime = '{$time}'
								where jobno = '{$jobno}'
									and jobdate = '{$jdate}' 
									and zfeeder containing '{$zfeed[$i]}'
									and (partnumber <> '' or partnumber <> null)";
				$rs_jobdetail = $db->Execute($sql_jobdetail);
				$rs_jobdetail->Close();
			//}
		}
	}
	
}

for($j=0; $j<$total; $j++){
	$zno_feedergroup 	= $zno_zfd. " zfeeder containing '".$zfeed[$j]."'";
	$zno_zfd 			= $zno_zfd. " zfeeder containing '".$zfeed[$j]."' or";
}

if ($i == $total){
	$zno_feedergroup;
	$sql_jobdetail_chk = "select * from jobdetail
						where jobno = '{$jobno}'
							and jobdate = '{$jdate}'
							and (sts_opstart = '2' or sts_opstart = '4')
							and ({$zno_feedergroup})";
	$rs_jobdetail_chk = $db->Execute($sql_jobdetail_chk);
	$jobdetail_chk = $rs_jobdetail_chk->RecordCount();
	$rs_jobdetail_chk->Close();
	
	if ($jobdetail_chk>=1){
		$sql_updstatus = "update jobheaderinfo set
								sts_opstart = '5', 
								op_nik      = '{$picknav_nik}', 
								op_name     = '{$picknav_pic}', 
								op_startdate= '{$date}', 
								op_starttime= '{$time}' 
							where jobno     = '{$jobno}' 
								and jobdate = '{$jdate}'";
		$rs_updstatus = $db->Execute($sql_updstatus);
		$rs_updstatus->Close();
	}
	else{
		$sql_updstatus = "update jobheaderinfo set
								sts_opstart = '1', 
								op_nik      = '{$picknav_nik}', 
								op_name     = '{$picknav_pic}', 
								op_startdate= '{$date}', 
								op_starttime= '{$time}' 
							where jobno     = '{$jobno}' 
								and jobdate = '{$jdate}'";
		$rs_updstatus = $db->Execute($sql_updstatus);
		$rs_updstatus->Close();
	}
}
$db->Close();
$db=null;
?>