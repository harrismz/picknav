<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik    = isset($_SESSION['picknav_nik']) ? $_SESSION['picknav_nik'] : '';
$picknav_pic    = isset($_SESSION['picknav_pic']) ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$jobno_chk      = isset($_POST['jobno_chk']) ? $_POST['jobno_chk'] : '';
$zfeed_chk      = isset($_POST['zfeed_chk'])  ? $_POST['zfeed_chk'] : '';
$model_chk      = isset($_POST['model_chk']) ? $_POST['model_chk'] : '';
$serial_chk     = isset($_POST['serial_chk']) ? $_POST['serial_chk'] : '';
$pwbname_chk    = isset($_POST['pwbname_chk']) ? $_POST['pwbname_chk'] : '';
$process_chk    = isset($_POST['process_chk']) ? $_POST['process_chk'] : '';
$jdate_chk      = isset($_POST['jdate_chk']) ? $_POST['jdate_chk'] : '';
  
$sql1        = "SELECT COUNT(*) FROM (
				select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand, install,
				ket, install_nik,install_name, install_date, install_time, zfd_name, zfd_no, zfd_tray
				from pn_checked('{$jobno_chk}')
				where zfeeder containing '{$zfeed_chk}'
			)";        
$rs1	     = $db->Execute($sql1);
$exist1      = $rs1->RecordCount();
$tot_zfeeder = $rs1->fields['0'];

$sql2        = "select jobdate, jobtime, jobfile, jobmc_program,
                       jobmodelname, jobpwbno, jobmetalmask, jobfirstpoint,
                       jobpwbsize, jobefflot, jobblockjig, jobmcrh,
                       jobline, joblotsize, jobstartserial, jobaltno
                from jobheaderinfo
                where jobno = '{$jobno_chk}'";        
$rs2	     = $db->Execute($sql2);
$exist2      = $rs2->RecordCount();
$jobdate        = $rs2->fields['0'];
$jobtime        = $rs2->fields['1'];
$jobfile        = trim($rs2->fields['2']);
$jobmc_program  = trim($rs2->fields['3']);
$jobmodelname   = trim($rs2->fields['4']);
$jobpwbno       = trim($rs2->fields['5']);
$jobmetalmask   = trim($rs2->fields['6']);
$jobfirstpoint  = trim($rs2->fields['7']);
$jobpwbsize     = trim($rs2->fields['8']);
$jobefflot      = trim($rs2->fields['9']);
$jobblockjig    = trim($rs2->fields['10']);
$jobmcrh        = trim($rs2->fields['11']);
$jobline        = trim($rs2->fields['12']);
$joblotsize     = trim($rs2->fields['13']);
$jobstartserial = trim($rs2->fields['14']);
$jobaltno       = trim($rs2->fields['15']);

if($exist1 == 0 or $exist2 == 0){
    echo'<h4 class="warning" align="center" style="color: red;">No Loading List Data</h4>';
}
elseif($tot_zfeeder == 0){
	echo"<script type='text/javascript'>";
	echo"alert('This data was finished, Call Administrator to access this data..!');";
	echo"dismismodal();";
	echo"</script>";
	
}
else{
    echo'<table ID="dt_detaillist" class="table table-hover col-xs-12 col-sm-12 col-md-12 col-lg-12">';
        echo'<tr><td class="info">OPERATOR NAME</td><td>'.$picknav_pic.'</td></tr>';
        echo'<tr><td class="info">TOTAL ZFEEDER</td><td>'.$tot_zfeeder.'</td></tr>';
        echo'<tr><td class="info">DATE</td><td>'.$jobdate.'-'.$jobtime.'</td></tr>';
        echo'<tr><td class="info">FILE</td><td>'.$jobfile.'</td></tr>';
        echo'<tr><td class="info">M/C PROGRAM</td><td>'.$jobmc_program.'</td></tr>';
        echo'<tr><td class="info">MODEL</td><td>'.$jobmodelname.'</td></tr>';
        echo'<tr><td class="info">BOARD NO</td><td>'.$jobpwbno.'</td></tr>';
        echo'<tr><td class="info">METAL MASK</td><td>'.$jobmetalmask.'</td></tr>';
        echo'<tr><td class="info">1ST POINT</td><td>'.$jobfirstpoint.'</td></tr>';
        echo'<tr><td class="info">PWB SIZE</td><td>'.$jobpwbsize.'</td></tr>';
        echo'<tr><td class="info">EFECTIVE LOT</td><td>'.$jobefflot.'</td></tr>';
        echo'<tr><td class="info">BLOCK JIG</td><td>'.$jobblockjig.'</td></tr>';
        echo'<tr><td class="info">MACHINE (RH)</td><td>'.$jobmcrh.'</td></tr>';
        echo'<tr><td class="info">LINE</td><td>'.$jobline.'</td></tr>';
        echo'<tr><td class="info">LOT SIZE</td><td>'.$joblotsize.'</td></tr>';
        echo'<tr><td class="info">S. SERIAL</td><td>'.$jobstartserial.'</td></tr>';
        echo'<tr><td class="info">ALT NO</td><td>'.$jobaltno.'</td></tr>';
    echo'</table>';
}

/**------***end run query ***--------**/

$rs1->Close();
$rs2->Close();
$db->Close();
$db=null;
?>