<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var jobno1 = $("#input-jobno").val();
		var critical1 = $("#input-critical").val();
        var jobno2 = $("#input-jobno");
		var jobno_len = jobno1.length;
		$('#tbl_critical').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/critical/get_critical_data.php', {
			jobno : jobno1,
			critical : critical1
		},
		function(result) {
			$('#tbl_critical').html(result).show();
		});
        
		if(jobno_len < 38){
			jobno2.focus();
		}
		else{
			critical.focus();
		}
		return false;
	});
	/* function insConf(x){
		if(confirm("Anda yakin 'Start/End Position' yg anda lakukan sudah sesuai ?") == true){
			$.post('resp/install/confirm.php',{
					jobno	: jobno,
					zfeed	: zfeed,
					nik		: nik,
					jdate	: jdate,
					pos1	: minpos,
					pos2	: maxpos,
					status  : x
				},
				function(data, status, xhr) {					
					if(status == 'success'){
						$('#ModalIsiPos').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
						$.post('get/install/get_install_conf.php', { jobno:jobno, zfeed:zfeed, jdate:jdate },
						function(result) { $('#ModalIsiPos').html(result).show(); });
						arrstatus.push("1");
						var totstatus = arrstatus.length;
						if(totstatus == 2){
							$('#ModalBottomPos').html('<button type="button" class="modalstyle-close" onclick="dismismodal()">CLOSE</button>');
						}
						else{
							$('#ModalBottomPos').html('');
						}
					}
					else{
						$('#ModalIsiPos').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
						$('#ModalBottomPos').html('');
						$.post('get/install/get_install_conf.php', { jobno:jobno, zfeed:zfeed, jdate:jdate },
						function(result) { $('#ModalIsiPos').html(result).show(); });
					}
				}
			);
		}
	}
	*/
    /*function on_refresh_install(){
        $('#tbl_installdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_smartInstallDesk.php', {
			snik : nik,
            jobno : jobno,
            feederno : rows
            feederno : rows
		},
		function(result) {
			$('#tbl_installdesk').html(result).show();
		});
		$("#input-scnpartno-chk").focus();
		return false;    
	}
    */
	/* function on_finishing_install(){
		
		var uncheck = document.getElementById("uncheck").value;
        
		if(confirm("Anda mempunyai \n\nPart yang belum di Install : "+ uncheck +" Part\n\nApakah anda yakin untuk menyelesaikan Proses Install ini ?\n\n") == true){
            $.post('resp/install/2_finishing_install.php', {
				jobno : jobno, 
				nik : nik, 
				jdate:jdate,
				feederno : rows
			},
			function(data, status) {
				//alert(status + '$' + data);
				if (status == 'success'){
					next_zfd = parseInt(rows)+parseInt(1);
					if(next_zfd <= zfd_tot1){
						$.post('resp/install/start_install.php', {
							jobno_ins  : jobno,
							nik_ins    : nik,
							jdate_ins  : jdate,
							feederno   : next_zfd
							},
							function(data, status) {
								if(status == "success"){
									window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&nik="+nik+"&jobno="+jobno+"&row="+next_zfd+"&count="+zfd_tot1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm2+"&process="+process+"&jdate="+jdate);
								}
								else{
									alert('Data not found !');
								}
							}
						);
					}
					//	window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&nik="+nik+"&jobno="+jobno+"&row="+next_zfd+"&count="+zfd_tot1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm+"&process="+process+"&jdate="+jdate);
					//	window.location.assign("/picknav/dashboard.php?operator=2_smartInstallDesk&jobno="+jobno+"&row="+prev+"&count="+zfd_tot1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm2+"&process="+process+"&jdate="+jdate);
					else{
						window.location.assign("/picknav/dashboard.php?operator=2_install_data");
					}
					return false;    
				}
			});
        }
		return false;    
	}
    */
	
	function startjobno(){
		$("#input-jobno").val("");
		$("#input-critical").val("");
		$("#label-critical").val("");
		$("#input-jobno").focus();
	}
	
	function scanpartnoChk(event){
		var x = event.which || event.keyCode;
		var critical = $("#input-critical");
		var critical2 = $("#label-critical");
		
		//alert(x);
		//contoh barcode reel
		//CK73FXR0J226M 9 30001977359109
		//CK73GXR1H104K 9 4000197030815E
		//CK73FBB0J106K 9 30001969114101
		//CK73HBB1A104K 910000195842410X
		//RK73GB2A000J  9 50002012866128
		
		if(x == 13) {
			//alert(critical);
			//alert(x);
			var jobno1 = $("#input-jobno").val();
			var critical_scan = critical.val();
			critical2.val(critical_scan);
			var critical_show = critical_scan.substr(0,15);
			document.getElementById("label-critical").innerHTML = critical_show;
			//critical.val("");
			//critical.focus();
			
			//random color
			var colors = ['#3f51b5','#2196f3','#e91e63','#9c27b0','#263238','#ff3d00'];
			var random_color = colors[Math.floor(Math.random() * colors.length)];
			$('#label-critical').css('color', random_color);
			$('#label-critical').css('border-bottom', '3px solid '+random_color);
			
			//alert(chk_partno+'---'+chk_critical);
			if (jobno1 == "" && critical.val() == "" ){
				jobno2.focus();
			}
			else if (jobno1 != "" && critical.val() == "" ){
				critical.focus();
				document.getElementById("label-jobno-show").innerHTML = jobno1;
				showdatacritical(jobno1);
			}
			else if (jobno1 == "" && critical.val() != "" ){
				jobno2.focus();
			}
			else{
				var lengcritical = critical_scan.length;
				if (lengcritical == 38){
					critical.val("");
					critical.focus();
				
					$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
					$.post('get/critical/get_scanCritical_ext.php', {
						jobno : jobno1,
						scanpartno : critical2.val()
					},
					function(result) {
						$('#tbl_scanpartno').html(result).show();
					});
					
					var data = {jobno:jobno1,partnumber:critical2.val()};
					$.ajax({
						url : "dashboard.php?resp=resp_critical&action=saveCriticalMenu",
						type: "POST",
						data: data,
						success: function(data, status, xhr){
							//alert(data,status,xhr);
							//$('#tbl_installdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
							//$.post('get/critical/get_criticaldata.php', {
							//	nik : nik,
							//	jobno : jobno
							//},
							//function(result) {
							//	$('#tbl_installdesk').html(result).show();
							//});
							showdatacritical(jobno1);
						},
						failure : function(data, status, xhr){
								alert(data,status,xhr);
						}
					});
				}
				else{
						$('#tbl_scanpartno').html('<h4 class="warning" align="center" style="color: red; font-size: 50px;">SCAN SALAH</h4><audio controls autoplay hidden="hidden"><source src="asset/sound/scan_salah.mp3" type="audio/mp3"></audio>');
				}
				
				//if(jobno_len < 36){
				//	jobno2.focus();
				//}
				//else{
				//	critical.focus();
				//}
			}
			
			
		}
		return false; 
	}
    function showdatacritical(x){
		var jobno1 = $("#input-jobno").val();
		$('#tbl_critical').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/critical/get_critical_data.php', {
			jobno : jobno1
		},
		function(result) {
			$('#tbl_critical').html(result).show();
		});
	
			
	}
	/* function cancelInstall(x){
		partno_cancel = document.getElementById("partno_cancel"+x).value;
		zfeeder_cancel= document.getElementById("zfeeder_cancel"+x).value;
		pos_cancel    = document.getElementById("pos_cancel"+x).value;
		
		var data = {jobno:jobno,partnumber:partno_cancel,zfeeder:zfeeder_cancel,pos:pos_cancel,jdate:jdate};
		$.ajax({
			url : "dashboard.php?resp=resp_chkins_install&action=cancelInstall",
			type: "POST",
			data: data,
			success: function(data, status, xhr){
				//alert(data, status, xhr);
				$('#tbl_installdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
				$.post('get/install/2_get_smartInstallDesk.php', {
					nik : nik,
					jobno : jobno,
					feederno : rows
				},
				function(result) {
					$('#tbl_installdesk').html(result).show();
				});
			},
			failure : function(data, status, xhr){
					alert(data,status,xhr);
			}
		});
		
		$("#input-scnpartno-chk").focus();
		return false;
	}
	*/
    /*function on_panel_install(){
		if(document.getElementById("panel-install").style.display == "block"){
            document.getElementById("panel-install").style.display = "none";
        }
		else{
            document.getElementById("panel-install").style.display = "block";
		}
		$("#input-scnpartno-chk").focus();
		return false;
	}
	function prev_zfd(){
        if (rows == 1){
            alert('This is FIRST RECORD !');
        }
        else{
            prev = parseInt(rows)-parseInt(1);
            
			$.post('resp/install/start_install.php', {
				jobno_ins  : jobno,
				nik_ins    : nik,
				jdate_ins  : jdate,
				feederno   : prev
				},
				function(data, status) {
					if(status == "success"){
						var request_uri = location.pathname + location.search;
						var myarr = request_uri.split("/");
						var myvar = myarr[1];
						window.location.assign("/"+myvar+"/dashboard.php?operator=2_smartInstallDesk&nik="+nik+"&jobno="+jobno+"&row="+prev+"&count="+zfd_tot1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm2+"&process="+process+"&jdate="+jdate);
					}
					else{
						alert('Data not found !');
					}
				}
			);
		}
		$("#input-scnpartno-chk").focus();
		return false;
    }
	function next_zfd(){
        if (rows == zfd_tot1){
            alert('This is LAST RECORD !');
        }
        else{
            next = parseInt(rows)+parseInt(1);
			
			$.post('resp/install/start_install.php', {
				jobno_ins  : jobno,
				nik_ins    : nik,
				jdate_ins  : jdate,
				feederno   : next
				},
				function(data, status) {
					if(status == "success"){
						var request_uri = location.pathname + location.search;
						var myarr = request_uri.split("/");
						var myvar = myarr[1];
						window.location.assign("/"+myvar+"/dashboard.php?operator=2_smartInstallDesk&nik="+nik+"&jobno="+jobno+"&row="+next+"&count="+zfd_tot1+"&model="+model+"&serial="+serial+"&pwbnm="+pwbnm2+"&process="+process+"&jdate="+jdate);
					}
					else{
						alert('Data not found !');
					}
				}
			);
		}
		$("#input-scnpartno-chk").focus();
		return false;
    }
	
	function on_oll_install(){
		$("#ModalOLL").on("show", function() {    
			$("#ModalOLL a.btn").on("click", function(e) {
				$("#ModalOLL").modal('hide');     
			});
		});
		
		$("#ModalOLL").on("hide", function() {   $("#ModalOLL a.btn").off("click"); });
		$("#ModalOLL").on("hidden", function() { $("#ModalOLL").remove(); });
		$("#ModalOLL").modal({                    
		  "backdrop"  : "static",
		  "keyboard"  : true,
		  "show"      : true                     
		});
		
		$('#ModalTittle').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed + '&nbsp;</font><br>JOBNO : ' + jobno);
		$('#ModalTittle').css('text-align', 'center');
		$('#ModalTittle').css('font-size', '14px');
		$('#ModalTittle').css('font-weight', 'bold');
		$('#ModalIsi').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_install_oll.php', {
			jobno:jobno, zfeed:zfeed
		},
		function(result) { $('#ModalIsi').html(result).show(); });
	}
	*/
	/*function on_chk_feeder(){
		$("#ModalFeeder").on("show", function() {    
			$("#ModalFeeder a.btn").on("click", function(e) {
				$("#ModalFeeder").modal('hide');     
			});
		});
		
		$("#ModalFeeder").on("hide", function() {   $("#ModalFeeder a.btn").off("click"); });
		$("#ModalFeeder").on("hidden", function() { $("#ModalFeeder").remove(); });
		$("#ModalFeeder").modal({                    
		  "backdrop"  : "static",
		  "keyboard"  : true,
		  "show"      : true                     
		});
		
		$('#ModalTittleFeeder').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed + '&nbsp;</font><br>JOBNO : ' + jobno);
		$('#ModalTittleFeeder').css('text-align', 'center');
		$('#ModalTittleFeeder').css('font-size', '14px');
		$('#ModalTittleFeeder').css('font-weight', 'bold');
		$('#ModalIsiFeeder').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_chk_feeder.php', {
			jobno:jobno, zfeed:zfeed
		},
		function(result) { $('#ModalIsiFeeder').html(result).show(); });
	}
	*/
	//function dismismodal(){ $('.modal').modal('hide'); }
	
