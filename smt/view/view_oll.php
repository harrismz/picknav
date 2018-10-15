<script type="text/javascript" src="../../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
    
	 var picknav_nik = '<?=$picknav_nik?>';
   
    $(document).ready(function(){
        
		//call jquery date
		if ( $('.dt')[0].type != 'date' ) $('.dt').datepicker({ dateFormat: 'yy-mm-dd' });
        
		//call data loading list
		$('#tbl_oll').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/view/get_oll.php', {
			src_sdate_oll : $('[name=""]').val(),
			src_edate_oll : $('[name=""]').val(),
			src_jobno_oll : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_oll').html(result).show();
		});
		
		return false;
    });
    function on_refresh_oll(){
		$('#tbl_oll').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
		$.post('get/view/get_oll.php', {
			src_sdate_oll : $('[name=""]').val(),
			src_edate_oll : $('[name=""]').val(),
			src_jobno_oll : $('[name=""]').val()
		},
		function(result) {
			$('#tbl_oll').html(result).show();
		});
		return false;     
	}
	function on_src_oll() {
		if(document.getElementById("show-src-oll").style.display == "block"){
            document.getElementById("show-src-oll").style.display = "none";
        }
		else{
            document.getElementById("show-src-oll").style.display = "block";
		}
	}
    function search_oll(){
        var sdate = document.getElementById("src-sdate");
		var edate = document.getElementById("src-edate");
		var model = document.getElementById("src-model");
		//var partno = document.getElementById("src-partno");
		var jobno = document.getElementById("src-jobno");
		
		if(sdate.value == "" && edate.value == "" && model.value == "" && jobno.value == ""){
			alert('Input the search category !');
			jobno.focus();
		}
		else if(sdate.value != "" && edate.value==""){
			alert('End Production Date must be fill !');
			edate.focus();
		}
		else if(sdate.value == "" && edate.value != ""){
			alert('Start Production Date must be fill !');
			sdate.focus();
		}
		else if(sdate.value > edate.value){
			alert('From Date larger than End Date / To Date !');
			sdate.focus();
		}
		else{
			$('#tbl_oll').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

			$.post('get/view/get_oll.php', {
				src_sdate : $('[name=src-sdate]').val(),
				src_edate : $('[name=src-edate]').val(),
                src_model : $('[name=src-model]').val(),
                //src_partno: $('[name=src-partno]').val(),
				src_jobno :	$('[name=src-jobno]').val()
			},
			function(result) {
				$('#tbl_oll').html(result).show();
			});
			document.getElementById("show-src-oll").style.display = "none";
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
	function olldetail(x){
		jobno  = document.getElementById("jobno"+x).value;
		model  = document.getElementById("model"+x).value;
		serial = document.getElementById("serial"+x).value;
		pwbnm  = document.getElementById("pwbnm"+x).value;
		process= document.getElementById("process"+x).value;
		jdate  = document.getElementById("jdate"+x).value;

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
        
        $('#title_tmp').html('JOBNO : ' + jobno);
        $('#title_tmp').css('text-align', 'center');
        $('#title_tmp').css('font-size', '14px');
        $('#title_tmp').css('font-weight', 'bold');
        $('#isi_tmp').html('<br><br><p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/view/get_slctoll.php', {jobno : jobno, model:model, serial:serial, pwbname:pwbnm, process:process, jdate:jdate},
        function(result) { $('#isi_tmp').html(result).show(); });
    }
	function slct_oll(){
		var table 		= document.getElementById("dt_zfeed_oll");
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
		if(total_zfeed >> 0){
			jobno  = document.getElementById("jobno3").value;
			zfeed  = cb;
			model  = document.getElementById("model3").value;
			serial = document.getElementById("serial3").value;
			pwbname= document.getElementById("pwbname3").value;
			proces = document.getElementById("proces3").value;
			jdate  = document.getElementById("jdate3").value;
			
			$.post('get/view/get_viewoll.php', {jobno:jobno, zfeed:zfeed, model:model, serial:serial, pwbname:pwbname, proces:proces, jdate:jdate, total:total_zfeed},
			function(result) { $('#tbl_oll').html(result).show(); });
			
			$('.modal').modal('hide');
		}
		else{
			alert("Checked Z-FEEDER to View OLL !");
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
				<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
				<h4 id="title_tmp" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div id="isi_tmp" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer">
				<button type="button" class="btn modalstyle-button" onclick="slct_oll()">Select Z-Feeder</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalOLLDetail" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header modalstyle-header">
				<button type="button" class="modalstyle-close" onclick="dismismodal()">&times;</button>
				<h4 id="title_tmp2" class="modal-title"></h4>
			</div>
			<div class="modal-body modalstyle-body">
				<div id="isi_tmp2" class="table table-responsive"></div>
			</div>
			<div class="modal-footer modalstyle-footer">
				<button type="button" class="btn modalstyle-button" onclick="startPicknav()">Start Picking Navigation</button>
			</div>
		</div>
	</div>
</div>
<!-- end modal -->

<div id="content">
	<div id="show-src-oll" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="date_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label  search-label-2" for="src-model">Model Name</label>
			<input type="text" class="form-control search-input-2" id="src-model" name="src-model" onBlur="this.value=this.value.toUpperCase()" placeholder="Model" />
			<label class="control-label search-label-2" for="src-jobno">Job No</label>
			<input type="text" class="form-control search-input-2" id="src-jobno" name="src-jobno" onBlur="this.value=this.value.toUpperCase()" placeholder="JOB NO / JOB ID"/>
		</div>
		<div id="model_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label search-label-2" for="src_sdate_instl">Start Date</label>
			<input type="date" class="form-control search-input-2 dt" id="src-sdate" name="src-sdate" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date" value="" />
			<label class="control-label search-label-2" for="src_edate_instl">End Date</label>
			<input type="date" class="form-control search-input-2 dt" id="src-edate" name="src-edate" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
		</div>
		<div id="model_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<button type="button" class="btn btn-default search-button-1" onclick="search_oll()">
				<span class="glyphicon glyphicon-search"></span>
				SEARCH
			</button>
		</div>
	</div>
	<div id="tbl_oll" class="table table-responsive"></div>
</div>
<!-- table loading list -->
</section>