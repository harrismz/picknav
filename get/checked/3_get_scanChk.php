<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../../../adodb/con_part_im.php";
//call session
$picknav_pic = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno    = isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']		: '';

$picknav_nik = isset($_POST['nik_chkd'])   ? $_POST['nik_chkd']	: '';
$get_jobno   = isset($_POST['jobno_chkd']) ? $_POST['jobno_chkd']	: '';
$seq     	 = isset($_POST['seq']) ? $_POST['seq']	: '';
//-- for scann -----------
$get_partnumber2  = isset($_POST['scanpartno_chkd']) ? $_POST['scanpartno_chkd']	: '';
$get_partnumber  = trim($get_partnumber2);
//-- for scann -----------
$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');

$feederno1    	 = isset($_POST['feederno']) 		  ? $_POST['feederno'] 		: '';
$feederno 		 = intval($feederno1) - 1;

if($feederno < 0){ $feederno = 0; }

$sql_zfeed = "select first 1 skip {$feederno} distinct zno from checked_slctjob('{$get_jobno}') group by zno";
$rs_zfeed = $db->Execute($sql_zfeed);
$zfeed_ins = $rs_zfeed->fields[0];
$rs_zfeed->Close();

$sql 	= "select first 1 skip {$seq} zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
				 install, checked, ket, zfd_name, zfd_no, zfd_tray, zfd
				from pn_checked('{$get_jobno}')
				where zfeeder containing '{$zfeed_ins}'
				and (checked = '' or checked is null)
				order by pos, zfd_no asc";
	$rs			= $db->Execute($sql);
	$checkpart	= $rs->fields[7];
	$rs->Close();
	

if(trim($checkpart) == trim($get_partnumber)){
	$sql 	= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
				 install, checked, ket, zfd_name, zfd_no, zfd_tray, zfd
				from pn_checked('{$get_jobno}')
				where zfeeder containing '{$zfeed_ins}' and partnumber = '{$get_partnumber}'
				and (checked = '' or checked is null)
				order by pos, zfd_no asc";
	$rs		= $db->Execute($sql);
	$exist	= $rs->RecordCount();
	$rs->Close();

	if($exist == 0){
		?>
			<h4 class="warning" align="center" style="color: red; font-size: 50px;">PART SALAH</h4>
			<audio controls autoplay hidden="hidden">
			<source src ="asset/sound/PART_SALAH.mp3" type="audio/mp3"></audio>
							
		<?php
	}
	else{
		echo'<table id="dt_scanChecked" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>POS</th>';
			echo'<th>MACHINE</th>';
			echo'<th>TRAY</th>';
		echo'</thead>';
		echo'<tbody>';
		while(!$rs->EOF){
			$zfeeder = trim($rs->fields['0']);
			$pol     = trim($rs->fields['1']);
			$pos_val = trim($rs->fields['2']);
			$pos1_val= trim($rs->fields['3']);
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
			$install          = trim($rs->fields['10']);
			$checked          = trim($rs->fields['11']);
			$ket              = trim($rs->fields['12']);
			$zfd_name2         = trim($rs->fields['13']);
			$zfd_no           = trim($rs->fields['14']);
			$zfd_tray         = trim($rs->fields['15']);
			$zfd	          = trim($rs->fields['16']);
			$zfd_join         = $zfd_name2.'-'.$zfd_no.' #'.$zfd_tray;
			
			if($install!="OK"){
				$zfd_name = $zfd_name2;
			}
			else{
				$zfd_name = $zfd_name2.' <font style="color:red;background-color:#ffeb3b;">(STOCK)</font>';
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
			
			echo'<audio controls autoplay hidden="hidden"><source src ="asset/sound/'.$zfd.$pos.'.mp3" type="audio/mp3"></audio>';
		   $rs->MoveNext();
		}
		echo'</tbody>';
		echo'</table>';
	}
}
else{
	?>
		<h4 class="warning" align="center" style="color: red; font-size: 50px;">PART SALAH</h4>
		<audio controls autoplay hidden="hidden">
		<source src ="asset/sound/PART_SALAH.mp3" type="audio/mp3"></audio>
						
	<?php
}

$rs->Close();
$db->Close();
$db=null;
?>