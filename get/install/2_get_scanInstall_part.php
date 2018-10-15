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

$picknav_nik = isset($_POST['nik'])   ? $_POST['nik']	: '';
$get_jobno   = isset($_POST['jobno']) ? $_POST['jobno']	: '';
$get_zfeed4  = isset($_POST['zfeed']) ? $_POST['zfeed']	: '';
//-- for scann -----------
$get_partnumber2  = isset($_POST['scanpartno']) ? $_POST['scanpartno']	: '';
$get_partnumber  = trim($get_partnumber2);
//-- for scann -----------
$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');

$get_zfeed3		= str_replace("+"," ",$get_zfeed4);
$get_zfeed2		= str_replace("::","#",$get_zfeed3);
$get_zfeed      = explode("|",$get_zfeed2);
$zfeeder_total  = count($get_zfeed);
$zfeeder_zfd = "";

for($i=0; $i<$zfeeder_total; $i++){
	$zfeeder_feedergroup 	= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."'";
	$zfeeder_zfd 			= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."' or";
}

$sql 	= "select first 1 skip 0 zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
			 loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
			 full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, install, ket, zfd_name, zfd_no, zfd_tray, zfd
            from pn_install('{$get_jobno}')
            where ({$zfeeder_feedergroup}) and partnumber = '{$get_partnumber}'
            order by zfd_name,zfd_no, install_date, install_time asc";
			//and (install is null or install = '')
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

if($exist == 0){
    ?>
        <h4 class="warning" align="center" style="color: red; font-size: 50px;">PART TIDAK ADA</h4>
    <?php
}
else{
	echo'<table id="dt_scanInstall" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
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
		$zfd_name         = trim($rs->fields['20']);
		$zfd_no           = trim($rs->fields['21']);
		$zfd_tray         = trim($rs->fields['22']);
		$zfd	          = trim($rs->fields['23']);
		$zfd_join         = $zfd_name.'-'.$zfd_no.' #'.$zfd_tray;
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
       $rs->MoveNext();
    }
    echo'</tbody>';
    echo'</table>';
}

$rs->Close();
$db->Close();
$db=null;
?>