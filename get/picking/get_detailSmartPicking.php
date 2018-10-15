<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../../../adodb/con_part_im.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
        //color based on menu click
		if(	smt == "smt_picknav"){
			//remove
			$("#dt_detailSP").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_detailSP").addClass("pickingClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$picknav_pic = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno    = isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']		: '';
$jobno   = isset($_POST['jobno']) ? $_POST['jobno']	: '';
$model   = isset($_POST['model']) ? $_POST['model']	: '';
$serial   = isset($_POST['serial']) ? $_POST['serial']	: '';

$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');
/*
$sql 	= "select distinct zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
			loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
			full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, ket
            from jobdetail where jobno = '{$jobno}' order by zfeeder asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();
*/
$sql 	= "select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
			 loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
			 full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, ket
            from pn_picking_admin('{$jobno}')
            order by sts_reel asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();


if($exist == 0){
    ?>
        <h4 class="warning" align="center" style="color: red;">No Joblist Data</h4>
    <?php
}
else{
    echo'<table id="dt_detailSP" align="center" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<thead>';
        echo'<th>NO</th>';
        echo'<th>Z-FEEDER</th>';
        echo'<th hidden="true">POL</th>';
        echo'<th>POS</th>';
        echo'<th hidden="true">W / FS</th>';
        echo'<th hidden="true">P / SP</th>';
        echo'<th>ADDRS</th>';
        echo'<th>PART NUMBER</th>';
        echo'<th hidden="true">POINT</th>';
        echo'<th>DEMAND</th>';
        echo'<th>LOOSE REEL</th>';
        echo'<th>FULL REEL</th>';
        echo'<th>KET</th>';
    echo'</thead>';
    echo'<tbody>';
    $no = 0;
    while(!$rs->EOF){
        $no++;
		$zfeeder           = $rs->fields['0'];
		$pol               = $rs->fields['1'];
		$pos_val           = $rs->fields['2'];
		$pos1_val          = $rs->fields['3'];
		$w_fs              = $rs->fields['4'];
		$p_sp              = $rs->fields['5'];
		$addrs             = $rs->fields['6'];
		$partnumber        = $rs->fields['7'];
		$point             = $rs->fields['8'];
		$demand            = $rs->fields['9'];
		$loose_reel        = $rs->fields['10'];
		$loose_reel_rl     = $rs->fields['11'];
		$loose_reel_qty    = $rs->fields['12'];
		$loose_reel_qty_blc= $rs->fields['13'];
		$full_reel         = $rs->fields['14'];
		$full_reel_rl      = $rs->fields['15'];
		$full_reel_qty     = $rs->fields['16'];
		$full_reel_qty_blc = $rs->fields['17'];
		$ket               = $rs->fields['18'];
		
		if($pos_val == "" and $pos1_val == ""){ $pos = ''; }
        elseif($pos_val != "" and $pos1_val == ""){ $pos = $pos_val; }
        elseif($pos_val == "" and $pos1_val != ""){ $pos = $pos1_val; }
        elseif($pos_val != "" and $pos1_val != ""){ $pos = $pos_val."(".$pos1_val.")"; }
		
		if($loose_reel != "" or $full_reel != ""){ 
			echo'<tr style="background-color:#bdf5bd !important">';
		}
		else{
			echo'<tr style="color:red !important; font-weight: bold;">';
		}
		
		echo'<td data-content="NO">'.$no.'.</td>';
		echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
		echo'<td data-content="POL" hidden="true">'.$pol.'</td>';
		echo'<td data-content="POS">'.$pos.'</td>';
		echo'<td data-content="W / FS" hidden="true">'.$w_fs.'</td>';
		echo'<td data-content="P / SP" hidden="true">'.$p_sp.'</td>';
		echo'<td data-content="ADDRS">'.$addrs.'</td>';
		echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
		echo'<td data-content="POINT" hidden="true">'.$point.'</td>';
		echo'<td data-content="DEMAND">'.$demand.'</td>';
		
		if($loose_reel == "OK"){
			echo'<td data-content="LOOSE REEL" style="color: green;"><b>'.$loose_reel.' / R:'.$loose_reel_rl.'</b></td>';
		}
		elseif($loose_reel == "LIMIT"){
			echo'<td data-content="LOOSE REEL" style="color: red;"><b>'.$loose_reel.' / R:'.$loose_reel_rl.' / Q:'.$loose_reel_qty.'</b></td>';
		}
		else{
			echo'<td data-content="LOOSE REEL" style="color: red;">--</td>';
		}
		if($full_reel == "OK"){
			echo'<td data-content="FULL REEL" style="color: green;"><b>'.$full_reel.' / R:'.$full_reel_rl.'</b></td>';
		}
		elseif($full_reel == "LIMIT"){
			echo'<td data-content="FULL REEL" style="color: red;"><b>'.$full_reel.' / R:'.$full_reel_rl.' / Q:'.$full_reel_qty.'</b></td>';
		}
		else{
			echo'<td data-content="FULL REEL" style="color: red;">--</td>';
		}
		echo'<td data-content="KET">'.$ket.'</td>';
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