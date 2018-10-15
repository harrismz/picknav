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
	
    $dt	        = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';
    $jobno	    = isset($_REQUEST['jobno']) ? $_REQUEST['jobno'] : '';
    $addrs	    = isset($_REQUEST['addrs']) ? $_REQUEST['addrs'] : '';
    $zfeeder	= isset($_REQUEST['zfeeder']) ? $_REQUEST['zfeeder'] : '';
    $partnumber	= isset($_REQUEST['partnumber']) ? $_REQUEST['partnumber'] : '';


	/*SAVE LOOSE REEL*/
	if($action=="saveloosereel"){
		echo '  --0-- '.$loose_reel	= isset($_REQUEST['check_LooseReel']) ? $_REQUEST['check_LooseReel'] : '';
		if($loose_reel == "DEL"){
			echo '  --1-- '.$sql_upd_loose= "UPDATE jobdetail SET loose_reel = null, loose_nik = '{$picknav_nik}', loose_name = '{$picknav_pic}',
							loose_date = '{$date}', loose_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
							picking_date = '{$date}', picking_time = '{$time}'
							where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'
							and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
			$rs_upd_loose = $db->Execute($sql_upd_loose);
			$rs_upd_loose->Close();
		}
		else{
			echo '  --2-- '.$sql_upd_loose= "UPDATE jobdetail SET loose_reel = '{$loose_reel}', loose_nik = '{$picknav_nik}', loose_name = '{$picknav_pic}',
						loose_date = '{$date}', loose_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
						picking_date = '{$date}', picking_time = '{$time}'
						where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'
						and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
			$rs_upd_loose = $db->Execute($sql_upd_loose);
			$rs_upd_loose->Close();
		}
		
		
	}

    /*SAVE LOOSE REEL RL*/
	elseif($action=="saveloose_rl"){
		echo '  --3-- '.$loosereel_val	= isset($_REQUEST['loosereel_val']) ? $_REQUEST['loosereel_val'] : '';
		
		echo '  --4-- '.$sql_upd_loose_rl= "UPDATE jobdetail SET loose_reel_rl = '{$loosereel_val}', loose_nik = '{$picknav_nik}', loose_name = '{$picknav_pic}',
							loose_date = '{$date}', loose_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
							picking_date = '{$date}', picking_time = '{$time}' 
							where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'
							and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
		$rs_upd_loose_rl = $db->Execute($sql_upd_loose_rl);
		$rs_upd_loose_rl->Close();
	}
	/*SAVE LOOSE REEL qty and balance*/
	elseif($action=="saveloose_qty"){
		echo '  --5-- '.$looseqty_val	= isset($_REQUEST['looseqty_val']) ? $_REQUEST['looseqty_val'] : '';
		
		echo '  --6-- '.$sql_upd_loose= "UPDATE jobdetail SET loose_reel_qty = '{$looseqty_val}', loose_nik = '{$picknav_nik}', loose_name = '{$picknav_pic}',
						loose_date = '{$date}', loose_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
						picking_date = '{$date}', picking_time = '{$time}' 
						where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}' 
						and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
		$rs_upd_loose = $db->Execute($sql_upd_loose);
		$rs_upd_loose->Close();
	}

    /*SAVE FULL REEL*/
    elseif($action=="savefullreel"){
		echo '  --7-- '.$full_reel	= isset($_REQUEST['check_FullReel']) ? $_REQUEST['check_FullReel'] : '';
		if($full_reel == "DEL"){
			echo '  --8-- '.$sql_upd_full= "UPDATE jobdetail SET full_reel = null, full_nik = '{$picknav_nik}', full_name = '{$picknav_pic}',
							full_date = '{$date}', full_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
							picking_date = '{$date}', picking_time = '{$time}'
							where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'  
							and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
			$rs_upd_full = $db->Execute($sql_upd_full);
			$rs_upd_full->Close();

		}
		else{
			echo '  --9-- '.$sql_upd_full= "UPDATE jobdetail SET full_reel = '{$full_reel}', full_nik = '{$picknav_nik}', full_name = '{$picknav_pic}',
							full_date = '{$date}', full_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
							picking_date = '{$date}', picking_time = '{$time}'
							where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'  
							and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
			$rs_upd_full = $db->Execute($sql_upd_full);
			$rs_upd_full->Close();
		}
	}
	
	/*SAVE FULL REEL RL*/
	elseif($action=="savefull_rl"){
		echo '  --11-- '.$fullreel_val	= isset($_REQUEST['fullreel_val']) ? $_REQUEST['fullreel_val'] : '';
		
		echo '  --12-- '.$sql_upd_full_rl= "UPDATE jobdetail SET full_reel_rl = '{$fullreel_val}', full_nik = '{$picknav_nik}', full_name = '{$picknav_pic}',
							full_date = '{$date}', full_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
							picking_date = '{$date}', picking_time = '{$time}'
							where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}' 
							and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
		$rs_upd_full_rl = $db->Execute($sql_upd_full_rl);
		$rs_upd_full_rl->Close();
	}
	/*SAVE FULL REEL qty and balance*/
	elseif($action=="savefull_qty"){
		echo '  --13-- '.$fullqty_val	= isset($_REQUEST['fullqty_val']) ? $_REQUEST['fullqty_val'] : '';
		
		echo '  --14-- '.$sql_upd_full= "UPDATE jobdetail SET full_reel_qty = '{$fullqty_val}', full_nik = '{$picknav_nik}', full_name = '{$picknav_pic}',
						full_date = '{$date}', full_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
						picking_date = '{$date}', picking_time = '{$time}'
						where jobdate = '{$dt}' and jobno = '{$jobno}' and zfeeder = '{$zfeeder}'
						and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
		$rs_upd_full = $db->Execute($sql_upd_full);
		$rs_upd_full->Close();
	}

    /*SAVE KET*/
    elseif($action=="saveket"){
		echo '  --15-- '.$Ket	= isset($_REQUEST['ket']) ? $_REQUEST['ket'] : '';
		
		echo '  --16-- '.$sql_upd_ket= "UPDATE jobdetail SET ket = '{$Ket}', ket_nik = '{$picknav_nik}', ket_name = '{$picknav_pic}',
						ket_date = '{$date}', ket_time = '{$time}', picking_nik = '{$picknav_nik}', picking_name = '{$picknav_pic}',
						picking_date = '{$date}', picking_time = '{$time}'
						where jobdate = '{$dt}' and jobno = '{$jobno}'
						and zfeeder = '{$zfeeder}'  and partnumber = '{$partnumber}' and addrs containing '{$addrs}';";
		$rs_upd_ket = $db->Execute($sql_upd_ket);
		$rs_upd_ket->Close();
	}

	$db->Close();
	$db=null;
	
?>