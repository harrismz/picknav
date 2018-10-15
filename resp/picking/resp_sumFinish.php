<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	
    date_default_timezone_set('Asia/Jakarta');

    $date    = date("Y-m-d");
    $time    = date('H:i:s');
	$action	 = isset($_GET['action']) ? $_GET['action'] : '';
	
	//call session
    $picknav_pic      = isset($_SESSION['picknav_pic']) 			? $_SESSION['picknav_pic'] 		: '';
    $picknav_levelno  = isset($_SESSION['picknav_levelno']) 		? $_SESSION['picknav_levelno'] 	: '';
    $picknav_disabled = isset($_SESSION['picknav_disabled']) 		? $_SESSION['picknav_disabled'] : '';
    $picknav_nik      = isset($_SESSION['picknav_nik'])  			? $_SESSION['picknav_nik']  	: '';
	
    $dt	        = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';
    $jobno	    = isset($_REQUEST['jobno']) ? $_REQUEST['jobno'] : '';
    $addrs	    = isset($_REQUEST['addrs']) ? $_REQUEST['addrs'] : '';
    $zfeeder	= isset($_REQUEST['zfeeder']) ? $_REQUEST['zfeeder'] : '';
    $partnumber	= isset($_REQUEST['partnumber']) ? $_REQUEST['partnumber'] : '';


	/*SAVE LOOSE REEL*/
	if($action=="saveloosereel"){
		$loose_reel	= isset($_REQUEST['check_LooseReel']) ? $_REQUEST['check_LooseReel'] : '';
		
		$sql_upd_loose= "UPDATE jobdetail SET loose_reel = '{$loose_reel}', loose_nik = '{$picknav_nik}', loose_name = '{$picknav_pic}', loose_date = '{$date}', loose_time = '{$time}' where jobdate = '{$dt}' and jobno = '{$jobno}' and addrs containing '{$addrs}';";
		$rs_upd_loose = $db->Execute($sql_upd_loose);
		$rs_upd_loose->Close();
	}

    /*SAVE FULL REEL*/
    elseif($action=="savefullreel"){
		$full_reel	= isset($_REQUEST['check_FullReel']) ? $_REQUEST['check_FullReel'] : '';
		
		$sql_upd_full= "UPDATE jobdetail SET full_reel = '{$full_reel}', full_nik = '{$picknav_nik}', full_name = '{$picknav_pic}', full_date = '{$date}', full_time = '{$time}' where jobdate = '{$dt}' and jobno = '{$jobno}' and addrs containing '{$addrs}';";
		$rs_upd_full = $db->Execute($sql_upd_full);
		$rs_upd_full->Close();
		
	}

    /*SAVE KET*/
    elseif($action=="saveket"){
		$Ket	= isset($_REQUEST['ket']) ? $_REQUEST['ket'] : '';
		
		$sql_upd_ket= "UPDATE jobdetail SET ket = '{$Ket}', ket_nik = '{$picknav_nik}', ket_name = '{$picknav_pic}', ket_date = '{$date}', ket_time = '{$time}' where jobdate = '{$dt}' and jobno = '{$jobno}' and addrs containing '{$addrs}';";
		$rs_upd_ket = $db->Execute($sql_upd_ket);
		$rs_upd_ket->Close();
	}

	$rs_upd_loose->Close();
	$rs_upd_full->Close();
	$rs_upd_ket->Close();
	$db->Close();
	$db=null;
	
?>