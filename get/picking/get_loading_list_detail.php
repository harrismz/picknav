<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
include "../../../adodb/con_part_im.php";

$picknav_nik    = isset($_SESSION['picknav_nik'])   ? $_SESSION['picknav_nik'] : '';
$picknav_pic    = isset($_SESSION['picknav_pic'])   ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno']: '';
$jobno          = isset($_POST['jobno'])	? $_POST['jobno']	: '';
$zfeed2         = isset($_POST['zfeed'])	? $_POST['zfeed']	: '';
$model          = isset($_POST['model'])	? $_POST['model']	: '';
$serial         = isset($_POST['serial'])	? $_POST['serial']	: '';
$pwbname        = isset($_POST['pwbname'])	? $_POST['pwbname']	: '';
$proces         = isset($_POST['proces'])	? $_POST['proces']	: '';
$jdate          = isset($_POST['jdate'])	? $_POST['jdate']	: '';
$total          = isset($_POST['total']) 	? $_POST['total']	: '';
$zfeed          = explode("|",$zfeed2);


//$sql1        = "select count(distinct zfeeder) from jobdetail where jobno = '$jobno'";        
//$sql1        = "SELECT COUNT(*) FROM diff_zfeeder2('{$jobno}') where zno = '{$zfeed}'";  

$feedergroup  = "";
$zfd = "";
for($i=0; $i<$total; $i++){
	$feedergroup 	= $zfd. " zfeeder containing '".$zfeed[$i]."'";
	$zfd 			= $zfd. " zfeeder containing '".$zfeed[$i]."' or";
}
      
/***$sql1        = "SELECT COUNT(*) FROM (
				select distinct zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand, loose_reel, full_reel, ket
				from jobdetail
				where jobno = '{$jobno}' and ({$feedergroup}) and (partnumber <> '' or partnumber <> null) and (sts_opstart = '1' or sts_opstart is null) 
			)";        
$rs1	     = $db->Execute($sql1);
$exist1      = $rs1->RecordCount();
$tot_zfeeder = $rs1->fields['0'];***/

$sql1        = "SELECT COUNT(*) FROM (
					select  zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
							loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
							full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, ket
					from pn_picking('{$jobno}')
					where ({$feedergroup}) 
					and (partnumber <> null or partnumber <> '')
				)";        
$rs1	     = $db->Execute($sql1);
$exist1      = $rs1->RecordCount();
$tot_zfeeder = $rs1->fields['0'];


$sql2        = "select jobdate, jobtime, jobfile, jobmc_program,
                       jobmodelname, jobpwbno, jobmetalmask, jobfirstpoint,
                       jobpwbsize, jobefflot, jobblockjig, jobmcrh,
                       jobline, joblotsize, jobstartserial, jobaltno
                from jobheaderinfo
                where jobno = '{$jobno}'";        
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

	/**--------------**/
	/*  create table  */
	/**--------------**
	if($exist == 0){
		?>
			<h4 class="warning" align="center" style="color: red;">No Loading List Data</h4>
		<?php
	}
	else{
        //echo '<h4 style="text-align: center; font-weight: bold;">JOBNO : '.$jobno.'</h4>';
		echo'<table id="dt_zfeed" align="center" class="table-striped table-hover col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		echo'<thead>';
			echo'<th>NO</th>';
			echo'<th>Z-FEEDER</th>';
			echo'<th>PIC</th>';
		echo'</thead>';
        echo'<tbody>';
		$no = 0;
		while(!$rs->EOF){
			$no++;
			$zfeeder       = $rs->fields['0'];
			$jobdate       = date_format(date_create($rs->fields['1']), 'd M Y');
			$jobtime       = date_format(date_create($rs->fields['2']), 'H:i');
            ?>
            <script type="text/javascript">
                //var jobno = <php echo $jobno; ?>; 
                //var zfeeder = <php echo $zfeeder; ?>; 
               // var jobno = '4FB0CC2A-3FC2-4768-B505-E9F47E006515'; 
                alert(jobno);
            /*    
                $.post('../json/view_pic.php', { action : 'insert' },
                function(result){
                    var listPic = "";
                    var jsonListPic = $.parseJSON(result);
                    listPic="<option value=''>-- Select PIC --</option>";
                    for (var i=0; i < jsonListPic.data.length; i++){
                        listPic+="<option value='"+jsonListPic.data[i].nik+"'>"+jsonListPic.data[i].pic+"</option>";
                    }
                    $('#select_pic').html(listPic);
                });
            *
            </script>
            <?php
            echo'<tr>';
				echo'<td data-content="NO">'.$no.'.</td>';
				echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
				echo'<td data-content="PIC" id="select_pic"></td>';
            echo'</tr>';
			$rs->MoveNext();
		}
        echo'</tbody>';
		echo'</table>';
	}
	/**------***end create table***--------**/



/**------***end run query ***--------**/

$rs1->Close();
$rs2->Close();
$db->Close();
$db=null;
?>