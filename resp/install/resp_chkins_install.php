<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	
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
		$partnumber1 = substr($partnumber2, 0, 15);
		$arr = explode("(", $partnumber1, 2);
		$partnumber = $arr[0];
		$firmno = '('.$arr[1];
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
	
	
	if($action=="saveInstall"){
		
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
			$pos2 	   = trim($rs2->fields[2]);
			$rs2->Close();
		
		if($exist2 != 0){
			$pos = "";
			if (empty($pos2)){
				$pos = "pos = '{$pos2}' or pos is null";
			}
			else{
				$pos = "pos = '{$pos2}'";
			}
			//CK73HBB1A104K 910000195842410X
			//CK73HBB1E103K 9 7000195842410X
			//RK73HB1J103J  910000195842410X
			//RK73HB1J103J  9
			$sql_upd_ins2= "UPDATE jobdetail SET install = 'OK', install_nik = '{$picknav_nik}', install_name = '{$picknav_pic}',
							install_date = '{$date}', install_time = '{$time}'
							where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder11}'
							and partnumber = '{$partnumber}' and ($pos);";
			$rs_upd_ins2 = $db->Execute($sql_upd_ins2);
			$rs_upd_ins2->Close();
			
			$sql_checkscan1 = "Select count(*) from installscan 
								where jobno = '{$jobno}' 
								and jobdate = '{$jdate}' 
								and partno containing '{$partnumber}'";
			$rs_checkscan1 = $db->Execute($sql_checkscan1);
			$check1 = $rs_checkscan1->fields[0];
			$rs_checkscan1->Close();
						
			$sql_checkscan = "Select count(*) from installscan 
								where jobno = '{$jobno}' 
								and jobdate = '{$jdate}' 
								and partno = '{$partnumber2}'";
			$rs_checkscan = $db->Execute($sql_checkscan);
			$check = $rs_checkscan->fields[0];
			$rs_checkscan->Close();
					
			if($check1==0 && $check == 0){
				$sql_insscan = "INSERT INTO INSTALLSCAN (jobno, zfeeder, partno, scannik, scandate, scantime, status, jobdate)
								values ('{$jobno}','{$zfeeder11}','{$partnumber2}','{$picknav_nik}','{$date}','{$time}','1','{$jdate}')";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
			elseif($check1==0 && $check != 0){
				$sql_insscan = "UPDATE INSTALLSCAN SET 
													zfeeder = '{$zfeeder11}',
													scannik = '{$picknav_nik}', 
													scandate = '{$date}', 
													scantime = '{$time}'
												where jobno = '{$jobno}' 
													and jobdate = '{$jdate}' 
													and partno = '{$partnumber2}'";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
			elseif($check1!=0 && $check == 0){
				$sql_insscan = "INSERT INTO INSTALLSCAN (jobno, zfeeder, partno, scannik, scandate, scantime, status, jobdate)
								values ('{$jobno}','{$zfeeder11}','{$partnumber2}','{$picknav_nik}','{$date}','{$time}','2','{$jdate}')";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
			elseif($check1!=0 && $check != 0){
				$sql_insscan = "UPDATE INSTALLSCAN SET 
													zfeeder = '{$zfeeder11}',
													scannik = '{$picknav_nik}', 
													scandate = '{$date}', 
													scantime = '{$time}'
												where jobno = '{$jobno}' 
													and jobdate = '{$jdate}' 
													and partno = '{$partnumber2}'";
				$rs_insscan = $db->Execute($sql_insscan);
				$rs_insscan->Close();
			}
		}
		else{
			$sql 		= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
							install, ket, zfd_name, zfd_no, zfd_tray, install_date, install_time
						from pn_install('{$jobno}')
						where zfeeder containing '{$zfeeder}' and partnumber = '{$partnumber}'
						order by zfd_name,zfd_no,install_date,install_time asc";
			$rs		  = $db->Execute($sql);
			$exist	  = $rs->RecordCount();
			$zfeeder3 = $rs->fields[0];
			$pos3 	   = trim($rs->fields[2]);
			$rs->Close();
			
			if($exist != 0){
				$pos = "";
				if (empty($pos3)){
					$pos = "pos = '{$pos3}' or pos is null";
				}
				else{
					$pos = "pos = '{$pos3}'";
				}
				$sql_upd_ins= "UPDATE jobdetail SET install = 'OK', install_nik = '{$picknav_nik}', install_name = '{$picknav_pic}',
								install_date = '{$date}', install_time = '{$time}'
								where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder3}'
								and partnumber = '{$partnumber}' and ($pos);";
				$rs_upd_ins = $db->Execute($sql_upd_ins);
				$rs_upd_ins->Close();
				

				$sql_checkscan1 = "Select count(*) from installscan 
											where jobno = '{$jobno}' 
											and jobdate = '{$jdate}' 
											and partno containing '{$partnumber}'";
						$rs_checkscan1 = $db->Execute($sql_checkscan1);
						$check1 = $rs_checkscan1->fields[0];
						$rs_checkscan1->Close();
						
						$sql_checkscan = "Select count(*) from installscan 
											where jobno = '{$jobno}' 
											and jobdate = '{$jdate}' 
											and partno = '{$partnumber2}'";
						$rs_checkscan = $db->Execute($sql_checkscan);
						$check = $rs_checkscan->fields[0];
						$rs_checkscan->Close();
						
				if($check1==0 && $check == 0){
					$sql_insscan = "INSERT INTO INSTALLSCAN (jobno, zfeeder, partno, scannik, scandate, scantime, status, jobdate)
									values ('{$jobno}','{$zfeeder3}','{$partnumber2}','{$picknav_nik}','{$date}','{$time}','1','{$jdate}')";
					$rs_insscan = $db->Execute($sql_insscan);
					$rs_insscan->Close();
				}
				elseif($check1==0 && $check != 0){
					$sql_insscan = "UPDATE INSTALLSCAN SET 
														zfeeder = '{$zfeeder3}',
														scannik = '{$picknav_nik}', 
														scandate = '{$date}', 
														scantime = '{$time}'
													where jobno = '{$jobno}' 
														and jobdate = '{$jdate}' 
														and partno = '{$partnumber2}'";
					$rs_insscan = $db->Execute($sql_insscan);
					$rs_insscan->Close();
				}
				elseif($check1!=0 && $check == 0){
					$sql_insscan = "INSERT INTO INSTALLSCAN (jobno, zfeeder, partno, scannik, scandate, scantime, status, jobdate)
									values ('{$jobno}','{$zfeeder3}','{$partnumber2}','{$picknav_nik}','{$date}','{$time}','2','{$jdate}')";
					$rs_insscan = $db->Execute($sql_insscan);
					$rs_insscan->Close();
				}
				elseif($check1!=0 && $check != 0){
					$sql_insscan = "UPDATE INSTALLSCAN SET 
														zfeeder = '{$zfeeder3}',
														scannik = '{$picknav_nik}', 
														scandate = '{$date}', 
														scantime = '{$time}'
													where jobno = '{$jobno}' 
														and jobdate = '{$jdate}' 
														and partno = '{$partnumber2}'";
					$rs_insscan = $db->Execute($sql_insscan);
					$rs_insscan->Close();
				}
			}
		}
	}
	elseif($action == 'cancelInstall'){
		$zfeeder4	= isset($_REQUEST['zfeeder']) ? $_REQUEST['zfeeder'] : '';
		$pos4 = isset($_REQUEST['pos']) ? $_REQUEST['pos'] : '';
		if ($pos4 == ""){
			$pos = "pos = '{$pos4}' or pos is null";
		}
		else{
			$pos = "pos = '{$pos4}'";
		}
		$sql_upd_cancel= "UPDATE jobdetail SET install = Null, install_nik = Null, install_name = Null,
						install_date = Null, install_time = Null, cancel_ins_date = '{$date}', cancel_ins_time = '{$time}'
						where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder4}'
						and partnumber = '{$partnumber}' and ($pos);";
		$rs_upd_cancel = $db->Execute($sql_upd_cancel);
		$rs_upd_cancel->Close();
		
		$sql_insscan = "DELETE FROM INSTALLSCAN WHERE jobno = '{$jobno}'
									and zfeeder = '{$zfeeder4}'
									and partno containing '{$partnumber}'
									and scannik = '{$picknav_nik}'
									and jobdate = '{$jdate}'";
		$rs_insscan = $db->Execute($sql_insscan);
		$rs_insscan->Close();
}

$db->Close();
$db=null;
?>