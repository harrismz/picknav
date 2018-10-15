<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
    
	//create variable
	var jobno, model, serial, pwbname, proces, jdate, total_zfeed;
    var jobno2, model2, serial2, pwbname2, proces2, jdate2, total_zfeed2;
    var picknav_nik = '<?=$picknav_nik?>';
   
    $(document).ready(function(){
        
		//call jquery date
		if ( $('.dt')[0].type != 'date' ) $('.dt').datepicker({ dateFormat: 'yy-mm-dd' });
        
		//call data loading list
		$('#tbl_loadlist').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/picking/get_loading_list.php', {
			src_sdate_prepare : $('[name=""]').val(),
			src_edate_prepare : $('[name=""]').val(),
			src_jobno_prepare : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_loadlist').html(result).show();
		});
		
		return false;
    });
    
	function on_refresh(){
		$('#tbl_loadlist').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/picking/get_loading_list.php', {
			src_sdate_prepare : $('[name=""]').val(),
			src_edate_prepare : $('[name=""]').val(),
			src_jobno_prepare : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_loadlist').html(result).show();
		});
		return false;     
	}
	function popupJobDetail(x){
		jobno2  = document.getElementById("jobno1"+x).value;
		model2  = document.getElementById("model1"+x).value;
		serial2 = document.getElementById("serial1"+x).value;
		pwbname2= document.getElementById("pwbname1"+x).value;
		proces2 = document.getElementById("proces1"+x).value;
		jdate2  = document.getElementById("jdate1"+x).value;

        $("#ModalSelectJob").on("show", function() {    
            $("#ModalSelectJob a.btn").on("click", function(e) {
                $("#ModalSelectJob").modal('hide');     
            });
        });
        
        $("#ModalSelectJob").on("hide", function() {   $("#ModalSelectJob a.btn").off("click"); });
        $("#ModalSelectJob").on("hidden", function() { $("#ModalSelectJob").remove(); });
        $("#ModalSelectJob").modal({                    
          "backdrop"  : "static",
          "keyboard"  : true,
          "show"      : true                     
        });
        
        $('#title_tmp').html('JOBNO : ' + jobno2);
        $('#title_tmp').css('text-align', 'center');
        $('#title_tmp').css('font-size', '14px');
        $('#title_tmp').css('font-weight', 'bold');
        $('#isi_tmp').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        //$.post('operator/get_loading_list_detail.php', {jobno : jobno},
        $.post('get/picking/get_loading_list_selectjob.php', {jobno : jobno2, model:model2, serial:serial2, pwbname:pwbname2, proces:proces2, jdate:jdate2},
        function(result) { $('#isi_tmp').html(result).show(); });
    }
	/*function popupStartJob(x){
			jobno  = document.getElementById("jobno3"+x).value;
			zfeed  = document.getElementById("zfeed3"+x).value;
			model  = document.getElementById("model3"+x).value;
			serial = document.getElementById("serial3"+x).value;
			pwbname= document.getElementById("pwbname3"+x).value;
			proces = document.getElementById("proces3"+x).value;
			jdate  = document.getElementById("jdate3"+x).value;
			
			$("#ModalOLLDetail").on("show", function() {    
				$("#ModalOLLDetail a.btn").on("click", function(e) {
					$("#ModalOLLDetail").modal('hide');     
				});
			});
			
			$("#ModalOLLDetail").on("hide", function() {   $("#ModalOLLDetail a.btn").off("click"); });
			$("#ModalOLLDetail").on("hidden", function() { $("#ModalOLLDetail").remove(); });
			$("#ModalOLLDetail").modal({                    
			  "backdrop"  : "static",
			  "keyboard"  : true,
			  "show"      : true                     
			});
			
			$('#title_tmp2').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed + '&nbsp;</font><br>JOBNO : ' + jobno);
			$('#title_tmp2').css('text-align', 'center');
			$('#title_tmp2').css('font-size', '14px');
			$('#title_tmp2').css('font-weight', 'bold');
			$('#isi_tmp2').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
			$.post('operator/get_loading_list_detail.php', {jobno:jobno, zfeed:zfeed, model:model, serial:serial, pwbname:pwbname, proces:proces, jdate:jdate},
			//$.post('operator/get_loading_list_selectjob.php', {jobno : jobno, model:model, serial:serial, pwbname:pwbname, proces:proces, jdate:jdate},
			function(result) { $('#isi_tmp2').html(result).show(); });
		}
	function startPicknav(){
        //alert('TES : ' + picknav_nik + '____' + jobno);
        var width = $(window).width();
        //zfeed_pgr = zfeed.replace("#", "::");
        zfeed_spc = zfeed.split(' ').join('+');
        zfeed_pgr = zfeed_spc.split('#').join('::');
        
		zfeed_pgr2 = zfeed_pgr.split('::').join('#');
        zfeed_pgr3 = zfeed_pgr2.split('+').join(' ');
		
		
        if(confirm("Are you sure to Start this Loading List ?") == true){
		//	alert(zfeed_pgr);
			//alert('http://136.198.117.48/picknav/dashboard.php?operator=smartPickingDesk&nik='+picknav_nik+'&jobno='+jobno+'&zfeed='+zfeed_pgr+'&row=0&model='+model+'&serial='+serial+'&pwbnm='+pwbname+'&proces='+proces+'&jdate='+jdate+'&count=1000&ZFD='+zfeed_pgr3);
            //if(width < 963 ){
				alert('operator/start_picking.php'+jobno+'^'+jobno+'^'+zfeed+'^'+zfeed+'^^'+picknav_nik+'^'+jdate+'^'+jdate+'^'+total_zfeed);
                $.post('operator/start_picking.php', {jobno : jobno, zfeed:zfeed, nik : picknav_nik, jdate : jdate, total : total_zfeed},
				function(data, status) {
					//alert(data+"----"+status);
                });
                //window.location.assign("/picknav/dashboard.php?operator=smartPicking&nik="+picknav_nik+"&jobno="+jobno+"&zfeed="+zfeed_pgr+"&row=0&model="+model+"&serial="+serial+"&pwbnm="+pwbname+"&proces="+proces+"&jdate="+jdate);
            }else{
                $.post('operator/start_picking.php', {jobno : jobno, zfeed:zfeed, nik : picknav_nik, jdate : jdate}, function(data, status) {
                //alert(data+"----"+status);
                });
                window.location.assign("/picknav/dashboard.php?operator=smartPickingDesk&nik="+picknav_nik+"&jobno="+jobno+"&zfeed="+zfeed_pgr+"&row=0&model="+model+"&serial="+serial+"&pwbnm="+pwbname+"&proces="+proces+"&jdate="+jdate);
            }
            //window.location.assign("/picknav/operator/smartPicking.php&nik="+picknav_nik+"&jobno="+jobno);
        }
    }*/
	function on_srcprepare() {
		if(document.getElementById("show-src-prepare").style.display == "block"){
            document.getElementById("show-src-prepare").style.display = "none";
        }
		else{
            document.getElementById("show-src-prepare").style.display = "block";
		}
	}
    function search_prepare(){
        var sdate_prepare = document.getElementById("src_sdate_prepare");
		var edate_prepare = document.getElementById("src_edate_prepare");
		var jobno_prepare = document.getElementById("src_jobno_prepare");

        if(sdate_prepare.value != "" && edate_prepare.value==""){
            alert('End Date must be fill !');
            edate_prepare.focus();
        }
        else if(sdate_prepare.value == "" && edate_prepare.value!=""){
            alert('Start Production Date must be fill !');
            sdate_prepare.focus();
        }
        else if(sdate_prepare.value > edate_prepare.value){
            alert('From Date larger than End Date / To Date !');
            sdate_prepare.focus();
        }
        else{
            $('#tbl_loadlist').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

            $.post('get/picking/get_loading_list.php', {
                src_sdate_prepare : $('[name=src_sdate_prepare]').val(),
                src_edate_prepare : $('[name=src_edate_prepare]').val(),
                src_jobno_prepare : $('[name=src_jobno_prepare]').val()
            },
            function(result) {
                $('#tbl_loadlist').html(result).show();
            });
            document.getElementById("show-src-prepare").style.display = "none";
        }
        return false;
    }
	function checkAll(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = true;
				}
			}
		} 
		else {
			for (var i = 0; i < checkboxes.length; i++) {
				console.log(i)
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
		}
	}
	function selectjob(){
		var table 		= document.getElementById("dt_zfeed");
		var chk_arr 	=  document.getElementsByName("item[]");
		var chklength 	= chk_arr.length;
		var i = 0;
		var a = '';
		var total_zfeed = 0;
		var cb = "";
		for(i=0; i<chklength; i++)
		{
			if (chk_arr[i].checked) {
				cb 	= a + '' + chk_arr[i].value;
				a 	= a + '' + chk_arr[i].value + '|';
				total_zfeed++;
			}
		}
		//alert(cb);
		//window.location.href = ("dashboard.php?resp=resp_fixasset&action=delete&total="+total_zfeed+"&cb="+cb+"");
		
		
		if(total_zfeed >> 0){
			jobno  = document.getElementById("jobno3").value;
			zfeed  = cb;
			model  = document.getElementById("model3").value;
			serial = document.getElementById("serial3").value;
			pwbname= document.getElementById("pwbname3").value;
			proces = document.getElementById("proces3").value;
			jdate  = document.getElementById("jdate3").value;
			
			$("#ModalOLLDetail").on("show", function() {    
				$("#ModalOLLDetail a.btn").on("click", function(e) {
					$("#ModalOLLDetail").modal('hide');     
				});
			});
			
			//alert(jobno+''+model+''+serial+''+pwbname+''+proces+''+jdate+''+zfeed+''+total_zfeed);
			
			$("#ModalOLLDetail").on("hide", function() {   $("#ModalOLLDetail a.btn").off("click"); });
			$("#ModalOLLDetail").on("hidden", function() { $("#ModalOLLDetail").remove(); });
			$("#ModalOLLDetail").modal({                    
			  "backdrop"  : "static",
			  "keyboard"  : true,
			  "show"      : true                     
			});
			
			$('#title_tmp2').html(' Z-FEEDER : <font style="background-color: #008080;color: #fff;">&nbsp;' + zfeed + '&nbsp;</font><br>JOBNO : ' + jobno);
			$('#title_tmp2').css('text-align', 'center');
			$('#title_tmp2').css('font-size', '14px');
			$('#title_tmp2').css('font-weight', 'bold');
			$('#isi_tmp2').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
			$.post('get/picking/get_loading_list_detail.php', {jobno:jobno, zfeed:zfeed, model:model, serial:serial, pwbname:pwbname, proces:proces, jdate:jdate, total:total_zfeed},
			//$.post('operator/get_loading_list_selectjob.php', {jobno : jobno, model:model, serial:serial, pwbname:pwbname, proces:proces, jdate:jdate},
			function(result) { $('#isi_tmp2').html(result).show(); });
		}
		else{
			alert("Checked Z-FEEDER to Picking Part !");
		}
		
		
		
		
		
	}
	function startPicknav(){
        //alert('TES : ' + picknav_nik + '____' + jobno);
		var width = $(window).width();
		zfeed_spc = zfeed.split(' ').join('+');
        zfeed_pgr = zfeed_spc.split('#').join('::');
        if(confirm("Are you sure to Start this Loading List ?") == true){
			//alert(total_zfeed);
            if(width < 963 ){
                $.post('resp/picking/start_picking.php', {jobno : jobno, zfeed:zfeed_pgr, nik : picknav_nik, jdate : jdate}, function(data, status) {
                //alert(data+"----"+status);
					if(status == "success"){
						window.location.assign("/picknav/dashboard.php?operator=smartPicking&nik="+picknav_nik+"&jobno="+jobno+"&zfeed="+zfeed_pgr+"&row=0&model="+model+"&serial="+serial+"&pwbnm="+pwbname+"&proces="+proces+"&jdate="+jdate);}
					else{
						alert('Data not found !');
					}
                });
            }else{
                $.post('resp/picking/start_picking.php', {jobno : jobno, zfeed:zfeed_pgr, nik : picknav_nik, jdate : jdate}, function(data, status) {
					//alert(data+"----"+status);
					if(status == "success"){
						window.location.assign("/picknav/dashboard.php?operator=smartPickingDesk&nik="+picknav_nik+"&jobno="+jobno+"&zfeed="+zfeed_pgr+"&row=0&model="+model+"&serial="+serial+"&pwbnm="+pwbname+"&proces="+proces+"&jdate="+jdate);
					}
					else{
						alert('Data not found !');
					}
                });
            }
            //window.location.assign("/picknav/operator/smartPicking.php&nik="+picknav_nik+"&jobno="+jobno);
        }
    }
    function dismismodal(){
		$('.modal').modal('hide');
	}
	
