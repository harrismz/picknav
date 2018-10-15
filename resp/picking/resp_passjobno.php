<?php
	date_default_timezone_set('Asia/Jakarta');
	include "../adodb/con_part_im.php";
	
    $date    = date("Y-m-d");
    $time    = date('H:i:s');
	
	//call session
    $picknav_pic      = isset($_SESSION['picknav_pic']) 			? $_SESSION['picknav_pic'] 		: '';
    $picknav_levelno  = isset($_SESSION['picknav_levelno']) 		? $_SESSION['picknav_levelno'] 	: '';
    $picknav_disabled = isset($_SESSION['picknav_disabled']) 		? $_SESSION['picknav_disabled'] : '';
    $picknav_nik      = isset($_SESSION['picknav_nik'])  			? $_SESSION['picknav_nik']  	: '';
	
    $jobno	    	  = isset($_REQUEST['jobno']) ? $_REQUEST['jobno'] : '';
    $model	    	  = isset($_REQUEST['model']) ? $_REQUEST['model'] : '';
    $serial	    	  = isset($_REQUEST['serial']) ? $_REQUEST['serial'] : '';

    $sql_upd_pass 	  = "UPDATE jobheaderinfo SET sts_opstart = '3', op_nik = '{$picknav_nik}', op_name = '{$picknav_pic}', op_startdate = '{$date}', op_starttime = '{$time}', op_enddate = '{$date}', op_endtime = '{$time}' where jobno = '{$jobno}'";
	$rs_upd_pass 	  = $db->Execute($sql_upd_pass);
    
	$rs_upd_pass->Close();
	$db->Close();
	$db=null;
	
?>