</script>

<div id="content">
	<div class="modal fade" id="ModalOLL" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header modalstyle-header">
					<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
					<h4 id="ModalTittle" class="modal-title"></h4>
				</div>
				<div class="modal-body modalstyle-body">
					<div id="ModalIsi" class="table table-responsive"></div>
				</div>
				<div class="modal-footer modalstyle-footer">
					<!--<button type="button" class="btn modalstyle-button" onclick="PosInsOK()">OK</button>-->
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ModalPos" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header modalstyle-header">
					<h2 id="ModalTittlePos" class="modalstyle-title"></h2>
				</div>
				<div class="modal-body modalstyle-body">
					<div id="ModalIsiPos" class="table table-responsive"></div>
				</div>
				<div id="ModalBottomPos" class="modal-footer modalstyle-footer">
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ModalFeeder" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header modalstyle-header">
					<h2 id="ModalTittleFeeder" class="modalstyle-title"></h2>
				</div>
				<div class="modal-body modalstyle-body">
					<div id="ModalIsiFeeder" class="table table-responsive"></div>
				</div>
				<div id="ModalBottomFeeder" class="modal-footer modalstyle-footer">
					<button type="button" class="modalstyle-close" onclick="dismismodal()">CLOSE</button>
				</div>
			</div>
		</div>
	</div>
	
	<div id="scan_partnumber" class="col-xs-12 col-sm-12 col-md-12">
		<label id="label-jobno" class="scanpos col-xs-4 col-sm-4 col-md-4">JOB NO</label>
		<input type="text" id="input-jobno" name="input-jobno" class="scanpos col-xs-6 col-sm-6 col-md-6" maxlength="36" onBlur="this.value=this.value.toUpperCase()" onkeypress="scanpartnoChk(event)" />
		<label id="label-critical2" class="scanpos col-xs-4 col-sm-4 col-md-4">CRITICAL SCAN</label>
		<input type="text" id="input-critical" name="input-critical" class="scanpos col-xs-6 col-sm-6 col-md-6" maxlength="38" onBlur="this.value=this.value.toUpperCase()" onkeypress="scanpartnoChk(event)" />
		
		<button type="button" class="btn btn-danger scanpos col-xs-10 col-sm-10 col-md-10" id="src_install" onclick="startjobno()">
			START JOB NUMBER
		</button>
		
		<label id="label-critical" name="label-critical"  class="show-critical col-xs-12 col-sm-12 col-md-12"></label>
	</div>
	<div  id="tbl_scanpartno" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
	<label id="label-jobno-show" name="label-jobno-show" class="show-jobno col-xs-12 col-sm-12 col-md-12"></label>
	<div id="tbl_critical" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</div>
