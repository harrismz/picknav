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
		if(	operator == "" || smt == ""){
			//remove
			$("#dt_viewoll").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_viewoll").addClass("pickingClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$picknav_pic    = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic'] : '';
$picknav_levelno= isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']  : '';
$picknav_nik    = isset($_POST['nik'])   ? $_POST['nik']  : '';
$jobno      	= isset($_POST['jobno']) ? $_POST['jobno'] : '';
$get_zfeed4  	= isset($_POST['zfeed']) ? $_POST['zfeed']	: '';
$get_zfeed3		= str_replace("+"," ",$get_zfeed4);
$get_zfeed2		= str_replace("::","#",$get_zfeed3);
$get_zfeed      = explode("|",$get_zfeed2);
$zfeeder_total  = count($get_zfeed);
$zfeeder_zfd = "";

for($i=0; $i<$zfeeder_total; $i++){
	$zfeeder_feedergroup 	= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."'";
	$zfeeder_zfd 			= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."' or";
}
 
if($get_zfeed4 == ""){
	$where = "";
}
else{
	$where = "where ({$zfeeder_feedergroup})";
}

$sql 	= "select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber,
			point, demand, loose_reel, full_reel, install, checked, ket, zfd_name, zfd_no, zfd_tray, reelid
			from view_oll('{$jobno}')
			$where
			order by zfd_name || zfd_no || pos asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

if($exist == 0){
    ?>
        <h4 class="warning" align="center">Data tidak ada</h4>
    <?php
}
else{
	echo'<table id="dt_viewoll" align="center" class="table table-striped col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<tbody>';
    $no = 0;
	$zfd = "";
    while(!$rs->EOF){
        $no++;
		$zfeeder = trim($rs->fields['0']);
		$pol     = trim($rs->fields['1']);
		$pos_val = trim($rs->fields['2']);
		$pos1_val= trim($rs->fields['3']);
        if($pos_val == "" and $pos1_val == ""){
            $pos = '';
        }
        elseif($pos_val != "" and $pos1_val == ""){
            $pos = $pos_val;
        }
        elseif($pos_val == "" and $pos1_val != ""){
            $pos = $pos1_val;
        }
        elseif($pos_val != "" and $pos1_val != ""){
            $pos = $pos_val."(".$pos1_val.")";
        }
		$w_fs             = trim($rs->fields['4']);
		$p_sp             = trim($rs->fields['5']);
		$addrs            = trim($rs->fields['6']);
		$partnumber       = $rs->fields['7'];
		$point            = trim($rs->fields['8']);
		$demand           = trim($rs->fields['9']);
		$loose_reel       = trim($rs->fields['10']);
		$full_reel        = trim($rs->fields['11']);
		$install          = $rs->fields['12'];
		$checked          = $rs->fields['13'];
		$ket              = $rs->fields['14'];
		$zfd_name         = trim($rs->fields['15']);
		$zfd_no           = trim($rs->fields['16']);
		$zfd_tray         = trim($rs->fields['17']);
		$zfd_join         = $zfd_name.'-'.$zfd_no.' #'.$zfd_tray;
		$reelid	          = trim($rs->fields['18']);
		
		if($zfd != $zfd_name){
			$zfd = $zfd_name;
			echo'<tr><td colspan="15" style="color: #fff; background-color: gray; text-align:center;"><b> '.$zfd.'</b></td></tr>';
			echo'<tr style="background-color: lightgray;">';
			echo'<th>NO</th>';
			echo'<th>Z-FEEDER</th>';
			echo'<th hidden="true">POL</th>';
			echo'<th>POS</th>';
			echo'<th>W/FS</th>';
			echo'<th>P/SP</th>';
			echo'<th>PART NUMBER</th>';
			echo'<th>ADDRS</th>';
			echo'<th>POINT</th>';
			echo'<th>DEMAND</th>';
			echo'<th>LOOSE REEL</th>';
			echo'<th>FULL REEL</th>';
			echo'<th>INSTALL</th>';
			//echo'<th>CHECKED</th>';
			echo'<th>REEL ID</th>';
			echo'<th>KET</th>';
			echo'</tr>';
		}
			
		echo'<tr>';
			echo'<td data-content="NO">'.$no.'.</td>';
			echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
			echo'<td data-content="POL" hidden="true">'.$pol.'</td>';
			echo'<td data-content="POS">'.$pos.'</td>';
			echo'<td data-content="W/FS">'.$w_fs.'</td>';
			echo'<td data-content="P/SP">'.$p_sp.'</td>';
			echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
			echo'<td data-content="ADDRS">'.$addrs.'</td>';
			echo'<td data-content="POINT">'.$point.'</td>';
			echo'<td data-content="DEMAND">'.$demand.'</td>';
			
			 if($loose_reel == "OK"){
				echo'<td data-content="LOOSE REEL" style="color: green;"><b>'.$loose_reel.'</b></td>';
			}
			else if($loose_reel == "LIMIT"){
				echo'<td data-content="LOOSE REEL" style="color: red;"><b>'.$loose_reel.'</b></td>';
			}
			else{
				echo'<td data-content="LOOSE REEL" style="color: gray;"><b>-</b></td>';
			}
		   if($full_reel == "OK"){
				echo'<td data-content="FULL REEL" style="color: green;"><b>'.$full_reel.'</b></td>';
			}
			elseif($full_reel == "LIMIT"){
				echo'<td data-content="FULL REEL" style="color: red;"><b>'.$full_reel.'</b></td>';
			}
			else{
				echo'<td data-content="FULL REEL" style="color: gray;"><b>-</b></td>';
			}

			/*install*/
			if($install === "OK"){
				echo'<td data-content="INSTALL" style="color:  #009688;"><b>'.$install.'</b>';
				echo'</td>';
			}
			else{
				echo'<td data-content="INSTALL" style="color: red; text-align= center;"><b>-</b></td>';
			}
			
			/*checked*/
			// if($checked === "OK"){
			// 	echo'<td data-content="CHECKED" style="color:  #009688;"><b>'.$checked.'</b>';
			// 	echo'</td>';
			// }
			// else{
			// 	echo'<td data-content="CHECKED" style="color: red; text-align = center;"><b>-</b></td>';
			// }
			
			echo'<td data-content="DEMAND">'.$reelid.'</td>';
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