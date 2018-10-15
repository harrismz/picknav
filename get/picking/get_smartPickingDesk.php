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
	//call url
	$(document).ready(function(){
        //color based on menu click
		if(	operator == "smartPickingDesk"){
			//remove
			$("#dt_smpdesk").removeClass("partnoClick-table pickingClick-table installClick-table checkedClick-table replaceClick-table limitClick-table");
			//add
			$("#dt_smpdesk").addClass("pickingClick-table");
		}
		return false;
    });
</script>
<?php

//call session
$picknav_pic = isset($_SESSION['picknav_pic'])  ? $_SESSION['picknav_pic']	: '';
$picknav_levelno    = isset($_SESSION['picknav_levelno'])   ? $_SESSION['picknav_levelno']		: '';

$picknav_nik = isset($_POST['nik'])   ? $_POST['nik']		: '';
$get_jobno   = isset($_POST['jobno']) ? $_POST['jobno']	: '';
$get_zfeed4  = isset($_POST['zfeed']) ? $_POST['zfeed']	: '';
$date1 = date("Y-m-d", strtotime("-7 Day"));
$date2 = date('Y-m-d');

$get_zfeed3		= str_replace("+"," ",$get_zfeed4);
$get_zfeed2		= str_replace("::","#",$get_zfeed3);
$get_zfeed      = explode("|",$get_zfeed2);
$zfeeder_total  = count($get_zfeed);
$zfeeder_zfd = "";

for($i=0; $i<$zfeeder_total; $i++){
	$zfeeder_feedergroup 	= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."'";
	$zfeeder_zfd 			= $zfeeder_zfd. " zfeeder containing '".$get_zfeed[$i]."' or";
}
 
$sql 	= "select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
			 loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
			 full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, ket
            from pn_picking('{$get_jobno}')
            where ({$zfeeder_feedergroup}) 
			and (partnumber <> '' or partnumber <> null)
			order by addrs asc";
$rs		= $db->Execute($sql);
$exist	= $rs->RecordCount();

$sql_uncheck = " select count(*) from pn_picking('{$get_jobno}') where ({$zfeeder_feedergroup})
									 and (partnumber <> null or partnumber <> '')
									 and loose_reel is null and full_reel is null";
$rs_uncheck	= $db->Execute($sql_uncheck);
$rs_uncheck->Close();
$tot_uncheck = trim($rs_uncheck->fields[0]);

$sql_limit = " select count(*) from pn_picking('{$get_jobno}') where ({$zfeeder_feedergroup})
									 and (partnumber <> null or partnumber <> '')
									 and (loose_reel = 'LIMIT' or full_reel = 'LIMIT')";
$rs_limit	= $db->Execute($sql_limit);
$rs_limit->Close();
$tot_limit = trim($rs_limit->fields[0]);

