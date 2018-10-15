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
		if(	operator == "loading_list"){
			//remove
			$("#dt_loadlist").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_loadlist").addClass("pickingClick-table");
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
$src_sdate_prepare	= isset($_POST['src_sdate_prepare']) 	? $_POST['src_sdate_prepare'] : '';
$src_edate_prepare	= isset($_POST['src_edate_prepare']) 	? $_POST['src_edate_prepare'] : '';
$src_jobno_prepare	= isset($_POST['src_jobno_prepare']) 	? $_POST['src_jobno_prepare'] : '';

if(empty($src_sdate_prepare) && empty($src_edate_prepare) && empty($src_jobno_prepare)){
	$where = "where a.jobdate = '$date2'
					and (a.sts_opstart is null 
						or a.sts_opstart = '1'
						or a.sts_opstart = '2'
						or a.sts_opstart = '4'
						or a.sts_opstart = '5')";
}
elseif(empty($src_sdate_prepare) && empty($src_edate_prepare) && $src_jobno_prepare != ""){
	$where = "where c.jobno like '$src_jobno_prepare%' 
					and ((a.sts_opstart is null) 
						or (a.sts_opstart = '1') 
						or (a.sts_opstart = '2') 
						or (a.sts_opstart = '4')
						or (a.sts_opstart = '5'))";
}
elseif($src_sdate_prepare !="" && $src_edate_prepare !="" && empty($src_jobno_prepare)){
	$where = "where a.jobdate>='$src_sdate_prepare' 
					and  a.jobdate<='$src_sdate_prepare' 
					and ((a.sts_opstart is null) 
						or (a.sts_opstart = '1') 
						or (a.sts_opstart = '2') 
						or (a.sts_opstart = '4')
						or (a.sts_opstart = '5'))";
}
else{
	$where = "where a.jobdate>='$src_sdate_prepare' 
					and  a.jobdate<='$src_sdate_prepare'
					and c.jobno like '$src_jobno_prepare%'
					and ((a.sts_opstart is null)
						or (a.sts_opstart = '1') 
						or (a.sts_opstart = '2') 
						or (a.sts_opstart = '4')
						or (a.sts_opstart = '5'))";
}
	
	$sql 		=  "select distinct a.jobno,a.jobdate,a.jobtime,a.jobline,b.model,b.pwb_name,
						a.jobpwbno,b.process, b.start_serial, b.lot, c.picname, a.op_name, a.sts_opstart
						from jobheaderinfo a
							left join jobmodel b on a.jobno=b.jobno
							left join joblist c on a.jobno=c.jobno
                        $where 
						order by a.sts_opstart asc, (a.jobdate||a.jobtime) desc ";
						//order by a.jobdate, a.jobtime desc
	$rs			= $db->Execute($sql);
	$exist		= $rs->RecordCount();
	
	if($exist == 0){ ?> <h4 class="warning" align="center" style="color: red;">No Joblist Data</h4> <?php }
	else{
		echo'<table id="dt_loadlist" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<th>NO</th>';
			echo'<th>ACTION</th>';
			echo'<th>JOB NO.</th>';
			echo'<th>DATE</th>';
			echo'<th>LINE</th>';
			echo'<th>MODEL NAME</th>';
			//echo'<th>PWB NAME</th>';
			echo'<th>PROCESS</th>';
			echo'<th>PWB NO.</th>';
			echo'<th hidden="true">PROCESS</th>';
			echo'<th>START SERIAL</th>';
			echo'<th>LOT SIZE</th>';
			echo'<th>PIC</th>';
			echo'<th>OPERATOR</th>';
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
			$picname       = trim($rs->fields['10']);
			$opname1	   = trim($rs->fields['11']);	
			$sts_opstart   = trim($rs->fields['12']);
            $jdate         = trim($rs->fields['1']);
			
			$pwb_name1 = trim($pwb_name);
			if(empty($pwb_name1)){
				$pwb_name = $process;
			}
			else{
				$pwb_name = $pwb_name1.' / '.$process;
			}
			
			if($opname1 == ""){$opname = '<font style="color: gray">-</font>';}
			else{$opname = $opname1;}
            
			
            if($sts_opstart === "1" or $sts_opstart === "5"){ echo'<tr style="background-color:yellow">'; }
			elseif($sts_opstart === "2"){ echo'<tr style="background-color:lightgreen">'; }
			elseif($sts_opstart === "4"){ echo'<tr style="background-color:lightblue">'; }
			elseif($sts_opstart === ""){ echo'<tr">'; }
				echo'<td data-content="NO"><b>'.$no.'.</b></td>';
				echo'<td data-content="ACTION">';
					/*if($sts_opstart === "1" or $sts_opstart === "5"){
						//echo'<button id="btn_detail" class="btn-detail" onclick="tes('.$no.')">START</button>';
						echo'<button id="btn_detail" class="btn-detail" onclick="popupJobDetail('.$no.')">START</button>
						<input type="hidden" name="jobno1'.$no.'" id="jobno1'.$no.'" value="'.$jobno.'" />
						<input type="hidden" name="jdate1'.$no.'" id="jdate1'.$no.'" value="'.$jdate.'" />
						<input type="hidden" name="model1'.$no.'" id="model1'.$no.'" value="'.$jobmodelname.'" />
						<input type="hidden" name="serial1'.$no.'" id="serial1'.$no.'" value="'.$jobstartserial.'" />
						<input type="hidden" name="pwbname1'.$no.'" id="pwbname1'.$no.'" value="'.$pwb_name.'" />
						<input type="hidden" name="proces1'.$no.'" id="proces1'.$no.'" value="'.$process.'" />';
					}
					else*/
					if($sts_opstart === "2"){ echo'<font style="color: green; font-size: 15px; font-weight: bold">CLEAR</font>'; }
					elseif($sts_opstart === "4"){ echo'<font style="color: red; font-size: 15px; font-weight: bold">UNCLEAR</font>'; }
					else{ 
						//echo'<button id="btn_detail" class="btn-detail" onclick="tes('.$no.')">START</button>';
						echo'<button id="btn_detail" class="btn-detail" onclick="popupJobDetail('.$no.')">START</button>
                        <input type="hidden" name="jobno1'.$no.'" id="jobno1'.$no.'" value="'.$jobno.'" />
                        <input type="hidden" name="jdate1'.$no.'" id="jdate1'.$no.'" value="'.$jdate.'" />
                        <input type="hidden" name="model1'.$no.'" id="model1'.$no.'" value="'.$jobmodelname.'" />
                        <input type="hidden" name="serial1'.$no.'" id="serial1'.$no.'" value="'.$jobstartserial.'" />
                        <input type="hidden" name="pwbname1'.$no.'" id="pwbname1'.$no.'" value="'.$pwb_name.'" />
                        <input type="hidden" name="proces1'.$no.'" id="proces1'.$no.'" value="'.$process.'" />';
					}
				echo'</td>';
				echo'<td data-content="JOB NO." id="job">'.$jobno.'</td>';
				echo'<td data-content="DATE">'.$jobdate.' ('.$jobtime.')</td>';
				echo'<td data-content="LINE">'.$jobline.'</td>';
				echo'<td data-content="MODEL NAME">'.$jobmodelname.'</td>';
				//echo'<td data-content="PWB NAME">'.$pwb_name.'</td>';
				echo'<td data-content="PROCESS">'.$pwb_name.'</td>';
				echo'<td data-content="PWB NO.">'.$jobpwbno.'</td>';
				echo'<td data-content="PROCESS" hidden="true">'.$process.'</td>';
				echo'<td data-content="START SERIAL">'.$jobstartserial.'</td>';
				echo'<td data-content="LOT SIZE">'.$joblotsize.'</td>';
				echo'<td data-content="PIC">'.$picname.'</td>';
				echo'<td data-content="OPERATOR"><b>'.$opname.'</b></td>';
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