<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
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
	<div id="panel-install" class="panel-picknav">
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
			<button class="btn-previous-zfd" onclick="prev_zfd()">
				<i class="fa fa-arrow-left fa-lg"></i>
				<br><br>PREV
				<br><font style="font-size:12px !important;">Z-FEEDER</font>
			</button>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="border : solid #fa8f46 2px;">
			<h4 id="zfeed_header" align="center"></h4>
			<h4 id="PosInsMin" align="center"></h4>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="border : solid #fa8f46 2px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><h4 id="jobno_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="model_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="serial_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="pwbnm_header" align="center"></h4></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h4 id="proces_header" align="center"></h4></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
			<button class="btn-previous-zfd" onclick="next_zfd()">
				<i class="fa fa-arrow-right fa-lg"></i>
					<br><br>NEXT
					<br><font style="font-size:12px !important;">Z-FEEDER</font>
			</button>
        </div>
		
		&nbsp;
	</div>
	
	<div id="scan_partnumber" class="col-xs-12 col-sm-12 col-md-12">
		<div id="rb_install" class="btn-group col-xs-12 col-sm-12 col-md-12" data-toggle="buttons">
			<div class="container">
			  <div class="radio-tile-group">
				<div class="input-container" id="c_partno">
				  <input id="chk_partno" class="radio-button" type="radio" name="radio" />
				  <div class="radio-tile">
					<label for="partno" class="radio-tile-label">REEL SCAN</label>
				  </div>
				</div>
				<div class="input-container" id="c_critical">
				  <input id="chk_critical" class="radio-button" type="radio" name="radio" />
				  <div class="radio-tile">
					<label for="critical" class="radio-tile-label">CRITICAL PART</label>
				  </div>
				</div>
			  </div>
			</div>
		</div>
		<label id="label-scnpartno-chk" class="col-xs-4 col-sm-4 col-md-4">PART NUMBER</label>
		<input type="text" id="input-scnpartno-chk" name="input-scnpartno-chk" maxlength="64" onBlur="this.value=this.value.toUpperCase()" onkeypress="scanpartnoChk(event)" autofocus />
		<label id="label-scnpartno" name="label-scnpartno"  class="col-xs-12 col-sm-12 col-md-12"></label>
	</div>
	<div  id="tbl_scanpartno" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
	<div id="tbl_installdesk" class="table-responsive col-xs-12 col-sm-12 col-md-12"></div>
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
<script type="text/javascript">
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
	}
	
	var nik        = getUrlVars()["nik"];
	var jobno      = getUrlVars()["jobno"];
	var model      = getUrlVars()["model"];
	var serial     = getUrlVars()["serial"];
	var pwbnm2     = getUrlVars()["pwbnm"];
	var pwbnm      = pwbnm2.split('%20').join(' ');
	var process    = getUrlVars()["process"];
	var jdate      = getUrlVars()["jdate"];
	
	var rows  		= getUrlVars()["row"];
	var zfeed    	= "<?php echo $zfeed;?>";
	var zfd_tot 	= <?php echo $zfd_tot;?>;
    var zfd_tot1 	= parseInt(zfd_tot);
	
	var minpos    	= "<?php echo $minpos;?>";
	var maxpos    	= "<?php echo $maxpos;?>";
	
	var confinstall = "<?php echo $conf;?>";
							
    $(document).ready(function(){

		$('#tbl_installdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_smartInstallDesk.php', {
			nik : nik,
            jobno : jobno,
            feederno : rows
		},
		function(result) {
			$('#tbl_installdesk').html(result).show();
		});
        document.getElementById("PosInsMin").innerHTML = "<b><font color='#008080'>START POS</font><br><font style='font-size: 30px;'> "+minpos+" - "+maxpos+"</font></b>";
		document.getElementById("zfeed_header").innerHTML = "<b><font color='#008080'>Z-FEEDER</font><br><br><font style='font-size: 30px;'>"+zfeed+"</font></b>";
        document.getElementById("jobno_header").innerHTML = "<b><font color='#008080'>JOB NO</font><br>"+jobno+"</b>";
        document.getElementById("model_header").innerHTML = "<b><font color='#008080'>MODEL : </font>"+model+"</b>";
        document.getElementById("serial_header").innerHTML = "<b><font color='#008080'>SERIAL : </font>"+serial+"</b>";
        document.getElementById("pwbnm_header").innerHTML = "<b><font color='#008080'>PWB NAME : </font>"+pwbnm+"</b>";
        document.getElementById("proces_header").innerHTML = "<b><font color='#008080'>PROCESS : </font>"+process+"</b>";
        $("#input-scnpartno-chk").focus();
		
		if(confinstall == 0){
			$("#ModalPos").on("show", function() {    
				$("#ModalPos a.btn").on("click", function(e) {
					$("#ModalPos").modal('hide');     
				});
			});
			
			$("#ModalPos").on("hide", function() {   $("#ModalPos a.btn").off("click"); });
			$("#ModalPos").on("hidden", function() { $("#ModalPos").remove(); });
			$("#ModalPos").modal({                    
			  "backdrop"  : "static",
			  "keyboard"  : true,
			  "show"      : true                     
			});
			
			$('#ModalTittlePos').html('JOBNO : <font style>' + jobno + '<br>Z-FEEDER : &nbsp;' + zfeed );
			$('#ModalTittlePos').css('text-align', 'center');
			$('#ModalIsiPos').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
			$.post('get/install/get_install_conf.php', { jobno:jobno, zfeed:zfeed, jdate:jdate },
			function(result) { $('#ModalIsiPos').html(result).show(); });
		}
		return false;
	});
	
	var arrstatus = [];
	function insConf(x){
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
	
    function on_refresh_install(){
        $('#tbl_installdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/install/2_get_smartInstallDesk.php', {
			snik : nik,
            jobno : jobno,
            feederno : rows
		},
		function(result) {
			$('#tbl_installdesk').html(result).show();
		});
		$("#input-scnpartno-chk").focus();
		return false;    
	}
    function on_finishing_install(){
		
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
    function scanpartnoChk(event){
		var x = event.which || event.keyCode;
		var sprtno = $('#input-scnpartno-chk');
		var sprtno2 = $('#label-scnpartno');
		
		//contoh barcode reel
		//CK73FXR0J226M 9 30001977359109
		//CK73GXR1H104K 9 4000197030815E
		//CK73FBB0J106K 9 30001969114101
		//CK73HBB1A104K 910000195842410X
		//RK73GB2A000J  9 50002012866128
			
		if(x == 13) {
			var prtno = sprtno.val();
			var lenpartno = prtno.length;
			
			sprtno2.val(prtno);
			if(lenpartno == 16){
				var feeder1 = prtno.substr(0,9);
				var feeder2 = prtno.substr(10,6);
				var feeder3 = feeder1+''+feeder2;
				document.getElementById("label-scnpartno").innerHTML = feeder3;
			}
			else{
				document.getElementById("label-scnpartno").innerHTML = prtno.substr(0,15);
			}
			
			sprtno.val("");
			sprtno.focus();
			var sprtno3 = sprtno2.val();
			var scncount = (sprtno3.length)+1;
			
			var chk_partno = $('#chk_partno').prop('checked');
			var chk_critical = $('#chk_critical').prop('checked');
			
		
			
			//random color
			var colors = ['#3f51b5','#2196f3','#e91e63','#9c27b0','#263238','#ff3d00'];
			var random_color = colors[Math.floor(Math.random() * colors.length)];
			$('#label-scnpartno').css('color', random_color);
			$('#label-scnpartno').css('border-bottom', '3px solid '+random_color);
			
				
			if(chk_partno == false && chk_critical == false){
				if(scncount == 17) {
					//alert(scncount);
					$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
					$.post('get/feeder/get_scanFeeder.php', {
						snik : nik,
						jobno : jobno,
						feederno : rows,
						scanpartno : sprtno2.val()
					},
					function(result) {
						$('#tbl_scanpartno').html(result).show();
					});
					
					var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
					$.ajax({
						url : "dashboard.php?resp=resp_feeder&action=saveFeederInstall",
						type: "POST",
						data: data,
						success: function(data, status, xhr){
							//alert(data,status,xhr);
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
				}
				else{
					$('#tbl_scanpartno').html('<h4 class="warning" align="center" style="color: red; font-size: 50px;">FEEDER TIDAK ADA</h4><audio controls autoplay hidden="hidden"><source src="asset/sound/fider_tidak_ada.mp3" type="audio/mp3"></audio>');
				}
			}
			else if(chk_partno == true && chk_critical == false){
				//alert(chk_partno+'---'+chk_critical);
				if(scncount == 17 && scncount <= 25) {
					//alert(scncount);
					$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
					$.post('get/feeder/get_scanFeeder.php', {
						snik : nik,
						jobno : jobno,
						feederno : rows,
						scanpartno : sprtno2.val()
					},
					function(result) {
						$('#tbl_scanpartno').html(result).show();
					});
					
					var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
					$.ajax({
						url : "dashboard.php?resp=resp_feeder&action=saveFeederInstall",
						type: "POST",
						data: data,
						success: function(data, status, xhr){
							//alert(data,status,xhr);
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
				}
				else if(scncount != 17 && scncount >= 30) {
					$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
					$.post('get/install/2_get_scanInstall.php', {
						snik : nik,
						jobno : jobno,
						feederno : rows,
						scanpartno : sprtno2.val()
					},
					function(result) {
						$('#tbl_scanpartno').html(result).show();
					});
					
					var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
					$.ajax({
						url : "dashboard.php?resp=resp_chkins_install&action=saveInstall",
						type: "POST",
						data: data,
						success: function(data, status, xhr){
							//alert(data,status,xhr);
							$('#tbl_installdesk').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
							$.post('get/install/2_get_smartInstallDesk.php', {
								nik : nik,
								jobno : jobno,
								model : model,
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
				}
				else{
					$('#tbl_scanpartno').html('<h4 class="warning" align="center" style="color: red; font-size: 50px;">PART TIDAK ADA</h4><audio controls autoplay hidden="hidden"><source src="asset/sound/PART_TIDAK_ADA.mp3" type="audio/mp3"></audio>');
				}
			}
			else if(chk_partno == false && chk_critical == true){
				//alert(chk_partno+'---'+chk_critical);
				if(scncount == 17 && scncount <=25) {
					$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
					$.post('get/feeder/get_scanFeeder.php', {
						snik : nik,
						jobno : jobno,
						feederno : rows,
						scanpartno : sprtno2.val()
					},
					function(result) {
						$('#tbl_scanpartno').html(result).show();
					});
					
					var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
					$.ajax({
						url : "dashboard.php?resp=resp_feeder&action=saveFeederInstall",
						type: "POST",
						data: data,
						success: function(data, status, xhr){
							//alert(data,status,xhr);
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
				}
				else if(scncount >= 38) {
					$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
					$.post('get/critical/get_scanCritical.php', {
						snik : nik,
						jobno : jobno,
						feederno : rows,
						scanpartno : sprtno2.val()
					},
					function(result) {
						$('#tbl_scanpartno').html(result).show();
					});
					
					var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
					$.ajax({
						url : "dashboard.php?resp=resp_critical&action=saveCriticalInstall",
						type: "POST",
						data: data,
						success: function(data, status, xhr){
							//alert(data,status,xhr);
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
				}
				else{
					$('#tbl_scanpartno').html('<h4 class="warning" align="center" style="color: red; font-size: 50px;">CRITICAL TIDAK ADA</h4><audio controls autoplay hidden="hidden"><source src="asset/sound/critical_TIDAK_ADA.mp3" type="audio/mp3"></audio>');
				}
			}
			
			/*
			if(scncount == 17 && scncount != 38) {
				$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
				$.post('get/feeder/get_scanFeeder.php', {
					snik : nik,
					jobno : jobno,
					feederno : rows,
					scanpartno : sprtno2.val()
				},
				function(result) {
					$('#tbl_scanpartno').html(result).show();
				});
				
				var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
				$.ajax({
					url : "dashboard.php?resp=resp_feeder&action=saveFeederInstall",
					type: "POST",
					data: data,
					success: function(data, status, xhr){
						//alert(data,status,xhr);
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
			}
			else if(scncount == 38) {
				$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
				$.post('get/critical/get_scanCritical.php', {
					snik : nik,
					jobno : jobno,
					feederno : rows,
					scanpartno : sprtno2.val()
				},
				function(result) {
					$('#tbl_scanpartno').html(result).show();
				});
				
				var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
				$.ajax({
					url : "dashboard.php?resp=resp_critical&action=saveCriticalInstall",
					type: "POST",
					data: data,
					success: function(data, status, xhr){
						//alert(data,status,xhr);
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
			}
			else if(scncount >= 30 && scncount != 38) {
				$('#tbl_scanpartno').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
				$.post('get/install/2_get_scanInstall.php', {
					snik : nik,
					jobno : jobno,
					feederno : rows,
					scanpartno : sprtno2.val()
				},
				function(result) {
					$('#tbl_scanpartno').html(result).show();
				});
				
				var data = {jdate:jdate,jobno:jobno,partnumber:sprtno2.val(),feederno:rows};
				$.ajax({
					url : "dashboard.php?resp=resp_chkins_install&action=saveInstall",
					type: "POST",
					data: data,
					success: function(data, status, xhr){
						//alert(data,status,xhr);
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
			}
			else{
				$('#tbl_scanpartno').html('<h4 class="warning" align="center" style="color: red; font-size: 50px;">PART TIDAK ADA</h4><audio controls autoplay hidden="hidden"><source src="asset/sound/PART_TIDAK_ADA.mp3" type="audio/mp3"></audio>');
			}
			*/
		}
		$("#input-scnpartno-chk").focus();
		return false; 
	}
    function cancelInstall(x){
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
    function on_panel_install(){
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
	function on_chk_feeder(){
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
	function on_chk_critical(){
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
		$.post('get/install/2_get_chk_critical.php', {
			jobno:jobno, zfeed:zfeed
		},
		function(result) { $('#ModalIsiFeeder').html(result).show(); });
	}
	function dismismodal(){ $('.modal').modal('hide'); }
	
</script>
