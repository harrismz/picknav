<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	include "../adodb/con_smt_feeder.php";
	
    echo 'DATE !! '.$date    = date("Y-m-d");
    echo 'TIME !! '.$time    = date('H:i:s');
	$action	 = isset($_GET['action']) ? $_GET['action'] : '';
	
	//	***
	//	call session
		$picknav_pic      = isset($_SESSION['picknav_pic']) ? $_SESSION['picknav_pic'] : '';
		$picknav_levelno  = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno'] : '';
		$picknav_disabled = isset($_SESSION['picknav_disabled']) ? $_SESSION['picknav_disabled'] : '';
		$picknav_nik      = isset($_SESSION['picknav_nik']) ? $_SESSION['picknav_nik'] : '';
	
	//	***
	//	call post
		$jdate2      = isset($_REQUEST['jdate']) ? $_REQUEST['jdate'] : '';
		$jobno2      = isset($_REQUEST['jobno']) ? $_REQUEST['jobno'] : '';
		$partnumber2 = isset($_REQUEST['partnumber']) ? $_REQUEST['partnumber'] : '';
		$partnumber11 = substr($partnumber2, 0, 9);
		$partnumber12 = substr($partnumber2, 10, 6);
		$partnumber = $partnumber11.''.$partnumber12;
		$jdate = trim($jdate2);
		$jobno = trim($jobno2);
	
	//	***	
	//	get feeder no ( urutan ke ZFEEDER/MACHINE )
		$feederno1   = isset($_REQUEST['feederno']) ? $_REQUEST['feederno'] : '';
		$feederno    = intval($feederno1) - 1;
		if($feederno < 0){ $feederno = 0; }

	//	***	
	//	search zfeeder by feeder no
		$sql_zfeed = "select first 1 skip {$feederno} distinct zno_ins 
											from diff_zfeeder_install2('{$jobno2}') group by zno_ins";
		$rs_zfeed = $db->Execute($sql_zfeed);
		$zfeeder = $rs_zfeed->fields[0];
		$rs_zfeed->Close();
	
	
	if($action=="saveFeederInstall"){
		
		//	***	
		//	search zfeeder
			$sql2 	= "Exec checkFeederStatus '{$partnumber2}'";
			$rs2	= $db_feeder->Execute($sql2);
			$rs2->Close();
			$feederStatus = trim($rs2->fields['0']);
			$lastcheck	  = trim($rs2->fields['1']);
			$feederid	  = trim($rs2->fields['4']);
			
			if($feederStatus == '1' ){
				$sql_insscan = "INSERT INTO FEEDERRECORDS (jobno, zfeeder, sn, feeder_nik, feeder_date, feeder_time, feeder_id, lastcheck, source)
							values ('{$jobno}','{$zfeeder}','{$partnumber}','{$picknav_nik}','{$date}','{$time}','{$feederid}','{$lastcheck}','INSTALL')";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
			else{
				$sql_insscan = "INSERT INTO FEEDERRECORDS (jobno, zfeeder, sn, feeder_nik, feeder_date, feeder_time, feeder_id, lastcheck, source)
							values ('{$jobno}','{$zfeeder}','{$partnumber}','{$picknav_nik}','{$date}','{$time}','{$feederid}','{$lastcheck}','INSTALL')";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
	}
	

$db->Close();
$db=null;
$conn->Close();
$conn=null;
?>