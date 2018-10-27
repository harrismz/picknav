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
		if(	smt == "2_install"){
			//remove
			$("#dt_detailSP").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_detailSP").addClass("installClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$picknav_pic    = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']  : '';
$jobno          = isset($_POST['jobno']) ? $_POST['jobno'] : '';
$model          = isset($_POST['model']) ? $_POST['model'] : '';
$serial         = isset($_POST['serial']) ? $_POST['serial'] : '';

$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');

$sql 	= "select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
			 install, ket, zfd_name, zfd_no, zfd_tray,
			 install_nik, install_name, install_date, install_time
            from INSTALL_DETAIL('{$jobno}')
            order by install_date||install_time asc";
//            from pn_install('{$jobno}')
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
        echo'<th>INSTALL</th>';
        echo'<th>KET</th>';
    echo'</thead>';
    echo'<tbody>';
    $no = 0;
    while(!$rs->EOF){
        $no++;
		$zfeeder     = $rs->fields['0'];
		$pol         = $rs->fields['1'];
		$pos_val     = $rs->fields['2'];
		$pos1_val    = $rs->fields['3'];
		$w_fs        = $rs->fields['4'];
		$p_sp        = $rs->fields['5'];
		$addrs       = $rs->fields['6'];
		$partnumber  = $rs->fields['7'];
		$point       = $rs->fields['8'];
		$demand      = $rs->fields['9'];
		$install     = $rs->fields['10'];
		$ket         = $rs->fields['11'];
		$zfd_name    = $rs->fields['12'];
		$zfd_no      = $rs->fields['13'];
		$zfd_tray    = $rs->fields['14'];
		$install_nik = $rs->fields['15'];
		$install_name= $rs->fields['16'];
		$install_date= $rs->fields['17'];
		$install_time= $rs->fields['18'];
		$install_time= $rs->fields['18'];
		
		if($pos_val == "" and $pos1_val == ""){ $pos = ''; }
        elseif($pos_val != "" and $pos1_val == ""){ $pos = $pos_val; }
        elseif($pos_val == "" and $pos1_val != ""){ $pos = $pos1_val; }
        elseif($pos_val != "" and $pos1_val != ""){ $pos = $pos_val."(".$pos1_val.")"; }
		
		if($install != ""){ echo'<tr style="background-color:#bdf5bd !important">'; }
		else{ echo'<tr style="color:red !important; font-weight: bold;">'; }
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
			if($install == "OK"){ echo'<td data-content="INSTALL" style="color: green;"> <b>'.$install.'</b> </td>'; }
			else{ echo'<td data-content="INSTALL" style="color: red;"> -- </td>'; }
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