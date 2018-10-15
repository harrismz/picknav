<div id="content">
	<div id="show-src-partno" class="panel-picknav col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div id="date_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label  search-label" for="src-partno">Part No</label>
			<input type="text" class="form-control search-input" id="src-partno" name="src-partno" onBlur="this.value=this.value.toUpperCase()" placeholder="Part Number" />
			<label class="control-label search-label" for="src-jobno">Job No</label>
			<input type="text" class="form-control search-input" id="src-jobno" name="src-jobno" onBlur="this.value=this.value.toUpperCase()" placeholder="JOB NO / JOB ID"/>
			<label class="control-label  search-label" for="src-model">Model Name</label>
			<input type="text" class="form-control search-input" id="src-model" name="src-model" onBlur="this.value=this.value.toUpperCase()" placeholder="Model" />
			</div>
		<div id="model_search" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<label class="control-label search-label" for="src_sdate_instl">Start Date</label>
			<input type="date" class="form-control search-input dt" id="src-sdate" name="src-sdate" onBlur="this.value=this.value.toUpperCase()" placeholder="Start Date" value="" />
			<label class="control-label search-label" for="src_edate_instl">End Date</label>
			<input type="date" class="form-control search-input dt" id="src-edate" name="src-edate" onBlur="this.value=this.value.toUpperCase()" placeholder="End Date"/>
			<button type="button" class="btn btn-default search-button" onclick="search_partno()">
				<span class="glyphicon glyphicon-search"></span>
				SEARCH
			</button>
		</div>
	</div>
	<div id="tbl_partno" class="table table-responsive"></div>
</div>
<script type="text/javascript" src="../bootstrap/jquery/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
	var n =  new Date();
	var y = n.getFullYear();
	var m = n.getMonth() + 1;
	var d = n.getDate();
	if (m < 10){ m = '0'+m; }
	else {m=m;}
	var s = y+'-'+m+'-'+d;
	
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
	
		var sdt   = getUrlVars()["s"];
		var edt   = getUrlVars()["e"];
	
		
	$(document).ready(function(){
		if ( $('.dt')[0].type != 'date' ) $('.dt').datepicker({ dateFormat: 'yy-mm-dd' });
		if(sdt==null && edt == null){
			document.getElementById("src-sdate").value = s;
			document.getElementById("src-edate").value = s;
		}
		else{
			document.getElementById("src-sdate").value = sdt;
			document.getElementById("src-edate").value = edt;
		}
		
		
		$('#tbl_partno').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/partno/get_partno.php', {
            src_sdate 	: $('[name=src-sdate]').val(),
            src_edate 	: $('[name=src-edate]').val(),
            src_model	: "",
            src_partno	: "",
            src_jobno	: ""
        },
        function(result) {
            $('#tbl_partno').html(result).show();
        });
		
		return false;
	});	
	function on_refresh(){
		
		if(sdt==null && edt == null){
			document.getElementById("src-sdate").value = s;
			document.getElementById("src-edate").value = s;
		}
		else{
			document.getElementById("src-sdate").value = sdt;
			document.getElementById("src-edate").value = edt;
		}
		
		
		$('#tbl_partno').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');
        $.post('get/partno/get_partno.php', {
           src_sdate : $('[name=src-sdate]').val(),
           src_edate : $('[name=src-edate]').val(),
           src_model : "",
           src_partno: "",
           src_jobno : ""
        },
        function(result) {
            $('#tbl_partno').html(result).show();
        });
        document.getElementById("src-jobno").value = "";
        document.getElementById("src-partno").value = "";
        document.getElementById("src-model").value = "";
        document.getElementById("show-src-partno").style.display = "none";
        return false;     
	}
	function on_search() {
		if(document.getElementById("show-src-partno").style.display == "block"){
			document.getElementById("date_search").style.display = "none";
            document.getElementById("model_search").style.display = "none";
			document.getElementById("show-src-partno").style.display = "none";
        }
		else if(document.getElementById("show-src-partno").style.display == "none"){
			document.getElementById("date_search").style.display = "block";
            document.getElementById("model_search").style.display = "block";
			document.getElementById("show-src-partno").style.display = "block";
		}
		return false;
	}
    function search_partno(){
        var sdate = document.getElementById("src-sdate");
		var edate = document.getElementById("src-edate");
		var model = document.getElementById("src-model");
		var partno = document.getElementById("src-partno");
		var jobno = document.getElementById("src-jobno");
		
		if(sdate.value == "" && edate.value == "" && model.value == "" && partno.value == "" && jobno.value == ""){
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
			$('#tbl_partno').html('<p align="center" class="loading"><img src="asset/img/giphy.gif" alt="Loading" height="100" width="100"/></p>');

			$.post('get/partno/get_partno.php', {
				src_sdate : $('[name=src-sdate]').val(),
				src_edate : $('[name=src-edate]').val(),
                src_model : $('[name=src-model]').val(),
                src_partno: $('[name=src-partno]').val(),
				src_jobno :	$('[name=src-jobno]').val()
			},
			function(result) {
				$('#tbl_partno').html(result).show();
			});
			document.getElementById("show-src-partno").style.display = "none";
		}
		return false;
	}
	
</script>