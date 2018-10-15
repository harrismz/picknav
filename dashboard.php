<?php
session_start();
if (!isset($_SESSION)) {
    ob_start();
	session_start();
    ob_end_clean();
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$host = "http://$_SERVER[HTTP_HOST]$_SERVER[DOCUMENT_ROOT]";
date_default_timezone_set('Asia/Jakarta');

//session call
$picknav_pic     	= isset($_SESSION['picknav_pic']) ? $_SESSION['picknav_pic'] : '';
$picknav_levelno 	= isset($_SESSION['picknav_levelno']) ? $_SESSION['picknav_levelno'] : '';
$picknav_disabled	= isset($_SESSION['picknav_disabled']) ? $_SESSION['picknav_disabled'] : '';
$picknav_nik     	= isset($_SESSION['picknav_nik']) ? $_SESSION['picknav_nik'] : '';
$cekjudul 			= isset($_GET['operator']) ? $_GET['operator'] : '';

//body
?>
    <!DOCTYPE html>
    <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7">

        <!--head-->
        <head>
            <title>PICKING NAVIGATION SYSTEM</title>
            <link rel="shortcut icon" href="asset/icon/check.ico"/>

            <!--charset db-->
            <meta charset="utf-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="google" value="notranslate"/>
            <meta http-equiv="refresh" content="1800"; URL="{$actual_link}" />

            <!--bootstrap-->
			<meta name="mobile-web-app-capable" content="yes" />
            <meta name="viewport"  content="width=device-width, initial-scale=1" /> <!-- for detection width resolution -->
            <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

            <!--css-->
		    <link rel="stylesheet" type="text/css" href="../bootstrap/jquery/jquery-ui/jquery-ui.css">
            <link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="asset/css/style.css">
	    </head>
        <!--====-->

        <!--body-->
        <body>
		    <?php if(empty($picknav_pic) && $picknav_levelno <> '4'){  ?>

				<section id="httperror">
                    <h1 id="httpcode">401.2</h1>
                    <h1 id="httpcode2">UNAUTHORIZED</h1>
                    <h1 id="errorcontent">You are not logged in</h1>
                    <br>
                    <h4>
						<a href="index.php">
							click here for LOGIN
						</a>
					</h4>
                </section>


            <?php } elseif($picknav_pic != "" && $picknav_levelno == "2"){ ?>

                <aside>
					<?php include "navigation.php"; ?>
				</aside>

                <section class="main">
                    <?php
                        if(!empty($_GET['smt'])){
                            $SMT_dir = 'smt';
                            $SMT_dir1 = 'picking';
                            $SMT_dir2 = 'install';
                            $SMT_dir3 = 'checked';
                            $SMT_dir4 = 'partno';
                            $SMT_dir5 = 'limit';
                            $SMT_dir6 = 'view';
                            $SMTpages = scandir($SMT_dir, 0);
                            unset($SMTpages[0], $SMTpages[1]);

                            $SMT = $_GET['smt'];
                            if($SMT == "home"){
                                echo'<div class="fixedtitle">';
								echo'<div id="titleDashHome" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
										<font> S M T&nbsp;&nbsp;&nbsp;C O N T R O L&nbsp;&nbsp;&nbsp;P A R T </font>
									</div>';
								echo'</div>';
                                echo'<div class="footer">
									<font> S M T&nbsp;&nbsp;&nbsp;N A V I G A T I O N&nbsp;&nbsp;&nbsp;S Y S T E M&nbsp;&nbsp;&nbsp;ver.1.9 </font>
								</div>';
                            }
                            elseif($SMT == "smt_picknav"){
                                echo'<div class="fixedtitle">';
								echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
										<font>
											SMT CONTROL PART ( P I C K I N G )
										</font>
									</div>';
                                echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh()">
										<i class="fa fa-refresh fa-lg"></i>
										&nbsp;&nbsp;REFRESH
									</button>
                                    <button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_search()">
										<i class="fa fa-search fa-lg"></i>
										&nbsp;&nbsp;SEARCH
									</button>';
								  echo'</div>';
						    }
                            elseif($SMT == "2_install"){
                                echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
											<font>
												SMT CONTROL PART ( I N S T A L L )
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>
										<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_search()">
											<i class="fa fa-search fa-lg"></i>
											&nbsp;&nbsp;SEARCH
										</button>';
								echo'</div>';
						    }
							elseif($SMT == "partno"){
                                echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
											<font>
												SMT CONTROL PART ( P A R T  N O )
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_search()">
											<i class="fa fa-search fa-lg"></i>
											&nbsp;&nbsp;SEARCH
										</button>';
								echo'</div>';
						    }
                            elseif($SMT == "limit"){
                                echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
											<font>
												SMT CONTROL PART ( L I M I T )
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_search()">
											<i class="fa fa-search fa-lg"></i>
											&nbsp;&nbsp;SEARCH
										</button>';
								echo'</div>';
						    }
							else if($SMT == "view_oll"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												O&nbsp;U&nbsp;T&nbsp;S&nbsp;E&nbsp;T&nbsp;&nbsp;&nbsp;L&nbsp;O&nbsp;A&nbsp;D&nbsp;I&nbsp;N&nbsp;G&nbsp;&nbsp;&nbsp;L&nbsp;I&nbsp;S&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_oll()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_oll()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
								echo'</div>';
							}
							else if($SMT == "feeder_check"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												F&nbsp;E&nbsp;E&nbsp;D&nbsp;E&nbsp;R&nbsp;&nbsp;&nbsp;R&nbsp;E&nbsp;C&nbsp;O&nbsp;R&nbsp;D
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_oll()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_oll()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
								echo'</div>';
							}
	                        else if($SMT == "critical_check"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												C&nbsp;R&nbsp;I&nbsp;T&nbsp;I&nbsp;C&nbsp;A&nbsp;L&nbsp;&nbsp;&nbsp;R&nbsp;E&nbsp;C&nbsp;O&nbsp;R&nbsp;D
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_oll()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_oll()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
								echo'</div>';
							}
                               
                            elseif($SMT == "commingsoon"){
                                ?><img id="mtc" src="asset/img/comingsoon.png"></img><?php
                            }
							 elseif($SMT == "maintenance"){
                                ?><img id="mtc" src="asset/img/underc.png"></img><?php
                            }

                            if( in_array($SMT.'.php', $SMTpages) )	{ include($SMT_dir.'/'.$SMT.'.php'); }
                            elseif( $SMT == "smt_picknav" )			{ include($SMT_dir.'/'.$SMT_dir1.'/'.$SMT.'.php'); }
							elseif( $SMT == "2_install" )			{ include($SMT_dir.'/'.$SMT_dir2.'/'.$SMT.'.php'); }
							elseif($SMT == "3_checked")				{ include($SMT_dir.'/'.$SMT_dir3.'/'.$SMT.'.php'); }
							elseif($SMT == "partno")				{ include($SMT_dir.'/'.$SMT_dir4.'/'.$SMT.'.php'); }
							elseif($SMT == "limit")					{ include($SMT_dir.'/'.$SMT_dir5.'/'.$SMT.'.php'); }
							elseif($SMT == "view_oll")				{ include($SMT_dir.'/'.$SMT_dir6.'/'.$SMT.'.php'); }
                        }
						elseif(!empty($_GET['resp'])){
                            $RESP_dir = 'resp';
                            $RESP_dir1 = 'picking';
                            $RESP_dir2 = 'install';
                            $RESP_dir3 = 'checked';
                            $RESP_dir4 = 'partno';
                            $RESPpages = scandir($RESP_dir, 0);
                            unset($RESPpages[0], $RESPpages[1]);

                            $RESP = $_GET['resp'];
                            if(in_array($RESP.'.php', $RESPpages)){ include($RESP_dir.'/'.$RESP.'.php'); }
                            elseif($RESP == "start_picking"
									or $RESP == "resp_passjobno"
									or $RESP == "resp_pickingCheck"
									or $RESP == "resp_sumFinish"
									or $RESP == "resp_unfinish"
									or $RESP == "resp_unpass"
									or $RESP == "finishing_prepare"
								){
									include($RESP_dir.'/'.$RESP_dir1.'/'.$RESP.'.php');
							}
							elseif($RESP == "start_install"
									or $RESP == "resp_instalCheck"
									or $RESP == "2_finishing_install"
									or $RESP == "prevnext_install"
									or $RESP == "resp_chkins_install"
									or $RESP == "resp_passed"
									or $RESP == "resp_unpass_ins"
									or $RESP == "resp_unfinish_install"
									or $RESP == "confirm"
								){
									include($RESP_dir.'/'.$RESP_dir2.'/'.$RESP.'.php');
							}
							elseif($RESP == "start_checked"
									or $RESP == "resp_checkedCheck"
									or $RESP == "3_finishing_checked"
									or $RESP == "prevnext_checked"
									or $RESP == "resp_chkins_checked"
									or $RESP == "confirm_chk"
								){
									include($RESP_dir.'/'.$RESP_dir3.'/'.$RESP.'.php');
							}
							elseif($RESP == "resp_chkins_ket"){
								include($RESP_dir.'/'.$RESP_dir3.'/'.$RESP.'.php');
							}
                            else{ echo 'RESP_dir PAGE NOT FOUND!'; }
                        }
                        elseif(!empty($_GET['get'])){
                            $GET_dir = 'get';
                            $GETpages = scandir($GET_dir, 0);
                            unset($GETpages[0], $GETpages[1]);

                            $GET = $_GET['get'];
                            if(in_array($GET.'.php', $GETpages)){
								include($GET_dir.'/'.$GET.'.php');
							}
                            elseif($GET == "get_joblist"
									or $GET == "get_detail_zfeeder"
									or $GET == "get_detailSmartPicking"
									or $GET == "get_jobdetail_zfeeder"
							){
								include($GET_dir.'/'.$GET_dir1.'/'.$GET.'.php');
							}
                            else{
								echo 'GET_dir ADMIN NOT FOUND!';
							}
                        }
                        elseif(!empty($_GET['operator'])){
							$UN_dir = 'operator';
                            $UNpages = scandir($UN_dir, 0);
                            unset($UNpages[0], $UNpages[1]);

                            $UN = $_GET['operator'];
                            if(in_array($UN.'.php', $UNpages)){
								header('location:dashboard.php?smt=home');
							}
                            else{
								header('location:dashboard.php?smt=home');
							}
                        }
                        else {
							header('location:'.$actual_link);
						}
                    ?>
                </section>
            <?php }
			elseif($picknav_pic != "" && $picknav_levelno == "3" && $cekjudul <> 'chkrpl'){ ?>
                <aside>
					<?php include "navigation.php"; ?>
				</aside>
                <section class="main">
                    <?php
						if(!empty($_GET['operator'])){
							$OPT_dir = 'operator';
							$OPT_dir1 = 'picking';
							$OPT_dir2 = 'install';
							$OPT_dir3 = 'checked';
							$OPT_dir4 = 'view';
							$OPT_dir5 = 'critical';
							$OPTpages = scandir($OPT_dir, 0);
                            unset($OPTpages[0], $OPTpages[1]);

							$OPT = $_GET['operator'];
							if($OPT == "home"){
                                echo'<div class="fixedtitle">';
								echo'<div id="titleDashHome" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
										<font> S M T&nbsp;&nbsp;&nbsp;C O N T R O L&nbsp;&nbsp;&nbsp;P A R T </font>
									</div>';
								echo'</div>';
                                echo'<div class="footer">
									<font> S M T&nbsp;&nbsp;&nbsp;N A V I G A T I O N&nbsp;&nbsp;&nbsp;S Y S T E M&nbsp;&nbsp;&nbsp;ver.1.9 </font>
								</div>';
                            }
                            elseif($OPT == "loading_list"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												P&nbsp;I&nbsp;C&nbsp;K&nbsp;I&nbsp;N&nbsp;G&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH PART
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_srcprepare()">
											<i class="fa fa-search fa-lg"></i>
											&nbsp;&nbsp;SEARCH PART
										</button>';
								echo'</div>';
							}
							else if($OPT == "smartPickingDesk"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												P&nbsp;I&nbsp;C&nbsp;K&nbsp;I&nbsp;N&nbsp;G&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-4 col-sm-4 col-md-4 col-lg-4" onclick="on_smartpick()">
											<i class="fa fa-mobile-phone fa-lg"></i>
											&nbsp;&nbsp;MOBILE PICKING MODE
										</button>';
									echo'<button class="btn btn-title col-xs-4 col-sm-4 col-md-4 col-lg-4" onclick="on_refresh_parlist()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH PART
										</button>';
									echo'<button class="btn btn-title col-xs-4 col-sm-4 col-md-4 col-lg-4" onclick="on_finishing_prepare()">
											<i class="fa fa-check fa-lg"></i>
											&nbsp;&nbsp;FINISHING PART
										</button>';
								echo'</div>';
							}
							elseif($OPT == "2_install_data"){
								echo'<div class="fixedtitle">';
										echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><font>I&nbsp;N&nbsp;S&nbsp;T&nbsp;A&nbsp;L&nbsp;L&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T</font></div>';
										echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_installdata()"><i class="fa fa-refresh fa-lg"></i>&nbsp;&nbsp;REFRESH INSTALLATION</button>';
										echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_installdata()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH INSTALLATION</button>';
								echo'</div>';
							}
							else if($OPT == "2_smartInstallDesk"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												I&nbsp;N&nbsp;S&nbsp;T&nbsp;A&nbsp;L&nbsp;L&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-2 col-sm-2 col-md-2 col-lg-2" onclick="on_refresh_install()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH INSTALL
										</button>';
									echo'<button class="btn btn-title col-xs-2 col-sm-2 col-md-2 col-lg-2" onclick="on_oll_install()">
											<i class="fa fa-file-text fa-lg"></i>
											&nbsp;&nbsp;&nbsp;VIEW OLL
										</button>';
									echo'<button class="btn btn-title col-xs-2 col-sm-2 col-md-2 col-lg-2" onclick="on_chk_feeder()">
											<i class="fa fa-check-square fa-lg"></i>
											&nbsp;&nbsp;&nbsp;CHECK FEEDER
										</button>';
									echo'<button class="btn btn-title col-xs-2 col-sm-2 col-md-2 col-lg-2" onclick="on_chk_critical()">
											<i class="fa fa-check-square fa-lg"></i>
											&nbsp;&nbsp;&nbsp;CRITICAL
										</button>';
									echo'<button class="btn btn-title col-xs-2 col-sm-2 col-md-2 col-lg-2" onclick="on_panel_install()">
											<i class="fa fa-arrow-left fa-lg"></i>
											&nbsp;&nbsp;&nbsp;DETAIL&nbsp;&nbsp;&nbsp;
											<i class="fa fa-arrow-right fa-lg"></i>
										</button>';
									echo'<button class="btn btn-title col-xs-2 col-sm-2 col-md-2 col-lg-2" onclick="on_finishing_install()">
											<i class="fa fa-check fa-lg"></i>
											&nbsp;&nbsp;FINISHING INSTALL
										</button>';
								echo'</div>';
							}
							else if($OPT == "2_install_zfeeder"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												I&nbsp;N&nbsp;S&nbsp;T&nbsp;A&nbsp;L&nbsp;L&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_installzfeeder()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH INSTALLATION
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_finishing_installzfeeder()">
											<i class="fa fa-check fa-lg"></i>
											&nbsp;&nbsp;FINISHING INSTALLATION
										</button>';
								echo'</div>';
							}
							elseif($OPT == "3_checked"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												C&nbsp;H&nbsp;E&nbsp;C&nbsp;K&nbsp;E&nbsp;D&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_checked()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH INSTALLATION
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_checked()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH INSTALLATION</button>';
								echo'</div>';
							}
							else if($OPT == "3_checkedDesk"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><font>C&nbsp;H&nbsp;E&nbsp;C&nbsp;K&nbsp;E&nbsp;D&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T</font></div>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_refresh_checked()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_oll_checked()">
											<i class="fa fa-file-text fa-lg"></i>
											&nbsp;&nbsp;&nbsp;VIEW OLL
										</button>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_panel_checked()">
											<i class="fa fa-arrow-left fa-lg"></i>
											&nbsp;&nbsp;&nbsp;DETAIL&nbsp;&nbsp;&nbsp;
											<i class="fa fa-arrow-right fa-lg"></i>
										</button>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_finishing_checked()">
											<i class="fa fa-check fa-lg"></i>
											&nbsp;&nbsp;FINISH
										</button>';
								echo'</div>';
							}
							else if($OPT == "view_oll"){
									echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												O&nbsp;U&nbsp;T&nbsp;S&nbsp;E&nbsp;T&nbsp;&nbsp;&nbsp;L&nbsp;O&nbsp;A&nbsp;D&nbsp;I&nbsp;N&nbsp;G&nbsp;&nbsp;&nbsp;L&nbsp;I&nbsp;S&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_oll()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_oll()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
								echo'</div>';
							}
							else if($OPT == "critical_data"){
									echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												C&nbsp;R&nbsp;I&nbsp;T&nbsp;I&nbsp;C&nbsp;A&nbsp;L&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_oll()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_oll()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
								echo'</div>';
							}
							elseif($OPT == "commingsoon"){
								?><img id="mtc" src="asset/img/comingsoon.png"></img><?php
							}
							elseif($OPT == "maintenance"){
								?><img id="mtc" src="asset/img/underc.png"></img><?php
							}

							if(in_array($OPT.'.php', $OPTpages)){ include($OPT_dir.'/'.$OPT.'.php'); }
							elseif($OPT == "loading_list" or $OPT == "smartPicking" or $OPT == "smartPickingDesk"){
								include($OPT_dir.'/'.$OPT_dir1.'/'.$OPT.'.php');
							}
							elseif($OPT == "2_install_zfeeder" or $OPT == "2_smartInstallDesk" or $OPT == "2_install_data"){
								include($OPT_dir.'/'.$OPT_dir2.'/'.$OPT.'.php');
							}
							elseif($OPT == "3_checked" or $OPT == "3_checkedDesk"){
								include($OPT_dir.'/'.$OPT_dir3.'/'.$OPT.'.php');
							}
							elseif($OPT == "view_oll"){
								include($OPT_dir.'/'.$OPT_dir4.'/'.$OPT.'.php');
							}
							elseif($OPT == "critical_data"){
								include($OPT_dir.'/'.$OPT_dir5.'/'.$OPT.'.php');
							}
            }
            elseif(!empty($_GET['resp'])){
                $RESP_dir = 'resp';
                $RESP_dir1 = 'picking';
                $RESP_dir2 = 'install';
                $RESP_dir3 = 'checked';
                $RESP_dir5 = 'critical';
                $RESP_dir6 = 'feeder';
                $RESPpages = scandir($RESP_dir, 0);
                unset($RESPpages[0], $RESPpages[1]);

							$RESP = $_GET['resp'];
                            if(in_array($RESP.'.php', $RESPpages)){ include($RESP_dir.'/'.$RESP.'.php'); }
							elseif($RESP == "start_picking"
									or $RESP == "resp_passjobno"
									or $RESP == "resp_pickingCheck"
									or $RESP == "resp_sumFinish"
									or $RESP == "resp_unfinish"
									or $RESP == "finishing_prepare"
								){
									include($RESP_dir.'/'.$RESP_dir1.'/'.$RESP.'.php');
							}
							elseif($RESP == "start_install"
									or $RESP == "resp_instalCheck"
									or $RESP == "2_finishing_install"
									or $RESP == "prevnext_install"
									or $RESP == "resp_chkins_install"
								){
									include($RESP_dir.'/'.$RESP_dir2.'/'.$RESP.'.php');
							}
							elseif($RESP == "start_checked"
									or $RESP == "resp_checkedCheck"
									or $RESP == "3_finishing_checked"
									or $RESP == "prevnext_checked"
									or $RESP == "resp_chkins_checked"
								){
									include($RESP_dir.'/'.$RESP_dir3.'/'.$RESP.'.php');
							}
							elseif($RESP == "resp_chkins_ket"){
								include($RESP_dir.'/'.$RESP_dir3.'/'.$RESP.'.php');
							}
							elseif($RESP == "resp_critical"){
								include($RESP_dir.'/'.$RESP_dir5.'/'.$RESP.'.php');
							}
                            elseif($RESP == "resp_feeder"){
								include($RESP_dir.'/'.$RESP_dir6.'/'.$RESP.'.php');
							}
                            else{ echo 'RESP_dir PAGE NOT FOUND!'; }
                        }
                        elseif(!empty($_GET['smt'])){
							$UNO_dir = 'smt';
                            $UNOpages = scandir($UNO_dir, 0);
                            unset($UNOpages[0], $UNOpages[1]);

                            $UNO = $_GET['smt'];
                            if(in_array($UNO.'.php', $UNOpages))
							{ header('location:dashboard.php?operator=home'); }
                            else{ header('location:dashboard.php?operator=home'); }
                        }
                        else {header('location:'.$actual_link);}
                    ?>
                </section>
            <?php } 
			elseif($picknav_pic == "" && $picknav_levelno == "4"){ ?>
                <aside>
					<?php 
						if(!empty($_GET['operator'])){
							$CHKRPL_nav = $_GET['operator'];
							if($CHKRPL_nav != "chkrpl"){
								include "navigation_chkrpl.php"; 
							}
							else{
								include "navigation_chkrpl_login.php"; 
							}
						}
					?>
				</aside>
                <section class="main">
                    <?php
						if(!empty($_GET['operator'])){
							$CHKRPL_dir = 'operator/checknreplace';
							$CHKRPL_dir1 = 'fullscan';
							$CHKRPL_dir2 = 'partscan';
							$CHKRPL_dir3 = 'rplpart';
							$CHKRPL_dir4 = 'rplfeeder';
							$CHKRPLpages = scandir($CHKRPL_dir, 0);
                            unset($CHKRPLpages[0], $CHKRPLpages[1]);

							$CHKRPL = $_GET['operator'];
							if($CHKRPL == "chkrpl"){
                                echo'<div class="fixedtitle">';
								echo'<div id="titleDashHome" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
										<font> S M T&nbsp;&nbsp;&nbsp;C O N T R O L&nbsp;&nbsp;&nbsp;P A R T </font>
									</div>';
								echo'</div>';
                                echo'<div class="footer">
									<font> S M T&nbsp;&nbsp;&nbsp;N A V I G A T I O N&nbsp;&nbsp;&nbsp;S Y S T E M&nbsp;&nbsp;&nbsp;ver.1.9 </font>
								</div>';
                            }elseif($CHKRPL == "chkrpl_old"){
                                echo'<div class="fixedtitle">';
								echo'<div id="titleDashHome" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 title">
										<font> S M T&nbsp;&nbsp;&nbsp;C O N T R O L&nbsp;&nbsp;&nbsp;P A R T </font>
									</div>';
								echo'</div>';
                                echo'<div class="footer">
									<font> S M T&nbsp;&nbsp;&nbsp;N A V I G A T I O N&nbsp;&nbsp;&nbsp;S Y S T E M&nbsp;&nbsp;&nbsp;ver.1.9 </font>
								</div>';
                            }
							elseif($CHKRPL == "commingsoon"){
								?><img id="mtc" src="asset/img/comingsoon.png"></img><?php
							}
							elseif($CHKRPL == "maintenance"){
								?><img id="mtc" src="asset/img/underc.png"></img><?php
							}
							elseif($CHKRPL == "chkfull" or $CHKRPL == "chkfull_old"){
								if(!empty($_GET['bar']) and !empty($_GET['t'])){
									$bar = $_GET['bar'];
									$t = $_GET['t'];
									if ($bar != 'select' and $t != 'select'){
										echo'<div class="fixedtitle">';
											echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<font>
														F&nbspU&nbsp;L&nbsp;L&nbsp;&nbsp;&nbsp;C&nbsp;H&nbsp;E&nbsp;C&nbsp;K&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
													</font>
												</div>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_checked()">
													<i class="fa fa-refresh fa-lg"></i>
													&nbsp;&nbsp;REFRESH
												</button>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_checked()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
										echo'</div>';
									}
									elseif ( $bar == 'select'){
										echo'<div class="fixedtitle">';
											echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<font>
														P&nbsp;I&nbsp;L&nbsp;I&nbsp;H&nbsp;&nbsp;&nbsp;J&nbsp;E&nbsp;N&nbsp;I&nbsp;S&nbsp;&nbsp;&nbsp;B&nbsp;A&nbsp;R&nbsp;C&nbsp;O&nbsp;D&nbsp;E&nbsp;&nbsp;&nbsp;S&nbsp;C&nbsp;A&nbsp;N
													</font>
												</div>';
										echo'</div>';
									}
									elseif ( $t == 'select'){
										echo'<div class="fixedtitle">';
											echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<font>
														P&nbsp;I&nbsp;L&nbsp;I&nbsp;H&nbsp;&nbsp;&nbsp;T&nbsp;A&nbsp;B&nbsp;E&nbsp;L&nbsp;/&nbsp;Z&nbsp;F&nbsp;E&nbsp;E&nbsp;D&nbsp;E&nbsp;R
													</font>
												</div>';
										echo'</div>';
									}
								}
							}
							elseif($CHKRPL == "chkfullDesk"){
								echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><font>	F&nbspU&nbsp;L&nbsp;L&nbsp;&nbsp;&nbsp;C&nbsp;H&nbsp;E&nbsp;C&nbsp;K&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
									</font></div>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_refresh_checked()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_oll_checked()">
											<i class="fa fa-file-text fa-lg"></i>
											&nbsp;&nbsp;&nbsp;VIEW OLL
										</button>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_panel_checked()">
											<i class="fa fa-arrow-left fa-lg"></i>
											&nbsp;&nbsp;&nbsp;DETAIL&nbsp;&nbsp;&nbsp;
											<i class="fa fa-arrow-right fa-lg"></i>
										</button>';
									echo'<button class="btn btn-title col-xs-3 col-sm-3 col-md-3 col-lg-3" onclick="on_finishing_checked()">
											<i class="fa fa-check fa-lg"></i>
											&nbsp;&nbsp;FINISH
										</button>';
								echo'</div>';
							}
							elseif($CHKRPL == "chkpart"){
								if(!empty($_GET['bar']) and !empty($_GET['t'])){
									$bar = $_GET['bar'];
									$t = $_GET['t'];
									if ($bar != 'select' or $t != 'select'){
										echo'<div class="fixedtitle">';
											echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<font>
														C&nbspH&nbsp;E&nbsp;C&nbsp;K&nbsp&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
													</font>
												</div>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_checked()">
													<i class="fa fa-refresh fa-lg"></i>
													&nbsp;&nbsp;REFRESH
												</button>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_checked()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
										echo'</div>';
									}
								}
							}
							elseif($CHKRPL == "rplpart"){
								if(!empty($_GET['bar'])){
									$bar = $_GET['bar'];
									if ($bar != 'select'){
										echo'<div class="fixedtitle">';
											echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<font>
														R&nbspE&nbsp;P&nbsp;L&nbsp;A&nbspC&nbsp;E&nbsp;&nbsp;&nbsp;P&nbsp;A&nbsp;R&nbsp;T
													</font>
												</div>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_checked()">
													<i class="fa fa-refresh fa-lg"></i>
													&nbsp;&nbsp;REFRESH
												</button>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_checked()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
										echo'</div>';
									}
								}
							}
							elseif($CHKRPL == "rplfeeder"){
								if(!empty($_GET['bar'])){
									$bar = $_GET['bar'];
									if ($bar != 'select'){
										echo'<div class="fixedtitle">';
											echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<font>
														R&nbspE&nbsp;P&nbsp;L&nbsp;A&nbspC&nbsp;E&nbsp;&nbsp;&nbsp;F&nbsp;E&nbsp;E&nbsp;D&nbsp;E&nbsp;R
													</font>
												</div>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_checked()">
													<i class="fa fa-refresh fa-lg"></i>
													&nbsp;&nbsp;REFRESH
												</button>';
											echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_checked()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
										echo'</div>';
									}
								}
							}
							else if($CHKRPL == "view_oll"){
									echo'<div class="fixedtitle">';
									echo'<div id="titleDash" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<font>
												O&nbsp;U&nbsp;T&nbsp;S&nbsp;E&nbsp;T&nbsp;&nbsp;&nbsp;L&nbsp;O&nbsp;A&nbsp;D&nbsp;I&nbsp;N&nbsp;G&nbsp;&nbsp;&nbsp;L&nbsp;I&nbsp;S&nbsp;T
											</font>
										</div>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_refresh_oll()">
											<i class="fa fa-refresh fa-lg"></i>
											&nbsp;&nbsp;REFRESH
										</button>';
									echo'<button class="btn btn-title col-xs-6 col-sm-6 col-md-6 col-lg-6" onclick="on_src_oll()"><i class="fa fa-search fa-lg"></i>&nbsp;&nbsp;SEARCH</button>';
								echo'</div>';
							}
							

							if(in_array($CHKRPL.'.php', $CHKRPLpages)){ include($CHKRPL_dir.'/'.$CHKRPL.'.php'); }
							elseif($CHKRPL == "chkfull" or $CHKRPL == "chkfull_old"){
								if(!empty($_GET['bar'])){
									$bar = $_GET['bar'];
									if ($bar == 'select'){
										include($CHKRPL_dir.'/'.$CHKRPL_dir1.'/selectbarcode.php');
									}
									elseif(!empty($_GET['t'])){
										$bar = $_GET['t'];
										if ($bar == 'select'){
											include($CHKRPL_dir.'/'.$CHKRPL_dir1.'/selecttable.php');
										}
										else{
											include($CHKRPL_dir.'/'.$CHKRPL_dir1.'/'.$CHKRPL.'.php');
										}
									}
									else{
										include($CHKRPL_dir.'/'.$CHKRPL_dir1.'/'.$CHKRPL.'.php');
									}
								}
							}
							elseif($CHKRPL == "chkpart"){
								if(!empty($_GET['bar'])){
									$bar = $_GET['bar'];
									if ($bar == 'select'){
										include($CHKRPL_dir.'/'.$CHKRPL_dir2.'/selectbarcode.php');
									}
									else{
										include($CHKRPL_dir.'/'.$CHKRPL_dir2.'/'.$CHKRPL.'.php');
									}
								}
							}
							elseif($CHKRPL == "rplpart"){
								if(!empty($_GET['bar'])){
									$bar = $_GET['bar'];
									if ($bar == 'select'){
										include($CHKRPL_dir.'/'.$CHKRPL_dir3.'/selectbarcode.php');
									}
									else{
										include($CHKRPL_dir.'/'.$CHKRPL_dir3.'/'.$CHKRPL.'.php');
									}
								}
							}
							elseif($CHKRPL == "rplfeeder"){
								if(!empty($_GET['bar'])){
									$bar = $_GET['bar'];
									if ($bar == 'select'){
										include($CHKRPL_dir.'/'.$CHKRPL_dir4.'/selectbarcode.php');
									}
									else{
										include($CHKRPL_dir.'/'.$CHKRPL_dir4.'/'.$CHKRPL.'.php');
									}
								}
							}
							elseif($CHKRPL == "chkrpl_old"){
								include($CHKRPL_dir.'/'.$CHKRPL.'.php');
							}
							elseif($CHKRPL == "view_oll" or $CHKRPL == "view_oll"){
								include($CHKRPL_dir.'/'.$CHKRPL_dir4.'/'.$CHKRPL.'.php');
							}
						}
						elseif(!empty($_GET['resp'])){
							$RESP_dir = 'resp';
							$RESP_dir1 = 'picking';
							$RESP_dir2 = 'install';
							$RESP_dir3 = 'checked';
							$RESPpages = scandir($RESP_dir, 0);
							unset($RESPpages[0], $RESPpages[1]);

							$RESP = $_GET['resp'];
                            if(in_array($RESP.'.php', $RESPpages)){ include($RESP_dir.'/'.$RESP.'.php'); }
							elseif($RESP == "start_picking"
									or $RESP == "resp_passjobno"
									or $RESP == "resp_pickingCheck"
									or $RESP == "resp_sumFinish"
									or $RESP == "resp_unfinish"
									or $RESP == "finishing_prepare"
								){
									include($RESP_dir.'/'.$RESP_dir1.'/'.$RESP.'.php');
							}
							elseif($RESP == "start_install"
									or $RESP == "resp_instalCheck"
									or $RESP == "2_finishing_install"
									or $RESP == "prevnext_install"
									or $RESP == "resp_chkins_install"
								){
									include($RESP_dir.'/'.$RESP_dir2.'/'.$RESP.'.php');
							}
							elseif($RESP == "start_checked"
									or $RESP == "resp_checkedCheck"
									or $RESP == "3_finishing_checked"
									or $RESP == "prevnext_checked"
									or $RESP == "resp_chkins_checked"
								){
									include($RESP_dir.'/'.$RESP_dir3.'/'.$RESP.'.php');
							}
							elseif($RESP == "resp_chkins_ket"){
								include($RESP_dir.'/'.$RESP_dir3.'/'.$RESP.'.php');
							}
                            else{ echo 'RESP_dir PAGE NOT FOUND!'; }
                        }
                        elseif(!empty($_GET['smt'])){
							$UNO_dir = 'smt';
                            $UNOpages = scandir($UNO_dir, 0);
                            unset($UNOpages[0], $UNOpages[1]);

                            $UNO = $_GET['smt'];
                            if(in_array($UNO.'.php', $UNOpages))
							{ header('location:dashboard.php?operator=home'); }
                            else{ header('location:dashboard.php?operator=home'); }
                        }
                        else {header('location:'.$actual_link);}
                    ?>
                </section>
            <?php } ?>
		</body>
        <!--====-->

        <!--script-->
        <script  type="text/javascript" src="../bootstrap/jquery/jquery-1.12.0.min.js"></script>
        <script  type="text/javascript" src="../bootstrap/jquery/jquery-ui/jquery-ui.js"></script>
        <script  type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function getUrlVars() {
				var vars = {};
				var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
					vars[key] = value;
				});
				return vars;
			}
			var smt = getUrlVars()["smt"];
			var operator = getUrlVars()["operator"];

			$(document).ready(function(){

				if(	smt == "smt_picknav" ||
					operator == "loading_list" || operator == "smartPickingDesk"  || operator == "smartPicking" ){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("pickingClick");
					$("#titleDash").addClass("pickingClick");
					$("#pickingMenu").addClass("pickingClick");
					$(".modalstyle-header").addClass("pickingClick");
					$(".modalstyle-footer").addClass("pickingClick");
					$("#dt_loadlist").addClass("pickingClick");
				}
				else if(  smt == "2_install" ||
						operator == "2_install_data" || operator == "2_smartInstallDesk"){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("installClick");
					$("#titleDash").addClass("installClick");
					$("#installMenu").addClass("installClick");
					$(".modalstyle-header").addClass("installClick");
					$(".modalstyle-footer").addClass("installClick");
				}
				else if( smt == "3_checked" ||
						operator == "3_checked" || operator == "3_checkedDesk" || 
						operator == "chkfull" || operator == "chkfull_old" || operator == "chkfullDesk"){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("checkedClick");
					$("#titleDash").addClass("checkedClick");
					$("#checkedMenu").addClass("checkedClick");
					$(".modalstyle-header").addClass("checkedClick");
					$(".modalstyle-footer").addClass("checkedClick");
				}
				else if( smt == "view_oll" ){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("pickingClick");
					$("#titleDash").addClass("pickingClick");
					$("#viewMenu").addClass("pickingClick");
					$(".modalstyle-header").addClass("pickingClick");
					$(".modalstyle-footer").addClass("pickingClick");
				}
				else if( operator == "chkpart" || operator == "chkpartDesk"){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("chkpartClick");
					$("#titleDash").addClass("chkpartClick");
					$("#chkpartMenu").addClass("chkpartClick");
					$(".modalstyle-header").addClass("chkpartClick");
					$(".modalstyle-footer").addClass("chkpartClick");
				}
				else if( operator == "rplpart" || operator == "rplpartDesk"){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("replaceClick");
					$("#titleDash").addClass("replaceClick");
					$("#replaceMenu").addClass("replaceClick");
					$(".modalstyle-header").addClass("replaceClick");
					$(".modalstyle-footer").addClass("replaceClick");
				}
				else if( operator == "rplfeeder" || operator == "rplfeederDesk"){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("rplfeederClick");
					$("#titleDash").addClass("rplfeederClick");
					$("#rplfeederMenu").addClass("rplfeederClick");
					$(".modalstyle-header").addClass("rplfeederClick");
					$(".modalstyle-footer").addClass("rplfeederClick");
				}
				else if( smt == "partno" ){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("partnoClick");
					$("#titleDash").addClass("partnoClick");
					$("#partnoMenu").addClass("partnoClick");
					$(".modalstyle-header").addClass("partnoClick");
					$(".modalstyle-footer").addClass("partnoClick");
				}
				else if( smt == "limit" ){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("limitClick");
					$("#titleDash").addClass("limitClick");
					$("#limitMenu").addClass("limitClick");
					$(".modalstyle-header").addClass("limitClick");
					$(".modalstyle-footer").addClass("limitClick");
				}
				else if( operator == "view_oll" ){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick");
					//add
					$("#brand").addClass("pickingClick");
					$("#titleDash").addClass("pickingClick");
					$("#viewMenu").addClass("pickingClick");
					$(".modalstyle-header").addClass("pickingClick");
					$(".modalstyle-footer").addClass("pickingClick");
				}
				else if( operator == "critical_data" ){
					//remove
					$("#brand, #titleDash, #partnoMenu, #pickingMenu, #installMenu, #checkedMenu, #replaceMenu, #limitMenu,#chkpartMenu,#rplfeederMenu,#criticalMenu")
					.removeClass("partnoClick pickingClick installClick checkedClick replaceClick limitClick chkpartClick rplfeederClick criticalClick");
					//add
					$("#brand").addClass("criticalClick");
					$("#titleDash").addClass("criticalClick");
					$("#criticalMenu").addClass("criticalClick");
					$(".modalstyle-header").addClass("criticalClick");
					$(".modalstyle-footer").addClass("criticalClick");
				}
				/*$("#pickingMenu").click(function(){
					//add class
					$("#brand").addClass("pickingClick");
					$("#titleDash").addClass("pickingClick");
					$("#pickingMenu").addClass("pickingClick");
				});*/


				return false;
			});
		</script>
		<!--====-->
    </html>