</script>

<!-- modal -->
<div class="modal fade" id="ModalSelectJob" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header modalstyle-header">
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
				<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
				<h4 id="title_tmp" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div id="isi_tmp" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer">
				<button type="button" class="btn modalstyle-button" onclick="selectjob()">Select ZFeeder</button>
				<!--<button type="button" class="btn btn-danger" data-dismiss="modal">Exit</button>-->
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalOLLDetail" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header modalstyle-header">
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
				<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
				<h4 id="title_tmp2" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div id="isi_tmp2" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer">
				<!--<button type="button" class="btn btn-danger" data-dismiss="modal">Exit</button>-->
				<button type="button" class="btn modalstyle-button" onclick="startPicknav()">Start Picking Navigation</button>
			</div>
		</div>
	</div>
</div>
<!-- end modal -->

<section id="content">
	<!-- search operator prepare -->
	<div id="show-src-prepare" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<tr>
				<td>
					<label class="control-label search-label-2" for="src_sdate_prepare">Start Date</label>
					<input type="date" class="form-control search-input-2 dt" id="src_sdate_prepare" name="src_sdate_prepare" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date"/>
					<label class="control-label search-label-2" for="src_jobno_prepare">Job No</label>
					<input type="text" class="form-control search-input-2" id="src_jobno_prepare" name="src_jobno_prepare" onBlur="this.value=this.value.toUpperCase()" placeholder="Job No."/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="control-label search-label-2" for="src_edate_prepare">End Date</label>
					<input type="date" class="form-control search-input-2 dt" id="src_edate_prepare" name="src_edate_prepare" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
					<button type="button" class="btn btn-default search-button-2" id="src_prepare" onclick="search_prepare()">
						<span class="glyphicon glyphicon-search"></span>
						SEARCH
					</button>
				</td>
			</tr>
		</table>
	</div>
	<!-- table loading list -->
	<div id="tbl_loadlist" class="table table-responsive col-xs-12 col-sm-12 col-md-12"></div>
</section>