if($exist == 0){
    ?>
        <h4 class="warning" align="center" style="color: red;">No Joblist Data</h4>
    <?php
}
else{
	echo'<input type="hidden" id="uncheck" value="'.$tot_uncheck.'" />';
	echo'<input type="hidden" id="chk_limit" value="'.$tot_limit.'" />';
    //echo'<table id="dt_smpdesk" align="center" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<table id="dt_smpdesk" align="center" class="table table-stripse col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    echo'<thead>';
        echo'<th>NO</th>';
        echo'<th>ADDRS</th>';
        echo'<th>Z-FEEDER</th>';
        //echo'<th>POL</th>';
        echo'<th>POS</th>';
        //echo'<th>W / FS</th>';
        //echo'<th>P / SP</th>';
        echo'<th>PART NUMBER</th>';
        //echo'<th>POINT</th>';
        echo'<th>DEMAND</th>';
        echo'<th>LOOSE REEL</th>';
        echo'<th>FULL REEL</th>';
        echo'<th>KET</th>';
    echo'</thead>';
    echo'<tbody>';
    $no = 0;
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
		$w_fs       = trim($rs->fields['4']);
        $p_sp       = trim($rs->fields['5']);
        $addrs      = trim($rs->fields['6']);
        $partnumber = trim($rs->fields['7']);
        $point      = trim($rs->fields['8']);
        $demand     = trim($rs->fields['9']);
        $loose_reel = trim($rs->fields['10']);
        $loose_reel_rl = trim($rs->fields['11']);
        $loose_reel_qty = trim($rs->fields['12']);
        $loose_reel_blc = trim($rs->fields['13']);
        $full_reel  = trim($rs->fields['14']);
        $full_reel_rl  = trim($rs->fields['15']);
        $full_reel_qty  = trim($rs->fields['16']);
        $full_reel_qty_blc  = trim($rs->fields['17']);
        $ket        = trim($rs->fields['18']);
        
        if($loose_reel != "" or $full_reel != ""){
             echo'<tr style="background-color:#d3f8d3 !important">';
                echo'<td data-content="NO">'.$no.'.</td>';
                echo'<td data-content="ADDRS">'.$addrs.'</td>';
                echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
                //echo'<td data-content="POL">'.$pol.'</td>';
                echo'<td data-content="POS">'.$pos.'</td>';
                //echo'<td data-content="W / FS">'.$w_fs.'</td>';
                //echo'<td data-content="P / SP">'.$p_sp.'</td>';
                echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
                //echo'<td data-content="POINT">'.$point.'</td>';
                echo'<td data-content="DEMAND">'.$demand.'</td>';
                
                    if($loose_reel == "OK"){
                        echo'<td data-content="LOOSE REEL" style="color: green;"><b>'.$loose_reel.' / R:'.$loose_reel_rl.'</b></td>';
                    }
                    else if($loose_reel == "LIMIT"){
                        echo'<td data-content="LOOSE REEL" style="color: red;"><b>'.$loose_reel.' / R:'.$loose_reel_rl.' / Q:'.$loose_reel_qty.'</b></td>';
                    }
					else{
                        echo'<td data-content="LOOSE REEL" style="color: gray;"><b>-</b></td>';
                    }
                   if($full_reel == "OK"){
                        echo'<td data-content="FULL REEL" style="color: green;"><b>'.$full_reel.' / R:'.$full_reel_rl.'</b></td>';
                    }
                    elseif($full_reel == "LIMIT"){
                        echo'<td data-content="FULL REEL" style="color: red;"><b>'.$full_reel.' / R:'.$full_reel_rl.' / Q:'.$full_reel_qty.'</b></td>';
                    }
					else{
						echo'<td data-content="FULL REEL" style="color: gray;"><b>-</b></td>';
					}

                echo'<td data-content="KET">'.$ket.'</td>';
            echo'</tr>';
            $rs->MoveNext();
        }
        else{
            echo'<tr style="color:red !important">';
                echo'<td data-content="NO">'.$no.'.</td>';
                echo'<td data-content="ADDRS">'.$addrs.'</td>';
                echo'<td data-content="Z-FEEDER">'.$zfeeder.'</td>';
                //echo'<td data-content="POL">'.$pol.'</td>';
                echo'<td data-content="POS">'.$pos.'</td>';
                //echo'<td data-content="W / FS">'.$w_fs.'</td>';
                //echo'<td data-content="P / SP">'.$p_sp.'</td>';
                echo'<td data-content="PART NUMBER">'.$partnumber.'</td>';
                //echo'<td data-content="POINT">'.$point.'</td>';
                echo'<td data-content="DEMAND">'.$demand.'</td>';
                echo'<td data-content="LOOSE REEL">'.$loose_reel.'</td>';
                echo'<td data-content="FULL REEL">'.$full_reel.'</td>';
                echo'<td data-content="KET">'.$ket.'</td>';
            echo'</tr>';
            $rs->MoveNext();
        }
       
    }
    echo'</tbody>';
    echo'</table>';
}

$rs->Close();
$db->Close();
$db=null;
?>