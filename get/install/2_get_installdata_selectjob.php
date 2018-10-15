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

$jobno_install    = isset($_POST['jobno_install'])	    ? $_POST['jobno_install']	: '';
$model_install    = isset($_POST['model_install'])	    ? $_POST['model_install']	: '';
$serial_install   = isset($_POST['serial_install'])	    ? $_POST['serial_install']	: '';
$pwbname_install  = isset($_POST['pwbname_install'])	? $_POST['pwbname_install']	: '';
$proces_install   = isset($_POST['proces_install'])	    ? $_POST['proces_install']	: '';
$jdate_install    = isset($_POST['jdate_install'])	    ? $_POST['jdate_install']	: '';

$sql_install	 = "select jobid, zno_ins, jobdate, jobtime, sts_opstart, sts_install, sts_ins_startname, sts_ins_endname, 
					sts_ins_startdate, sts_ins_starttime, sts_ins_enddate, sts_ins_endtime
					from diff_zfeeder_install2('{$jobno_install}') 
					group by zno_ins, jobdate, jobtime, sts_install, jobid, sts_opstart, sts_ins_startname, sts_ins_endname, 
					sts_ins_startdate, sts_ins_starttime, sts_ins_enddate, sts_ins_endtime";
$rs_install      = $db->Execute($sql_install);
$exist   = $rs_install->RecordCount();

$no      = 0;

if($exist == 0){ echo'<h4 class="warning" align="center" style="color: red;">No Loading List Data</h4>'; }
else{
    echo'<table id="dt_zfeed_install" class="table table-striped table-hover dt_zfeed col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead align="center">';
			//echo'<th><center><INPUT type="checkbox" onchange="checkAll_install(this)" name="chk[]" /></center></th>';
			echo'<th>NO</th>';
			echo'<th>ACTION</th>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>PIC</th>';
		echo'</thead>';
        echo'<tbody>';
		
		while(!$rs_install->EOF){
			$no++;
			$jobid      		= trim($rs_install->fields['0']);
			$zfeeder    		= trim($rs_install->fields['1']);
			$jobdate    		= date_format(date_create($rs_install->fields['2']), 'd M Y');
			$jobtime    		= date_format(date_create($rs_install->fields['3']), 'H:i');
		    $sts_opstart2		= trim($rs_install->fields['4']);
		    $sts_install2		= trim($rs_install->fields['5']);
			$sts_ins_startname2 = trim($rs_install->fields['6']);
			$sts_ins_endname2 	= trim($rs_install->fields['7']);
			$sts_ins_startdate 	= trim($rs_install->fields['8']);
			$sts_ins_starttime 	= trim($rs_install->fields['9']);
			$sts_ins_enddate 	= trim($rs_install->fields['10']);
			$sts_ins_endtime 	= trim($rs_install->fields['11']);
			
			if (!empty($sts_ins_startname2)){ $sts_ins_startname = $sts_ins_startname2; }
			elseif (!empty($sts_ins_startname2)){ $sts_ins_startname = $sts_ins_endname2; }
			else{ $sts_ins_startname = '<font style="color: red">-</font>'; }
			
			if($sts_install2 === "1"){ echo'<tr style="background-color:yellow !important">'; }
			elseif($sts_install2 === "2"){ echo'<tr style="background-color:lightgreen !important">'; }
			elseif($sts_install2 === "4"){ echo'<tr style="background-color:lightblue !important">'; }
			elseif($sts_install2 == ""){ echo'<tr>'; }
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="ACTION">';
				//echo'<td align="center">';
					if($sts_install2 === "2"){ echo'<font style="color: green !important; font-size: 15px; font-weight: bold">CLEAR</font>'; }
					elseif($sts_install2 === "4"){ echo'<font style="color: red !important; font-size: 15px; font-weight: bold">UNCLEAR</font>'; }
					else{
						echo'<button id="btn_detail" class="btn-detail"  onclick="selectjob_install('.$no.')">START</button>
						<input type="hidden" name="jobno_install_slct'.$no.'" id="jobno_install_slct'.$no.'" value="'.$jobid.'" />
						<input type="hidden" name="zfeeder_install_slct'.$no.'" id="zfeeder_install_slct'.$no.'" value="'.$zfeeder.'" />
						<input type="hidden" name="model_install_slct'.$no.'" id="model_install_slct'.$no.'" value="'.$model_install.'" />
						<input type="hidden" name="serial_install_slct'.$no.'" id="serial_install_slct'.$no.'" value="'.$serial_install.'" />
						<input type="hidden" name="pwbname_install_slct'.$no.'" id="pwbname_install_slct'.$no.'" value="'.$pwbname_install.'" />
						<input type="hidden" name="jdate_install_slct'.$no.'" id="jdate_install_slct'.$no.'" value="'.$jdate_install.'" />
						<input type="hidden" name="process_install_slct'.$no.'" id="process_install_slct'.$no.'" value="'.$proces_install.'" />';
					}
				echo'</td>';
				/*echo'<input type="checkbox" name="item[]" id="item[]" value="'.$zfeeder.'" />
					
				</td>';*/
				echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
				echo'<td data-content="PIC">'.$sts_ins_startname.'</td>';
            echo'</tr>';
			$rs_install->MoveNext();
		}
	echo'</tbody>';
	echo'</table>';
}


$rs_install->Close();
$db->Close();
$db=null;
?>