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
		if(	operator == "2_install_data"){
			//remove
			$("#dt_installdata").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_installdata").addClass("installClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$date2 = date('Y-m-d');
$picknav_nik      	= isset($_SESSION['picknav_nik'])    	? $_SESSION['picknav_nik']   : '';
$picknav_pic      	= isset($_SESSION['picknav_pic'])    	? $_SESSION['picknav_pic']   : '';
$picknav_levelno  	= isset($_SESSION['picknav_levelno'])	? $_SESSION['picknav_levelno'] : '';
$src_sdate_install	= isset($_POST['src_sdate_install']) 	? $_POST['src_sdate_install'] : '';
$src_edate_install	= isset($_POST['src_edate_install']) 	? $_POST['src_edate_install'] : '';
$src_jobno_install	= isset($_POST['src_jobno_install']) 	? $_POST['src_jobno_install'] : '';

if(empty($src_sdate_install) && empty($src_edate_install) && empty($src_jobno_install)){
	$where = "where a.jobdate = '$date2' and (a.sts_opstart is not null
		or jobline containing 'JAR')";
}
elseif(empty($src_sdate_install) && empty($src_edate_install) && $src_jobno_install != ""){
	$where = "where c.jobno containing '$src_jobno_install' and (a.sts_opstart is not null
		or jobline containing 'JAR')";
}
elseif($src_sdate_install !="" && $src_edate_install !="" && empty($src_jobno_install)){
	$where = "where a.jobdate>='$src_sdate_install' and  a.jobdate<='$src_edate_install' and (a.sts_opstart is not null
		or jobline containing 'JAR')";
}
else{
	$where = "where a.jobdate>='$src_sdate_install' and  a.jobdate<='$src_edate_install' and c.jobno containing '$src_jobno_install' and (a.sts_opstart is not null
		or jobline containing 'JAR')";
}
	
	echo $sql 		= "select distinct c.jobno,a.jobdate,a.jobtime,a.jobline,a.jobmodelname,b.pwb_name,a.jobpwbno,b.process,
                    a.jobstartserial,a.joblotsize, a.jobfile, c.picname, a.op_name, a.sts_opstart, a.sts_install, sts_ins_sname, sts_ins_ename
                     from jobheaderinfo a
                      left join jobmodel b on a.jobno=b.jobno
                       left join joblist c on a.jobno=c.jobno
                        $where 
						order by a.jobdate, a.jobtime desc";
	$rs			= $db->Execute($sql);
	$exist		= $rs->RecordCount();
	
	if($exist == 0){ ?> <h4 class="warning" align="center" style="color: red;">No Install Data</h4> <?php }
	else{
		echo'<table id="dt_installdata" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<tr>';
				echo'<th rowspan="2">NO</th>';
				echo'<th rowspan="2">ACTION</th>';
				echo'<th rowspan="2">JOB NO.</th>';
				echo'<th rowspan="2">DATE</th>';
				echo'<th rowspan="2">LINE</th>';
				echo'<th rowspan="2">MODEL NAME</th>';
				echo'<th rowspan="2">PROCESS</th>';
				echo'<th rowspan="2">PWB NO.</th>';
				echo'<th rowspan="2"hidden="true">PROCESS</th>';
				echo'<th rowspan="2">START SERIAL</th>';
				echo'<th rowspan="2">LOT SIZE</th>';
				echo'<th rowspan="2">FILE</th>';
			echo'<th colspan="3">PIC NAME</th>';
			echo'</tr>';
			echo'<tr>';
				echo'<th class="th2-1">PIC</th>';
				echo'<th class="th2-2">PREPARE</th>';
				echo'<th class="th2-3">INSTALL</th>';
			echo'</tr>';
		echo'</thead>';
        echo'<tbody>';
		$no = 0;
		
		while(!$rs->EOF){
			$no++;
			$jobno         = trim($rs->fields['0']);
			$jobdate       = date_format(date_create($rs->fields['1']), 'd M Y');
			$jobtime       = date_format(date_create($rs->fields['2']), 'H:i');
			$jobline       = trim($rs->fields['3']);
			$jobmodelname  = trim($rs->fields['4']);
			$pwb_name      = trim($rs->fields['5']);
			$jobpwbno      = trim($rs->fields['6']);
			$process       = trim($rs->fields['7']);
			$jobstartserial= trim($rs->fields['8']);
			$joblotsize    = trim($rs->fields['9']);
			$jobfile	   = trim($rs->fields['10']);
			$picname       = trim($rs->fields['11']);
			$opname1	   = trim($rs->fields['12']);	
			$sts_opstart   = trim($rs->fields['13']);
			$sts_install   = trim($rs->fields['14']);
			$sts_sname	   = trim($rs->fields['15']);
			$sts_ename     = trim($rs->fields['16']);
            $jdate         = trim($rs->fields['1']);
			
			if($opname1 == ""){$opname = '<font style="color: red">NO DATA</font>';}
			else{$opname = $opname1;}
            
			$pwb_name1 = trim($pwb_name);
			if(empty($pwb_name1)){
				$pwb_name = $process;
			}
			else{
				$pwb_name = $pwb_name1.' / '.$process;
			}
			
            if($sts_install === "1" or $sts_install === "5"){ echo'<tr style="background-color:yellow !important">'; }
			elseif($sts_install === "2"){ echo'<tr style="background-color:lightgreen !important">'; }
			elseif($sts_install === "4"){ echo'<tr style="background-color:lightblue !important">'; }
			elseif($sts_install === ""){ echo'<tr style="background-color:#f7f7f7 !important">'; }
				echo'<td data-content="NO"><b>'.$no.'.</b></td>';
				echo'<td data-content="ACTION">';
					if($sts_install === "2"){ echo'<font style="color: green !important; font-size: 15px; font-weight: bold">CLEAR</font>'; }
					elseif($sts_install === "4"){ echo'<font style="color: red !important; font-size: 15px; font-weight: bold">UNCLEAR</font>'; }
					else{
						echo'<button id="btn_detail" class="btn-detail" onclick="popupInstall('.$no.')">START</button>
						<input type="hidden" name="jobno_install'.$no.'" id="jobno_install'.$no.'" value="'.$jobno.'" />
						<input type="hidden" name="jdate_install'.$no.'" id="jdate_install'.$no.'" value="'.$jdate.'" />
						<input type="hidden" name="model_install'.$no.'" id="model_install'.$no.'" value="'.$jobmodelname.'" />
						<input type="hidden" name="serial_install'.$no.'" id="serial_install'.$no.'" value="'.$jobstartserial.'" />
						<input type="hidden" name="pwbname_install'.$no.'" id="pwbname_install'.$no.'" value="'.$pwb_name.'" />
						<input type="hidden" name="process_install'.$no.'" id="process_install'.$no.'" value="'.$process.'" />';
					}
				echo'</td>';
				echo'<td data-content="JOB NO." id="job">'.$jobno.'</td>';
				echo'<td data-content="DATE">'.$jobdate.' ('.$jobtime.')</td>';
				echo'<td data-content="LINE">'.$jobline.'</td>';
				echo'<td data-content="MODEL NAME">'.$jobmodelname.'</td>';
				echo'<td data-content="PROCESS">'.$pwb_name.'</td>';
				echo'<td data-content="PWB NO.">'.$jobpwbno.'</td>';
				echo'<td data-content="PROCESS" hidden="true" >'.$process.'</td>';
				echo'<td data-content="START SERIAL">'.$jobstartserial.'</td>';
				echo'<td data-content="LOT SIZE">'.$joblotsize.'</td>';
				echo'<td data-content="FILE">'.$jobfile.'</td>';
				echo'<td data-content="PIC">'.$picname.'</td>';
				echo'<td data-content="PREPARE">'.$opname.'</td>';
				echo'<td data-content="INSTALL">'.$sts_sname.'</td>';
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