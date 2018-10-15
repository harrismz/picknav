<?php
//start session
session_start();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../../../adodb/con_part_im.php";

?>
<script type="text/javascript">
	$(document).ready(function(){
        //color based on menu click
		if(	smt == "2_install"){
			//remove
			$("#dt_install").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_install").addClass("installClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$picknav_pic = isset($_SESSION['picknav_pic'])	? $_SESSION['picknav_pic']	: '';
$picknav_levelno    = isset($_SESSION['picknav_levelno'])		? $_SESSION['picknav_levelno']		: '';

$src_sdate   = isset($_POST['src_sdate_instl'])	? $_POST['src_sdate_instl']	: '';
$src_edate   = isset($_POST['src_edate_instl'])	? $_POST['src_edate_instl']	: '';
$src_model   = isset($_POST['src_model_instl'])	? $_POST['src_model_instl']	: '';
$src_lotsize = isset($_POST['src_lotsize_instl'])	? $_POST['src_lotsize_instl']	: '';
$src_jobno   = isset($_POST['src_jobno_instl'])	? $_POST['src_jobno_instl']	: '';

$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');
//$firebird = "(select cast('Now' as date) from rdb$database)";
/**-----------**/
/** run query **/
/**-----------**/

if(empty($src_sdate) && empty($src_edate) && empty($src_model) && empty($src_lotsize) && empty($src_jobno)){		
	
	//---------- no input
	$where2 = "where a.jobdate='{$date2}'";
}
/*------------------------- model ------------------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && empty($src_lotsize) && empty($src_jobno)){	   
	
	//---------- src_model
	$where2 = "where a.jobmodelname containing '$src_model' 
				and a.jobdate>='{$date1}' 
				and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && empty($src_lotsize) && empty($src_jobno)){    
	
	//---------- src_model + date
	$where2 = "where a.jobmodelname containing '$src_model' 
				and a.jobdate>='$src_sdate'
				and  a.jobdate<='$src_edate'";
}
/*------------------------- lotsize ------------------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && empty($src_model) && $src_lotsize != "" && empty($src_jobno)){    
	
	//---------- src_lotsize
	$where2 = "where a.joblotsize = '$src_lotsize' 
				and a.jobdate>='{$date1}' 
				and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && empty($src_model) && $src_lotsize != "" && empty($src_jobno)){    
	
	//---------- src_lotsize + date
	$where2 = "where a.joblotsize = '$src_lotsize' 
				and a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'";
}
/*------------------------- jobno ------------------------------------------------------------------------------**/
elseif(empty($src_sdate) && empty($src_edate) && empty($src_model) && empty($src_lotsize) && $src_jobno != ""){    
	
	//---------- src_jobno
	$where2 = "where c.jobno containing '$src_jobno' 
				and a.jobdate>='{$date1}' 
				and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && empty($src_model) && empty($src_lotsize) && $src_jobno != ""){    
	
	//---------- src_jobno + date
	$where2 = "where c.jobno containing '$src_jobno' 
				and a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'";
}
/*------------------------- model + lotsize ---------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_lotsize != "" && empty($src_jobno)){    
	
	//---------- model + lotsize
	$where2 = "where  a.jobmodelname containing '$src_model' 
				and a.joblotsize = '$src_lotsize' 
				and a.jobdate>='{$date2}' 
				and a.jobdate<='{$date}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_lotsize != "" && empty($src_jobno)){    
	
	//---------- model + lotsize + date
	$where2 = "where  a.jobmodelname containing '$src_model' 
				and  a.joblotsize = '$src_lotsize' 
				and  a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'";
}
/*------------------------- model + src_jobno -------------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && empty($src_lotsize) && $src_jobno != ""){    
	
	//---------- model + src_jobno
	$where2 = "where  a.jobmodelname containing '$src_model' 
					and c.jobno containing '$src_jobno'
					and a.jobdate>='{$date2}' 
					and a.jobdate<='{$date}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && empty($src_lotsize) && $src_jobno != ""){    
	
	//---------- model + src_jobno + date
	$where2 = "where  a.jobmodelname containing '$src_model' 
				and c.jobno containing '$src_jobno'
				and a.jobdate>='$src_sdate'
				and  a.jobdate<='$src_edate'";
}
/*------------------------- src_lotsize + src_jobno --------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && empty($src_model)  && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_lotsize + src_jobno
	$where2 = "where  c.jobno containing '$src_jobno' 
					and a.joblotsize = '$src_lotsize' 
					and a.jobdate>='{$date2}' 
					and a.jobdate<='{$date}'";
}
elseif($src_sdate != "" && $src_edate != "" && empty($src_model)  && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_lotsize + src_jobno + date
	$where2 = "where  c.jobno containing '$src_jobno' 
				and  a.joblotsize = '$src_lotsize' 
				and  a.jobdate>='$src_sdate'
				and  a.jobdate<='$src_edate'";
}
/*------------------------- src_model + src_lotsize + src_jobno --------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_model + src_lotsize + src_jobno
	$where2 = "where  a.jobmodelname containing '$src_model' 
					and a.joblotsize = '$src_lotsize'
					and c.jobno containing '$src_jobno'
					and a.jobdate>='{$date2}'
					and a.jobdate<='{$date}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_model + src_lotsize + src_jobno + date
	$where2 = "where  a.jobmodelname containing '$src_model' 
					and a.joblotsize = '$src_lotsize'
					and c.jobno containing '$src_jobno'
					and a.jobdate>='$src_sdate'
					and  a.jobdate<='$src_edate'";
}
/*------------------------- DATE ONLY ---------------------------------------------------------------------------*/
else{ 
	$where2 = "where a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'
				and (a.sts_install is null 
					or a.sts_install = '1' 
					or a.sts_install = '2' 
					or a.sts_install = '3' 
					or a.sts_install = '4' 
					or a.sts_install = '5')";
 
}
/*---------------------------------------------------------------------------------------------------------------*/

	$sql_joblist 		= "select distinct c.jobno,a.jobdate,a.jobtime,a.jobline,a.jobmodelname,b.pwb_name,
							a.jobpwbno,b.process, a.jobstartserial,a.joblotsize, a.jobfile,c.picname,a.sts_install,
							a.sts_ins_snik, a.sts_ins_sname, a.sts_ins_sdate, a.sts_ins_stime, a.sts_ins_edate, a.sts_ins_etime
						from jobheaderinfo a
							left join jobmodel b on a.jobno=b.jobno
							left join joblist c on a.jobno=c.jobno
						$where2 
							order by a.sts_install asc, a.jobline, (a.jobdate||a.jobtime) desc ";
							//order by a.jobline, (a.jobdate||a.jobtime) desc";

$rs_joblist			= $db->Execute($sql_joblist);
$exist_joblist		= $rs_joblist->RecordCount();

	
	/**--------------**/
	/*  create table  */
	/**--------------**/
	if($exist_joblist == 0){
		?>
			<h4 class="warning" align="center" style="color: red;">No Joblist Data</h4>
		<?php
	}
	else{
		//echo'<table id="dt_install" align="center" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<table id="dt_install" align="center">';
		echo'<thead>';
			echo'<th>NO</th>';
			echo'<th>ACTION</th>';
			echo'<th>JOB NO.</th>';
			echo'<th>DATE</th>';
			echo'<th>LINE</th>';
			echo'<th>MODEL NAME</th>';
			echo'<th>PROCESS</th>';
			echo'<th>PWB NO.</th>';
			echo'<th hidden="true">PROCESS</th>';
			echo'<th>START SERIAL</th>';
			echo'<th>LOT SIZE</th>';
			echo'<th>FILE</th>';
			echo'<th>PIC</th>';
			echo'<th>OPERATOR</th>';
			echo'<th>START DATE</th>';
			echo'<th>END DATE</th>';
		echo'</thead>';
        echo'<tbody>';
		
		$no = 0;
		
		while(!$rs_joblist->EOF){
			$no++;
			$jobno         = $rs_joblist->fields['0'];
			$jdate 		   = $rs_joblist->fields['1'];
			$jobdate       = date_format(date_create($rs_joblist->fields['1']), 'd M Y');
			$jobtime       = date_format(date_create($rs_joblist->fields['2']), 'H:i');
			$jobline       = isset($rs_joblist->fields['3']) ? $rs_joblist->fields['3'] : "";
			$jobmodelname  = isset($rs_joblist->fields['4']) ? $rs_joblist->fields['4'] : "";
			$pwb_name      = isset($rs_joblist->fields['5']) ? $rs_joblist->fields['5'] : "";
			$jobpwbno      = isset($rs_joblist->fields['6']) ? $rs_joblist->fields['6'] : "";
			$process       = isset($rs_joblist->fields['7']) ? $rs_joblist->fields['7'] : "";
			$jobstartserial= isset($rs_joblist->fields['8']) ? $rs_joblist->fields['8'] : "";
			$joblotsize    = isset($rs_joblist->fields['9']) ? $rs_joblist->fields['9'] : "";
			$jobfile       = isset($rs_joblist->fields['10']) ? $rs_joblist->fields['10'] : "";
			$picname       = isset($rs_joblist->fields['11']) ? $rs_joblist->fields['11'] : "";
			$sts_install   = isset($rs_joblist->fields['12']) ? $rs_joblist->fields['12'] : "";
			$sts_opnik     = isset($rs_joblist->fields['13']) ? $rs_joblist->fields['13'] : "";
			$sts_opname    = isset($rs_joblist->fields['14']) ? $rs_joblist->fields['14'] : "<font style='color: gray;'>-</font>";
			$op_startdate1 = isset($rs_joblist->fields['15']) ? date_format(date_create($rs_joblist->fields['15']), 'd M Y') : "";
			$op_starttime1 = isset($rs_joblist->fields['16']) ? " (".date_format(date_create($rs_joblist->fields['16']), 'H:i').")" : "";
			$op_startdate2 = $op_startdate1.$op_starttime1;
			$op_enddate1   = isset($rs_joblist->fields['17']) ? date_format(date_create($rs_joblist->fields['17']), 'd M Y') : "";
			$op_endtime1   = isset($rs_joblist->fields['18']) ? " (".date_format(date_create($rs_joblist->fields['18']), 'H:i').")" : "";
			$op_enddate2   = $op_enddate1.$op_endtime1;
            
			$pwb_name1 = trim($pwb_name);
			if(empty($pwb_name1)){
				$pwb_name = $process;
			}
			else{
				$pwb_name = $pwb_name1.' / '.$process;
			}
			
			if($op_startdate2==""){ $op_startdate = '<font style="color: gray;">-</font>'; }
			else{ $op_startdate = $op_startdate2; }
			
			if($op_enddate2==""){ $op_enddate = '<font style="color: gray;">-</font>'; }
			else{ $op_enddate = $op_enddate2; }
			
            
			if($sts_install === "1"){ echo'<tr style="background-color: yellow">'; }
			elseif($sts_install === "2"){ echo'<tr style="background-color: lightgreen">'; }
			elseif($sts_install === "3"){ echo'<tr style="background-color: #b3cccc">'; }
			elseif($sts_install === "4" or $sts_install === "5"){ echo'<tr style="background-color:lightblue">'; }
			elseif(empty($sts_install)){ echo'<tr>'; }
			
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="ACTION">';
					if($sts_install === "1" or $sts_install === "5"){
						echo'<button id="btn_detail" class="btn-detail" onclick="installDetail('.$no.')">DETAIL</button>
						<input type="hidden" name="jobno'.$no.'" id="jobno'.$no.'" value='.$jobno.' />
						<input type="hidden" name="model'.$no.'" id="model'.$no.'" value='.$jobmodelname.' />
						<input type="hidden" name="serial'.$no.'" id="serial'.$no.'" value='.$jobstartserial.' />
						<input type="hidden" name="pwbnm'.$no.'" id="pwbnm'.$no.'" value='.$pwb_name.' />
						<input type="hidden" name="proces'.$no.'" id="proces'.$no.'" value='.$process.' />';
					}
					elseif($sts_install === "2" or $sts_install === "4"){
						echo'<button id="btn_detail" class="btn-detail" onclick="installDetail('.$no.')">DETAIL</button>
								<button id="btn_unfinish" class="btn-unfinish" onclick="unfinish('.$no.')">UNFINISH</button>
								<input type="hidden" name="jobno'.$no.'" id="jobno'.$no.'" value='.$jobno.' />
								<input type="hidden" name="model'.$no.'" id="model'.$no.'" value='.$jobmodelname.' />
								<input type="hidden" name="serial'.$no.'" id="serial'.$no.'" value='.$jobstartserial.' />
								<input type="hidden" name="pwbnm'.$no.'" id="pwbnm'.$no.'" value='.$pwb_name.' />
								<input type="hidden" name="proces'.$no.'" id="proces'.$no.'" value='.$process.' />
								<input type="hidden" name="jdate'.$no.'" id="jdate'.$no.'" value='.$jdate.' />';
							
					}
					elseif($sts_install === "3"){
						echo'<font style="color: red !important; font-size: 15px; font-weight: bold">PASSED</font>';
						echo'&nbsp;<button id="btn_unfinish" class="btn-unfinish" onclick="unpass_ins('.$no.')">UNDO</button>
								<input type="hidden" name="jobno'.$no.'" id="jobno'.$no.'" value='.$jobno.' />
								<input type="hidden" name="jdate'.$no.'" id="jdate'.$no.'" value='.$jdate.' />';
					}
					elseif(empty($sts_install)){
						echo'<button id="btn_detail" class="btn-detail" onclick="installDetail('.$no.')">DETAIL</button>
								<input type="hidden" name="jobno'.$no.'" id="jobno'.$no.'" value='.$jobno.' />
								<input type="hidden" name="model'.$no.'" id="model'.$no.'" value='.$jobmodelname.' />
								<input type="hidden" name="serial'.$no.'" id="serial'.$no.'" value='.$jobstartserial.' />
								<input type="hidden" name="pwbnm'.$no.'" id="pwbnm'.$no.'" value='.$pwb_name.' />
								<input type="hidden" name="proces'.$no.'" id="proces'.$no.'" value='.$process.' />
							<button id="btn_pass" class="btn-pass" onclick="passJobno('.$no.')">PASS</button>
								<input type="hidden" name="passJ'.$no.'" id="passJ'.$no.'" value='.$jobno.' />
								<input type="hidden" name="passM'.$no.'" id="passM'.$no.'" value='.$jobmodelname.' />
								<input type="hidden" name="passS'.$no.'" id="passS'.$no.'" value='.$jobstartserial.' />
								<input type="hidden" name="passJD'.$no.'" id="passJD'.$no.'" value='.$jdate.' />';
					}
				echo'</td>';
				echo'<td data-content="JOB NO." id="job">'.$jobno.'</td>';
				echo'<td data-content="DATE">'.$jobdate.'<br>('.$jobtime.')</td>';
				echo'<td data-content="LINE">'.$jobline.'</td>';
				echo'<td data-content="MODEL NAME">'.$jobmodelname.'</td>';
				//echo'<td data-content="PWB NAME">'.$pwb_name.'</td>';
				echo'<td data-content="PROCESS">'.$pwb_name.'</td>';
				echo'<td data-content="PWB NO.">'.$jobpwbno.'</td>';
				echo'<td data-content="PROCESS111" hidden="true">'.$process.'</td>';
				echo'<td data-content="START SERIAL">'.$jobstartserial.'</td>';
				echo'<td data-content="LOT SIZE">'.$joblotsize.'</td>';
				echo'<td data-content="FILE">'.$jobfile.'</td>';
				echo'<td data-content="PIC">'.$picname.'</td>';
				echo'<td data-content="OPERATOR">'.$sts_opname.'</td>';
				echo'<td data-content="START DATE">'.$op_startdate.'</td>';
				echo'<td data-content="END DATE">'.$op_enddate.'</td>';
			echo'</tr>';
			
			$rs_joblist->MoveNext();
		}
        echo'</tbody>';
		echo'</table>';
	}
	/**------***end create table***--------**/
/**------***end run query ***--------**/
$rs_joblist->Close();
$db->Close();
$db=null;
?>