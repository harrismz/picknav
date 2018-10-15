<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik     = isset($_SESSION['picknav_nik'])	  ? $_SESSION['picknav_nik']	: '';
$picknav_pic     = isset($_SESSION['picknav_pic'])	  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno = isset($_SESSION['picknav_levelno'])? $_SESSION['picknav_levelno']: '';

$jobno_chk    = isset($_POST['jobno_chk'])	    ? $_POST['jobno_chk']	: '';
$model_chk    = isset($_POST['model_chk'])	    ? $_POST['model_chk']	: '';
$serial_chk   = isset($_POST['serial_chk'])	    ? $_POST['serial_chk']	: '';
$pwbname_chk  = isset($_POST['pwbname_chk'])	? $_POST['pwbname_chk']	: '';
$proces_chk   = isset($_POST['proces_chk'])	    ? $_POST['proces_chk']	: '';
$jdate_chk    = isset($_POST['jdate_chk'])	    ? $_POST['jdate_chk']	: '';

$sql_chk	 = "select jobid, zno, sts_checked, sts_chk_sname, sts_chk_ename
					from checked_slctjob('{$jobno_chk}')
					group by zno, jobid, sts_checked, sts_chk_sname, sts_chk_ename";
						
$rs_chk      = $db->Execute($sql_chk);
$exist   = $rs_chk->RecordCount();

$no      = 0;

if($exist == 0){ echo'<h4 class="warning" align="center" style="color: red;">Checked Data is not Available</h4>'; }
else{
    echo'<table id="dt_chk_slctjob" class="table table-striped table-hover dt_zfeed col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead align="center">';
			//echo'<th><center><INPUT type="checkbox" onchange="checkAll_install(this)" name="chk[]" /></center></th>';
			echo'<th>NO</th>';
			echo'<th>ACTION</th>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>PIC</th>';
		echo'</thead>';
        echo'<tbody>';
		
		while(!$rs_chk->EOF){
			$no++;
			$jobid      		= trim($rs_chk->fields['0']);
			$zfeeder    		= trim($rs_chk->fields['1']);
			$sts_checked		= trim($rs_chk->fields['2']);
			$sts_chk_sname2		= trim($rs_chk->fields['3']);
			$sts_chk_ename2		= trim($rs_chk->fields['4']);
			
			if (!empty($sts_chk_sname2)){ $sts_chk_sname = $sts_chk_sname2; }
			elseif (!empty($sts_chk_sname2)){ $sts_chk_sname = $sts_chk_ename2; }
			else{ $sts_chk_sname = '<font style="color: red">-</font>'; }
			
			if($sts_checked === "1"){ echo'<tr style="background-color:yellow !important">'; }
			elseif($sts_checked === "2"){ echo'<tr style="background-color:lightgreen !important">'; }
			elseif($sts_checked === "4"){ echo'<tr style="background-color:lightblue !important">'; }
			elseif($sts_checked == ""){ echo'<tr>'; }
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="ACTION">';
				//echo'<td align="center">';
					if($sts_checked === "2"){ echo'<font style="color: green !important; font-size: 15px; font-weight: bold">CLEAR</font>'; }
					elseif($sts_checked === "4"){ echo'<font style="color: red !important; font-size: 15px; font-weight: bold">UNCLEAR</font>'; }
					else{
						echo'<button id="btn_detail" class="btn-detail"  onclick="selectjob_checked('.$no.')">CHECK</button>
						<input type="hidden" name="jobno_checked_slct'.$no.'" id="jobno_checked_slct'.$no.'" value="'.$jobid.'" />
						<input type="hidden" name="zfeeder_checked_slct'.$no.'" id="zfeeder_checked_slct'.$no.'" value="'.$zfeeder.'" />
						<input type="hidden" name="model_checked_slct'.$no.'" id="model_checked_slct'.$no.'" value="'.$model_chk.'" />
						<input type="hidden" name="serial_checked_slct'.$no.'" id="serial_checked_slct'.$no.'" value="'.$serial_chk.'" />
						<input type="hidden" name="pwbname_checked_slct'.$no.'" id="pwbname_checked_slct'.$no.'" value="'.$pwbname_chk.'" />
						<input type="hidden" name="jdate_checked_slct'.$no.'" id="jdate_checked_slct'.$no.'" value="'.$jdate_chk.'" />
						<input type="hidden" name="process_checked_slct'.$no.'" id="process_checked_slct'.$no.'" value="'.$proces_chk.'" />';
					}
				echo'</td>';
				/*echo'<input type="checkbox" name="item[]" id="item[]" value="'.$zfeeder.'" />
					
				</td>';*/
				echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
				echo'<td data-content="PIC">'.$sts_chk_sname.'</td>';
            echo'</tr>';
			$rs_chk->MoveNext();
		}
	echo'</tbody>';
	echo'</table>';
}


$rs_chk->Close();
$db->Close();
$db=null;
?>