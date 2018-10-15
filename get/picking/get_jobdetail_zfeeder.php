<?php
//start session
ob_start();
session_start();
ob_end_clean();

date_default_timezone_set('Asia/Jakarta');
//include database connection
include "../../../adodb/con_part_im.php";

//call session
$picknav_pic = isset($_SESSION['picknav_pic'])	? $_SESSION['picknav_pic']	: '';
$picknav_levelno    = isset($_SESSION['picknav_levelno'])		? $_SESSION['picknav_levelno']		: '';

$jobno   = isset($_POST['jobno'])	? $_POST['jobno']	: '';
/**-----------**/
/** run query **/
/**-----------**/


	$sql 		= "select distinct(substring(zfeeder from 1 for position('-',zfeeder,1)-1)) as zfeed, jobdate, jobtime
                    from jobdetail
                    where jobno = '$jobno' order by zfeeder asc";
    //$sql 		= "select * from PN_ZFEEDER('{$jobno}')";
	$rs			= $db->Execute($sql);
	$exist		= $rs->RecordCount();
 
	/**--------------**/
	/*  create table  */
	/**--------------**/
	if($exist == 0){
		?>
			<h4 class="warning" align="center" style="color: red;">No Joblist Data</h4>
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
               /* var jobno = '4FB0CC2A-3FC2-4768-B505-E9F47E006515'; 
                alert(jobno);*/
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
            */
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

$rs->Close();
$db->Close();
$db=null;
?>
<script type="text/javascript">
    
</script>