<?php
//start session
ob_start();
session_start();
ob_end_clean();
date_default_timezone_set('Asia/Jakarta');

//	database connection
	include "../../../adodb/con_part_im.php";
	include "../../../adodb/con_smtprosLED.php";
	include "../../../adodb/con_criticalpart.php";

//	call session and post
	$picknav_pic 		= isset($_SESSION['picknav_pic']) ? $_SESSION['picknav_pic'] : '';
	$picknav_levelno    = isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno'] : '';
	$date1 				= date("Y-m-d", strtotime("-7 Day"));
	$date2 				= date('Y-m-d');
	$picknav_nik 		= isset($_POST['nik']) ? $_POST['nik'] : '';
	$get_jobno   		= isset($_POST['jobno']) ? $_POST['jobno'] : '';
//	-- scann -------------------------------------------------------------------------------
	$get_partnumber3  	= isset($_POST['scanpartno']) ? $_POST['scanpartno'] : '';
	$get_partnumber2  	= substr($get_partnumber3, 0, 15);
	$get_partnumber  	= trim($get_partnumber2);
//	-- endof scann -------------------------------------------------------------------------

$feederno1    	= isset($_POST['feederno']) ? $_POST['feederno'] : '';
$feederno 		= intval($feederno1) - 1;
if($feederno < 0){ $feederno = 0; }

$sql_zfeed	= "select first 1 skip {$feederno} distinct zno_ins from diff_zfeeder_install2('{$get_jobno}') group by zno_ins";
$rs_zfeed	= $db->Execute($sql_zfeed);
$zfeed_ins	= $rs_zfeed->fields[0];
$rs_zfeed->Close();

$sql 	= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
				loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
				full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, install, ket, zfd_name, zfd_no, zfd_tray, zfd
            from pn_install('{$get_jobno}')
            where zfeeder containing'{$zfeed_ins}' 
				and partnumber = '{$get_partnumber}'
				and (install = '' or install is null)
			order by zfd_name,zfd_no, install_date, install_time asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();
$rs->Close();

if ($exist == 0){
	$sql 	= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
					loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
					full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, install, ket, zfd_name, zfd_no, zfd_tray, zfd
				from pn_install('{$get_jobno}')
				where zfeeder containing'{$zfeed_ins}' 
					and partnumber containing '{$get_partnumber}'
					and (install = '' or install is null)
				order by zfd_name,zfd_no, install_date, install_time asc";
	$rs		= $db->Execute($sql);
	$exist	= $rs->RecordCount();
	$rs->Close();
}

