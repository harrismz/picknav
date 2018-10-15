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
		if(	operator == "view_oll" || smt == "view_oll"){
			//remove
			$("#dt_oll").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_oll").addClass("pickingClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$picknav_pic = isset($_SESSION['picknav_pic'])	? $_SESSION['picknav_pic']	: '';
$picknav_levelno    = isset($_SESSION['picknav_levelno'])		? $_SESSION['picknav_levelno']		: '';

$src_sdate   = isset($_POST['src_sdate'])	? $_POST['src_sdate']	: '';
$src_edate   = isset($_POST['src_edate'])	? $_POST['src_edate']	: '';
$src_model   = isset($_POST['src_model'])	? $_POST['src_model']	: '';
//$src_lotsize = isset($_POST['src_lotsize'])	? $_POST['src_lotsize']	: '';
$src_jobno   = isset($_POST['src_jobno'])	? $_POST['src_jobno']	: '';
$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');
//$firebird = "(select cast('Now' as date) from rdb$database)";
/**-----------**/
/** run query **/
/**-----------**/

if(empty($src_sdate) && empty($src_edate) && empty($src_model) && empty($src_jobno)){		
	
	//---------- no input
	$where2 = "where a.jobdate='{$date2}'";
}
/*------------------------- model ------------------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && empty($src_jobno)){	   
	
	//---------- src_model
	$where2 = "where a.jobmodelname containing '$src_model' 
				and a.jobdate>='{$date1}' 
				and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && empty($src_jobno)){    
	
	//---------- src_model + date
	$where2 = "where a.jobmodelname containing '$src_model' 
				and a.jobdate>='$src_sdate'
				and  a.jobdate<='$src_edate'";
}
/*------------------------- lotsize ------------------------------------------------------------------------------*
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
elseif(empty($src_sdate) && empty($src_edate) && empty($src_model) && $src_jobno != ""){    
	
	//---------- src_jobno
	$where2 = "where a.jobno containing '$src_jobno' 
				and a.jobdate>='{$date1}' 
				and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && empty($src_model) && $src_jobno != ""){    
	
	//---------- src_jobno + date
	$where2 = "where a.jobno containing '$src_jobno' 
				and a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'";
}
/*------------------------- model + lotsize ---------------------------------------------------------------------*
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_lotsize != "" && empty($src_jobno)){    
	
	//---------- model + lotsize
	$where2 = "where  a.jobmodelname like '$src_model%' 
				and a.joblotsize = '$src_lotsize' 
				and a.jobdate>='{$date1}' 
				and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_lotsize != "" && empty($src_jobno)){    
	
	//---------- model + lotsize + date
	$where2 = "where  a.jobmodelname like '$src_model%' 
				and  a.joblotsize = '$src_lotsize' 
				and  a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'";
}
/*------------------------- model + src_jobno -------------------------------------------------------------------------*/
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_jobno != ""){    
	
	//---------- model + src_jobno
	$where2 = "where  a.jobmodelname containing '$src_model' 
					and a.jobno containing '$src_jobno'
					and a.jobdate>='{$date1}' 
					and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_jobno != ""){    
	
	//---------- model + src_jobno + date
	$where2 = "where  a.jobmodelname containing '$src_model' 
				and a.jobno containing '$src_jobno'
				and a.jobdate>='$src_sdate'
				and  a.jobdate<='$src_edate'";
}
/*------------------------- src_lotsize + src_jobno --------------------------------------------------------------------*
elseif(empty($src_sdate) && empty($src_edate) && empty($src_model)  && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_lotsize + src_jobno
	$where2 = "where  a.jobno like '$src_jobno%' 
					and a.joblotsize = '$src_lotsize' 
					and a.jobdate>='{$date1}' 
					and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && empty($src_model)  && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_lotsize + src_jobno + date
	$where2 = "where  a.jobno like '$src_jobno%' 
				and  a.joblotsize = '$src_lotsize' 
				and  a.jobdate>='$src_sdate'
				and  a.jobdate<='$src_edate'";
}
/*------------------------- src_model + src_lotsize + src_jobno --------------------------------------------------------*
elseif(empty($src_sdate) && empty($src_edate) && $src_model != "" && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_model + src_lotsize + src_jobno
	$where2 = "where  a.jobmodelname like '$src_model%' 
					and a.joblotsize = '$src_lotsize'
					and a.jobno = '$src_jobno'
					and a.jobdate>='{$date1}'
					and a.jobdate<='{$date2}'";
}
elseif($src_sdate != "" && $src_edate != "" && $src_model != "" && $src_lotsize != "" && $src_jobno != ""){    
	
	//---------- src_model + src_lotsize + src_jobno + date
	$where2 = "where  a.jobmodelname like '$src_model%' 
					and a.joblotsize = '$src_lotsize'
					and a.jobno = '$src_jobno'
					and a.jobdate>='$src_sdate'
					and  a.jobdate<='$src_edate'";
}
/*------------------------- DATE ONLY ---------------------------------------------------------------------------*/
else{ 
	$where2 = "where a.jobdate>='$src_sdate' 
				and  a.jobdate<='$src_edate'
				and (a.sts_opstart is null 
					or a.sts_opstart = '1' 
					or a.sts_opstart = '3' 
					or a.sts_opstart = '4' 
					or a.sts_opstart = '5')";
 
}
/*---------------------------------------------------------------------------------------------------------------*/

	$sql_joblist	= "select distinct a.jobdate, a.jobtime, a.jobno, a.jobmodelname,
							   b.pwb_name, b.process, a.jobstartserial, a.joblotsize,
							   a.jobmc_program, a.jobpoint,a.jobefflot,
							   a.sts_opstart, a.sts_install, a.sts_checked
						from   jobheaderinfo a
							   left join jobmodel b on a.jobno=b.jobno
						$where2
						order by (a.jobdate||a.jobtime) desc";
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
		echo'<table id="dt_oll" align="center" class="table-striped col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<th>NO</th>';
			echo'<th>ACTION</th>';
			echo'<th>DATE</th>';
			echo'<th>JOBNO</th>';
			echo'<th>MODEL NAME</th>';
			echo'<th>PROCESS</th>';
			echo'<th>START<br>SERIAL</th>';
			echo'<th>LOT<br>SIZE</th>';
			echo'<th>MC PROG</th>';
			echo'<th>TOTAL<br>POINT</th>';
			echo'<th>EFF LOT</th>';
			echo'<th>PICKING</th>';
			echo'<th>INSTALL</th>';
			echo'<th>CHECKING</th>';
		echo'</thead>';
        echo'<tbody>';
		
		$no = 0;
		while(!$rs_joblist->EOF){
			$no++;
			$jdate         = $rs_joblist->fields['0'];
			$jobdate       = date_format(date_create($rs_joblist->fields['0']), 'd M Y');
			$jobtime       = date_format(date_create($rs_joblist->fields['1']), 'H:i');
			$jobno         = isset($rs_joblist->fields['2']) ? $rs_joblist->fields['2'] : "";
			$jobmodelname  = isset($rs_joblist->fields['3']) ? $rs_joblist->fields['3'] : "";
			$pwbnm	       = isset($rs_joblist->fields['4']) ? $rs_joblist->fields['4'] : "";
			$process1      = isset($rs_joblist->fields['5']) ? $rs_joblist->fields['5'] : "";
			$jobstartserial= isset($rs_joblist->fields['6']) ? $rs_joblist->fields['6'] : "";
			$joblotsize    = isset($rs_joblist->fields['7']) ? $rs_joblist->fields['7'] : "";
			$mcprog	       = isset($rs_joblist->fields['8']) ? $rs_joblist->fields['8'] : "";
			$totpoint      = isset($rs_joblist->fields['9']) ? $rs_joblist->fields['9'] : "";
			$efflot        = isset($rs_joblist->fields['10']) ? $rs_joblist->fields['10'] : "";
			$sts_picking   = isset($rs_joblist->fields['11']) ? $rs_joblist->fields['11'] : "";
			$sts_install   = isset($rs_joblist->fields['12']) ? $rs_joblist->fields['12'] : "";
			$sts_checked   = isset($rs_joblist->fields['13']) ? $rs_joblist->fields['13'] : "";
			
			//***
			//	join pwb name + process
				if(trim($pwbnm) == "" && trim($process1) == ""){ $process = "-"; }
				elseif(trim($pwbnm) == "" && trim($process1) != ""){ $process = $process1; }
				elseif(trim($pwbnm) != "" && trim($process1) == ""){ $process = $pwbnm; }
				elseif(trim($pwbnm) != "" && trim($process1) != ""){ $process = $pwbnm.' / '.$process1; }

			//***
			//	convert status to string
				if($sts_picking == 1){$sts_picking = '<font class="process">PROCESS</font>';}
				elseif($sts_picking == 2){$sts_picking = '<font class="clear">CLEAR</font>';}
				elseif($sts_picking == 3){$sts_picking = '<font class="passed">PASSED</font>';}
				elseif($sts_picking == 4){$sts_picking = '<font class="unclear">UNCLEAR</font>';}
				elseif($sts_picking == 5){$sts_picking = '<font class="unclear">UNCLEAR</font>';}

				if($sts_install == 1){$sts_install = '<font class="process">PROCESS</font>';}
				elseif($sts_install == 2){$sts_install = '<font class="clear">CLEAR</font>';}
				elseif($sts_install == 3){$sts_install = '<font class="passed">PASSED</font>';}
				elseif($sts_install == 4){$sts_install = '<font class="unclear">UNCLEAR</font>';}
				elseif($sts_install == 5){$sts_install = '<font class="unclear">UNCLEAR</font>';}

				if($sts_checked == 1){$sts_checked = '<font class="process">PROCESS</font>';}
				elseif($sts_checked == 2){$sts_checked = '<font class="clear">CLEAR</font>';}
				elseif($sts_checked == 3){$sts_checked = '<font class="passed">PASSED</font>';}
				elseif($sts_checked == 4){$sts_checked = '<font class="unclear">UNCLEAR</font>';}
				elseif($sts_checked == 5){$sts_checked = '<font class="unclear">UNCLEAR</font>';}

			
			echo'<tr>';
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="ACTION">';
					echo'<button id="btn_detail" class="btn-detail" onclick="olldetail('.$no.')">DETAIL</button>
						<input type="hidden" name="jobno'.$no.'" id="jobno'.$no.'" value='.$jobno.' />
						<input type="hidden" name="model'.$no.'" id="model'.$no.'" value='.$jobmodelname.' />
						<input type="hidden" name="serial'.$no.'" id="serial'.$no.'" value='.$jobstartserial.' />
						<input type="hidden" name="pwbnm'.$no.'" id="pwbnm'.$no.'" value='.$pwbnm.' />
						<input type="hidden" name="process'.$no.'" id="process'.$no.'" value='.$process1.' />
						<input type="hidden" name="jdate'.$no.'" id="jdate'.$no.'" value='.$jdate.' />';
				echo'</td>';
				echo'<td data-content="DATE">'.$jobdate.'<br>('.$jobtime.')</td>';
				echo'<td data-content="JOBNO">'.$jobno.'</td>';
				echo'<td data-content="MODEL NAME">'.$jobmodelname.'</td>';
				echo'<td data-content="PROCESS">'.$process.'</td>';
				echo'<td data-content="START SERIAL">'.$jobstartserial.'</td>';
				echo'<td data-content="LOT SIZE">'.$joblotsize.'</td>';
				echo'<td data-content="MC PROG">'.$mcprog.'</td>';
				echo'<td data-content="TOTAL POINT">'.$totpoint.'</td>';
				echo'<td data-content="EFF LOT">'.$efflot.'</td>';
				echo'<td data-content="PICKING">'.$sts_picking.'</td>';
				echo'<td data-content="INSTALL">'.$sts_install.'</td>';
				echo'<td data-content="CHECKING">'.$sts_checked.'</td>';
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