<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	
    $date    = date("Y-m-d");
    $time    = date('H:i:s');
	$action	 = isset($_GET['action']) ? $_GET['action'] : '';
	
	//call session
    $picknav_pic      = isset($_SESSION['picknav_pic']) 			? $_SESSION['picknav_pic'] 		: '';
    $picknav_levelno  = isset($_SESSION['picknav_levelno']) 		? $_SESSION['picknav_levelno'] 	: '';
    $picknav_disabled = isset($_SESSION['picknav_disabled']) 		? $_SESSION['picknav_disabled'] : '';
    $picknav_nik      = isset($_SESSION['picknav_nik'])  			? $_SESSION['picknav_nik']  	: '';
	
    $dt2	        = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';
    $jobno2	    = isset($_REQUEST['jobno']) ? $_REQUEST['jobno'] : '';
    //$addrs	    = isset(trim($_REQUEST['addrs'])) ? $_REQUEST['addrs'] : '';
    $zfeeder2	= isset($_REQUEST['zfeeder']) ? $_REQUEST['zfeeder'] : '';
    $partnumber2	= isset($_REQUEST['partnumber']) ? $_REQUEST['partnumber'] : '';
	
	$dt = trim($dt2);
	$jobno = trim($jobno2);
	$zfeeder = trim($zfeeder2);
	$partnumber = trim($partnumber2);

	/*SAVE INSTALL*/
	if($action=="saveInstall"){
		$install	= isset($_REQUEST['check_install']) ? $_REQUEST['check_install'] : '';
		
		$sql_upd_ins= "UPDATE jobdetail SET install = '{$install}', install_nik = '{$picknav_nik}', install_name = '{$picknav_pic}',
						install_date = '{$date}', install_time = '{$time}'
						where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'  
						and partnumber = '{$partnumber}';";
		$rs_upd_ins = $db->Execute($sql_upd_ins);
		$rs_upd_ins->Close();
	}
    /*SAVE KET*/
    elseif($action=="saveket"){
		$Ket	= isset($_REQUEST['ket']) ? $_REQUEST['ket'] : '';
		
		$sql_upd_ket= "UPDATE jobdetail SET ket = '{$Ket}', ket_nik = '{$picknav_nik}', ket_name = '{$picknav_pic}', 
						ket_date = '{$date}', ket_time = '{$time}' 
						where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}' 
						and partnumber = '{$partnumber}';";
		$rs_upd_ket = $db->Execute($sql_upd_ket);
		$rs_upd_ket->Close();
	}

	$db->Close();
	$db=null;
	
?>