if($exist == 0){
    ?>
        <h4 class="warning" align="center" style="color: red; font-size: 50px;">PART TIDAK ADA</h4>
		<audio controls autoplay hidden="hidden">
		<source src ="asset/sound/PART_TIDAK_ADA.mp3" type="audio/mp3"></audio>
						
    <?php
}
else{
	
	$sql_checkLED 	= "select count(partno) from [SMTPROS].[dbo].[tblLEDRankPart] where LTRIM(RTRIM(partno)) = '{$get_partnumber}'";
	$rs_LED			= $db_smtpros->Execute($sql_checkLED);
	$exist_LED		= $rs_LED->fields['0'];
	$rs_LED->Close();
	
	$sql_checkLEDScan 	= "select count(barcode) from [SMTPROS].[dbo].[tblLEDRankScan] where LTRIM(RTRIM(barcode)) = '{$get_partnumber3}'";
	$rs_LEDScan			= $db_smtpros->Execute($sql_checkLEDScan);
	$exist_LEDScan		= $rs_LEDScan->fields['0'];
	$rs_LEDScan->Close();
	
	if($exist_LED == 0 and $exist_LEDScan == 0){
		// echo 'BUKAN LED RANK';
		
		$sql 	= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
						loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
						full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, install, ket, zfd_name, zfd_no, zfd_tray, zfd
					from pn_install('{$get_jobno}')
					where zfeeder containing '{$zfeed_ins}'
						and partnumber = '{$get_partnumber}'
					order by zfd_name,zfd_no, install_date, install_time asc";
		$rs		= $db->Execute($sql);
		$exist	= $rs->RecordCount();
		$rs->Close();
		
		echo'<table id="dt_scanInstall" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>POS</th>';
			echo'<th>MACHINE</th>';
			echo'<th>TRAY</th>';
		echo'</thead>';
		echo'<tbody>';
		while(!$rs->EOF){
			$zfeeder 	= trim($rs->fields['0']);
			$pol     	= trim($rs->fields['1']);
			$pos_val 	= trim($rs->fields['2']);
			$pos1_val	= trim($rs->fields['3']);
			
			if($pos_val == "" and $pos1_val == ""){
				$pos = '';
			}
			elseif($pos_val != "" and $pos1_val == ""){
				$pos = $pos_val;
			}
			elseif($pos_val == "" and $pos1_val != ""){
				$pos = $pos1_val;
			}
			elseif($pos_val != "" and $pos1_val != ""){
				$pos = $pos_val."(".$pos1_val.")";
			}
			
			$w_fs             = trim($rs->fields['4']);
			$p_sp             = trim($rs->fields['5']);
			$addrs            = trim($rs->fields['6']);
			$partnumber       = $rs->fields['7'];
			$point            = trim($rs->fields['8']);
			$demand           = trim($rs->fields['9']);
			$loose_reel       = trim($rs->fields['10']);
			$loose_reel_rl    = trim($rs->fields['11']);
			$loose_reel_qty   = trim($rs->fields['12']);
			$loose_reel_blc   = trim($rs->fields['13']);
			$full_reel        = trim($rs->fields['14']);
			$full_reel_rl     = trim($rs->fields['15']);
			$full_reel_qty    = trim($rs->fields['16']);
			$full_reel_qty_blc= trim($rs->fields['17']);
			$install          = trim($rs->fields['18']);
			$ket              = trim($rs->fields['19']);
			$zfd_name2        = trim($rs->fields['20']);
			$zfd_no           = trim($rs->fields['21']);
			$zfd_tray         = trim($rs->fields['22']);
			$zfd	          = trim($rs->fields['23']);
			$zfd_join         = $zfd_name2.'-'.$zfd_no.' #'.$zfd_tray;
			
			if($install!="OK"){
				$zfd_name = $zfd_name2;
			}
			else{
				//echo'<audio controls autoplay hidden="hidden"><source src ="asset/sound/S'.$zfd_no.$pos.'.mp3" type="audio/mp3"></audio>';
				
				$sql_checkscan1 = "Select count(*) from installscan 
									where jobno = '{$get_jobno}'
									and partno containing '{$get_partnumber2}'";
				$rs_checkscan1 = $db->Execute($sql_checkscan1);
				$check1 = $rs_checkscan1->fields[0];
				$rs_checkscan1->Close();
				
				$sql_checkscan = "Select count(*) from installscan 
									where jobno = '{$get_jobno}'
									and partno = '{$get_partnumber3}'";
				$rs_checkscan = $db->Execute($sql_checkscan);
				$check = $rs_checkscan->fields[0];
				$rs_checkscan->Close();
						
				if($check1==0 && $check == 0){
					$zfd_name = $zfd_name2;
				}
				elseif($check1==0 && $check != 0){
					?><script type="text/javascript">alert('this part already exists in other feeder or jobid !');</script><?php
				}
				elseif($check1!=0 && $check == 0){
					$zfd_name = $zfd_name2.' <font style="color:red;background-color:#ffeb3b;">(STOCK)</font>';
				}
				elseif($check1!=0 && $check != 0){
					$sql1 = "Select status from installscan 
										where jobno = '{$get_jobno}'
										and partno = '{$get_partnumber3}'";
					$rs1 = $db->Execute($sql1);
					$status = $rs1->fields[0];
					$rs1->Close();
					
					if($status == 1){
						$zfd_name = $zfd_name2;
					}
					elseif($status == 2){
						$zfd_name = $zfd_name2.' <font style="color:red;background-color:#ffeb3b;">(STOCK)</font>';
					}
				}
			}
			
			if($pos_val == 'L'){
				echo'<tr style="background-color: #000;">';
				echo'<td style="color: #fff;" data-content="Z-FEEDER">'.$zfd.'</td>';
				echo'<td style="color: #fff;" data-content="POS">'.$pos.'</td>';
				echo'<td style="color: #fff;" data-content="MACHINE">'.$zfd_name.'</td>';
				echo'<td style="color: #fff;" data-content="TRAY">'.$zfd_tray.'</td>';
			}
			elseif($pos_val == 'R'){
				echo'<tr style="background-color: #2196f3;">';
				echo'<td style="color: #fff;" data-content="Z-FEEDER">'.$zfd.'</td>';
				echo'<td style="color: #fff;" data-content="POS">'.$pos.'</td>';
				echo'<td style="color: #fff;" data-content="MACHINE">'.$zfd_name.'</td>';
				echo'<td style="color: #fff;" data-content="TRAY">'.$zfd_tray.'</td>';
			}
			else{
				echo'<tr style="background-color: #e0f7fa;">';
				echo'<td style="color: #000;" data-content="Z-FEEDER">'.$zfd.'</td>';
				echo'<td style="color: #000;" data-content="POS">'.$pos.'</td>';
				echo'<td style="color: #000;" data-content="MACHINE">'.$zfd_name.'</td>';
				echo'<td style="color: #000;" data-content="TRAY">'.$zfd_tray.'</td>';
			}
			echo'</tr>';
			
			echo'<audio controls autoplay hidden="hidden"><source src ="asset/sound/'.$zfd_no.$pos.'.mp3" type="audio/mp3"></audio>';
		   $rs->MoveNext();
		}
		echo'</tbody>';
		echo'</table>';

	}
	elseif($exist_LED >= 1 and $exist_LEDScan == 0){
		// echo 'LED BELUM SCAN';
		?>
        <h4 class="warning" align="center" style="color: red; font-size: 50px;">LED NG</h4>
		<audio controls autoplay hidden="hidden">
		<source src ="asset/sound/LED_NG.mp3" type="audio/mp3"></audio>
		<?php
	}
	elseif($exist_LED >= 1 and $exist_LEDScan >= 1){
		//echo 'LED RANK';
		
		$sql 	= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
						loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
						full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, install, ket, zfd_name, zfd_no, zfd_tray, zfd
					from pn_install('{$get_jobno}')
					where zfeeder containing '{$zfeed_ins}'
						and partnumber = '{$get_partnumber}'
					order by zfd_name,zfd_no, install_date, install_time asc";
		$rs		= $db->Execute($sql);
		$exist	= $rs->RecordCount();
		$rs->Close();
		
		echo'<table id="dt_scanInstall" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>POS</th>';
			echo'<th>MACHINE</th>';
			echo'<th>TRAY</th>';
		echo'</thead>';
		echo'<tbody>';
		while(!$rs->EOF){
			$zfeeder 	= trim($rs->fields['0']);
			$pol     	= trim($rs->fields['1']);
			$pos_val 	= trim($rs->fields['2']);
			$pos1_val	= trim($rs->fields['3']);
			
			if($pos_val == "" and $pos1_val == ""){
				$pos = '';
			}
			elseif($pos_val != "" and $pos1_val == ""){
				$pos = $pos_val;
			}
			elseif($pos_val == "" and $pos1_val != ""){
				$pos = $pos1_val;
			}
			elseif($pos_val != "" and $pos1_val != ""){
				$pos = $pos_val."(".$pos1_val.")";
			}
			
			$w_fs             = trim($rs->fields['4']);
			$p_sp             = trim($rs->fields['5']);
			$addrs            = trim($rs->fields['6']);
			$partnumber       = $rs->fields['7'];
			$point            = trim($rs->fields['8']);
			$demand           = trim($rs->fields['9']);
			$loose_reel       = trim($rs->fields['10']);
			$loose_reel_rl    = trim($rs->fields['11']);
			$loose_reel_qty   = trim($rs->fields['12']);
			$loose_reel_blc   = trim($rs->fields['13']);
			$full_reel        = trim($rs->fields['14']);
			$full_reel_rl     = trim($rs->fields['15']);
			$full_reel_qty    = trim($rs->fields['16']);
			$full_reel_qty_blc= trim($rs->fields['17']);
			$install          = trim($rs->fields['18']);
			$ket              = trim($rs->fields['19']);
			$zfd_name2        = trim($rs->fields['20']);
			$zfd_no           = trim($rs->fields['21']);
			$zfd_tray         = trim($rs->fields['22']);
			$zfd	          = trim($rs->fields['23']);
			$zfd_join         = $zfd_name2.'-'.$zfd_no.' #'.$zfd_tray;
			
			if($install!="OK"){
				$zfd_name = $zfd_name2;
			}
			else{
				//echo'<audio controls autoplay hidden="hidden"><source src ="asset/sound/S'.$zfd_no.$pos.'.mp3" type="audio/mp3"></audio>';
				
				$sql_checkscan1 = "Select count(*) from installscan 
									where jobno = '{$get_jobno}'
									and partno containing '{$get_partnumber2}'";
				$rs_checkscan1 = $db->Execute($sql_checkscan1);
				$check1 = $rs_checkscan1->fields[0];
				$rs_checkscan1->Close();
				
				$sql_checkscan = "Select count(*) from installscan 
									where jobno = '{$get_jobno}'
									and partno = '{$get_partnumber3}'";
				$rs_checkscan = $db->Execute($sql_checkscan);
				$check = $rs_checkscan->fields[0];
				$rs_checkscan->Close();
						
				if($check1==0 && $check == 0){
					$zfd_name = $zfd_name2;
				}
				elseif($check1==0 && $check != 0){
					?><script type="text/javascript">alert('this part already exists in other feeder or jobid !');</script><?php
				}
				elseif($check1!=0 && $check == 0){
					$zfd_name = $zfd_name2.' <font style="color:red;background-color:#ffeb3b;">(STOCK)</font>';
				}
				elseif($check1!=0 && $check != 0){
					$sql1 = "Select status from installscan 
										where jobno = '{$get_jobno}'
										and partno = '{$get_partnumber3}'";
					$rs1 = $db->Execute($sql1);
					$status = $rs1->fields[0];
					$rs1->Close();
					
					if($status == 1){
						$zfd_name = $zfd_name2;
					}
					elseif($status == 2){
						$zfd_name = $zfd_name2.' <font style="color:red;background-color:#ffeb3b;">(STOCK)</font>';
					}
				}
			}
			
			if($pos_val == 'L'){
				echo'<tr style="background-color: #000;">';
				echo'<td style="color: #fff;" data-content="Z-FEEDER">'.$zfd.'</td>';
				echo'<td style="color: #fff;" data-content="POS">'.$pos.'</td>';
				echo'<td style="color: #fff;" data-content="MACHINE">'.$zfd_name.'</td>';
				echo'<td style="color: #fff;" data-content="TRAY">'.$zfd_tray.'</td>';
			}
			elseif($pos_val == 'R'){
				echo'<tr style="background-color: #2196f3;">';
				echo'<td style="color: #fff;" data-content="Z-FEEDER">'.$zfd.'</td>';
				echo'<td style="color: #fff;" data-content="POS">'.$pos.'</td>';
				echo'<td style="color: #fff;" data-content="MACHINE">'.$zfd_name.'</td>';
				echo'<td style="color: #fff;" data-content="TRAY">'.$zfd_tray.'</td>';
			}
			else{
				echo'<tr style="background-color: #e0f7fa;">';
				echo'<td style="color: #000;" data-content="Z-FEEDER">'.$zfd.'</td>';
				echo'<td style="color: #000;" data-content="POS">'.$pos.'</td>';
				echo'<td style="color: #000;" data-content="MACHINE">'.$zfd_name.'</td>';
				echo'<td style="color: #000;" data-content="TRAY">'.$zfd_tray.'</td>';
			}
			echo'</tr>';
			
			echo'<audio controls autoplay hidden="hidden"><source src ="asset/sound/'.$zfd_no.$pos.'.mp3" type="audio/mp3"></audio>';
		   $rs->MoveNext();
		}
		echo'</tbody>';
		echo'</table>';
	}
	
}

$db->Close();
$db_smtpros->Close();
$conn->Close();
?>