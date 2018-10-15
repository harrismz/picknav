<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	
    $date    = date("Y-m-d");
    $time    = date('H:i:s');
	$action	 = isset($_GET['action']) ? $_GET['action'] : '';
	echo 'RESP CHKINS CHECKED';
	//call session
    $picknav_pic      = isset($_SESSION['picknav_pic']) 			? $_SESSION['picknav_pic'] 		: '';
    $picknav_levelno  = isset($_SESSION['picknav_levelno']) 		? $_SESSION['picknav_levelno'] 	: '';
    $picknav_disabled = isset($_SESSION['picknav_disabled']) 		? $_SESSION['picknav_disabled'] : '';
    $picknav_nik      = isset($_SESSION['picknav_nik'])  			? $_SESSION['picknav_nik']  	: '';
	
    $jdate2	    = isset($_REQUEST['jdate_chkd']) ? $_REQUEST['jdate_chkd'] : '';
    $jobno2	    = isset($_REQUEST['jobno_chkd']) ? $_REQUEST['jobno_chkd'] : '';
    $partnumber1 = isset($_REQUEST['partnumber_chkd']) ? $_REQUEST['partnumber_chkd'] : '';
    $partnumber = trim($partnumber1);
	
	$seq	    	 = isset($_REQUEST['seq']) ? $_REQUEST['seq'] : '';
	$feederno1    	 = isset($_REQUEST['feederno']) ? $_REQUEST['feederno'] : '';
	$feederno 		 = intval($feederno1) - 1;
	if($feederno < 0){
		$feederno = 0;
	}

		
		echo'|   <>1<>   |'.$sql_zfeed = "select first 1 skip {$feederno} distinct zno from checked_slctjob('{$jobno2}') group by zno";
		$rs_zfeed = $db->Execute($sql_zfeed);
		$zfeeder = $rs_zfeed->fields[0];
		$rs_zfeed->Close();
		
		$jdate = trim($jdate2);
		$jobno = trim($jobno2);
		
		
		echo'  <>1<>  '.$sql 	= "select first 1 skip {$seq} zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
					 install, checked, ket, zfd_name, zfd_no, zfd_tray, zfd
					from pn_checked('{$jobno}')
					where zfeeder containing '{$zfeeder}'
					and (checked = '' or checked is null)
					order by pos, zfd_no asc";
		$rs			= $db->Execute($sql);
		$checkpart	= $rs->fields[7];
		$rs->Close();
		
		if($checkpart == $get_partnumber){
			
			if($action=="saveChecked"){
				echo'|   <>2<>   |'.$sql2 		= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
								install, checked, ket, zfd_name, zfd_no, zfd_tray, checked_date, checked_time
							from pn_checked('{$jobno}')
							where zfeeder containing '{$zfeeder}' and partnumber = '{$partnumber}'
							and (checked = '' or checked is null)
							order by pos, zfd_no asc";
				$rs2		  = $db->Execute($sql2);
				$exist2	  = $rs2->RecordCount();
				echo'|   <>3<>   |'.$zfeeder11 = $rs2->fields[0];
				echo'|   <>4<>   |'.$pos2 	   = trim($rs2->fields[2]);
				$rs2->Close();
				
				if($exist2 != 0){
					$pos = "";
					if (empty($pos2)){
						$pos = "pos = '{$pos2}' or pos is null";
					}
					else{
						$pos = "pos = '{$pos2}'";
					}
					echo'|   <>5<>   |'.$sql_upd_ins2= "UPDATE jobdetail SET checked = 'OK', checked_nik = '{$picknav_nik}', checked_name = '{$picknav_pic}',
									checked_date = '{$date}', checked_time = '{$time}'
									where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder11}'
									and partnumber = '{$partnumber}' and ($pos);";
					//$rs_upd_ins2 = $db->Execute($sql_upd_ins2);
					//$rs_upd_ins2->Close();
				}
				else{
					echo'|   <>6<>   |'.$sql 		= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
									install,checked, ket, zfd_name, zfd_no, zfd_tray, checked_date, checked_time
								from pn_checked('{$jobno}')
								where zfeeder containing '{$zfeeder}' and partnumber = '{$partnumber}'
								order by pos, zfd_no asc";
					$rs		  = $db->Execute($sql);
					$exist	  = $rs->RecordCount();
					echo'|   <>7<>   |'.$zfeeder3 = $rs->fields[0];
					echo'|   <>8<>   |'.$pos3 	   = trim($rs->fields[2]);
					$rs->Close();
					
					if($exist != 0){
						$pos = "";
						if (empty($pos3)){
							$pos = "pos = '{$pos3}' or pos is null";
						}
						else{
							$pos = "pos = '{$pos3}'";
						}
						echo'|   <>9<>   |'.$$sql_upd_ins= "UPDATE jobdetail SET checked = 'OK', checked_nik = '{$picknav_nik}', checked_name = '{$picknav_pic}',
										checked_date = '{$date}', checked_time = '{$time}'
										where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder3}'
										and partnumber = '{$partnumber}' and ($pos);";
						//$rs_upd_ins = $db->Execute($sql_upd_ins);
						//$rs_upd_ins->Close();
					}
				}
				
			}
			elseif($action == 'cancelChecked'){
				$zfeeder4	= isset($_REQUEST['zfeeder']) ? $_REQUEST['zfeeder'] : '';
				$pos4 = isset($_REQUEST['pos']) ? $_REQUEST['pos'] : '';
				if ($pos4 == ""){
					$pos = "pos = '{$pos4}' or pos is null";
				}
				else{
					$pos = "pos = '{$pos4}'";
				}
				echo'|   <>10<>   |'.$sql_upd_cancel= "UPDATE jobdetail SET checked = null, checked_nik = null, checked_name = null,
								checked_date = null, checked_time = null, cancel_ins_date = '{$date}', cancel_ins_time = '{$time}'
								where jobdate = '{$jdate}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder4}'
								and partnumber = '{$partnumber}' and ($pos);";
				//$rs_upd_cancel = $db->Execute($sql_upd_cancel);
				//$rs_upd_cancel->Close();
			}
		}
$db->Close();
$db=null;
?>