<div class="col-lg-12">
<?php
	date_default_timezone_set('Asia/Jakarta');
	//include database connection
	include "../adodb/con_part_im.php";
	$jobno_zfd = isset($_GET['jobno']) ? $_GET['jobno'] : "";
	$jdate = isset($_GET['jdate']) ? $_GET['jdate'] : "";
	$fdno1 = isset($_GET['row']) ? $_GET['row'] : "0";
	$fdno = intval($fdno1)-1;
	if($fdno <= 0){
		$fdno = 0;
	}
	$sql_tot = "select count ( distinct zno_ins ) 
					from diff_zfeeder_install2('{$jobno_zfd}')";
	//				where sts_install = 1";
	$rs_tot = $db->Execute($sql_tot);
	$zfd_tot = $rs_tot->fields[0];
	$rs_tot->Close();
	
	$sql_zfeed = "select first 1 skip {$fdno} distinct zno_ins 
					from diff_zfeeder_install2('{$jobno_zfd}')
					group by zno_ins";
	//				where sts_install = 1
	$rs_zfeed = $db->Execute($sql_zfeed);
	$zfeed = $rs_zfeed->fields[0];
	$rs_zfeed->Close();
	
	$sql_minpos = "select distinct zfd from pn_install('{$jobno_zfd}')
					where zfd_no = (
						select MIN (distinct zfd_no)
						from pn_install('{$jobno_zfd}') 
						where zfeeder containing '{$zfeed}')
					and zfeeder containing '{$zfeed}'";
	$rs_minpos = $db->Execute($sql_minpos);
	$minpos = $rs_minpos->fields[0];
	$rs_minpos->Close();
	
	$sql_maxpos = "select distinct zfd from pn_install('{$jobno_zfd}')
					where zfd_no = (
						select MAX (distinct zfd_no)
						from pn_install('{$jobno_zfd}') 
						where zfeeder containing '{$zfeed}')
					and zfeeder containing '{$zfeed}'";
	$rs_maxpos = $db->Execute($sql_maxpos);
	$maxpos = $rs_maxpos->fields[0];
	$rs_maxpos->Close();
	
	$sql_conf = "select count(*) from confinstall
					where jobno = '{$jobno_zfd}'
					and jobdate = '{$jdate}'
					and zfd = '{$zfeed}'
					and confstart = 'OK'
					and confend = 'OK'";
	$rs_conf = $db->Execute($sql_conf);
	$conf = $rs_conf->fields[0];
	$rs_conf->Close();
	
	$db->Close();
	$db=null;
?>
</div>
