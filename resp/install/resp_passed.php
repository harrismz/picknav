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
    $jdate	    	  = isset($_REQUEST['jdate']) ? $_REQUEST['jdate'] : '';

    echo $sql_upd_pass 	  = "UPDATE jobheaderinfo adsf SET sts_install = '3', sts_ins_snik = '{$picknav_nik}',
							sts_ins_sname = '{$picknav_pic}', sts_ins_sdate = '{$date}', 
							sts_ins_stime = '{$time}', sts_ins_enik = '{$picknav_nik}',
							sts_ins_ename = '{$picknav_pic}', sts_ins_edate = '{$date}',
							sts_ins_etime = '{$time}' where jobno = '{$jobno}' and jobdate = '{$jdate}'";
	$rs_upd_pass 	  = $db->Execute($sql_upd_pass);
    
	$rs_upd_pass->Close();
	$db->Close();
	$db=null;
	
?>