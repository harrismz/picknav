<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	include "../adodb/con_smt_critical.php";
	
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
		$criticalid = substr($partnumber2,16,13);
		//J7J-0520-00    +EXP1810141923+20191014+ID1810140244+BK1810140006
		$bakingid	 = substr($partnumber2,39,12);
		$issueid	 = substr($partnumber2,52,12);
		
		$partnumber1 = substr($partnumber2, 0, 15);
		$arr = explode("(", $partnumber1, 2);
		$partnumber = $arr[0];
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
	
	
	if($action=="saveCriticalInstall"){
		
		//	***	
		//	search zfeeder
			$sql2 		= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
							install, ket, zfd_name, zfd_no, zfd_tray, install_date, install_time
						from pn_install('{$jobno}')
						where zfeeder containing '{$zfeeder}' and partnumber = '{$partnumber}'
						and (install = '' or install is null)
						order by zfd_name,zfd_no,install_date,install_time asc";
			$rs2		  = $db->Execute($sql2);
			$exist2	  = $rs2->RecordCount();
			$zfeeder11 = $rs2->fields[0];
			$rs2->Close();
		
			
			$sql2 	= "Exec checkCriticalStatus '{$partnumber2}'";
			$rs2	= $conn->Execute($sql2);
			$rs2->Close();
			$criticalStatus = trim($rs2->fields['0']);
			
			if($criticalStatus == '1' ){
				$sql_insscan = "INSERT INTO CRITICALRECORDS (jobno, zfeeder, partno, critical_nik, critical_date, critical_time, critical_id, expdate, source, issue_id, baking_id)
							values ('{$jobno}','{$zfeeder}','{$partnumber}','{$picknav_nik}','{$date}','{$time}','{$criticalid}','{$jdate}','INSTALL','{$bakingid}','{$issueid}')";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
	}
	elseif($action=="saveCriticalMenu"){
		$sql2 	= "Exec checkCriticalStatus '{$partnumber2}'";
		$rs2	= $conn->Execute($sql2);
		$rs2->Close();
		$criticalStatus = trim($rs2->fields['0']);
		$jdate2 = trim($rs2->fields['2']);
		$yyyy = substr($jdate2,0,4);
		$mm = substr($jdate2,4,2);
		$dd = substr($jdate2,6,2);
		$jdate = $yyyy.'-'.$mm.'-'.$dd;
		if($criticalStatus == '1' ){
			$sql_insscan = "INSERT INTO CRITICALRECORDS (jobno, zfeeder, partno, critical_nik, critical_date, critical_time, critical_id, expdate, source, issue_id, baking_id)
						values ('{$jobno}','','{$partnumber}','{$picknav_nik}','{$date}','{$time}','{$criticalid}','{$jdate}','MENU','{$bakingid}','{$issueid}')";
			$rs_insscan = $db->Execute($sql_insscan);
			$rs_insscan->Close();
		}
	}
	

$db->Close();
$db=null;
$conn->Close();
$conn=null;
?>