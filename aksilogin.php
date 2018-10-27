<?php
    session_start();
	date_default_timezone_set('Asia/Jakarta');
	include '../adodb/con_picknav.php';

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $user   = isset($_POST['picknav_username']) ? $_POST['picknav_username'] : '';
    $passwd  = isset($_POST['picknav_password']) ? $_POST['picknav_password'] : '';
	$date    = date("Y-m-d");
    $time    = date('H:i:s');
	
	if($action == 'login') {
		if(empty($user) && empty($passwd)){
            header('location:index.php?warning=errlog');
        }
        elseif($user == 'Username' || $passwd == 'Password'){
            header('location:index.php?warning=errlog');
        }
        elseif(isset($user) && isset($passwd)){
            
			$sql = "select pic, levelno, disabled, nik from usertable
					   where userid = '{$user}' and passwid = '{$passwd}'";
			$rs = $db->Execute($sql);
			
			
            if(!$rs->EOF){
				
				$_SESSION['picknav_pic']     = trim($rs->fields[0]);
				$_SESSION['picknav_levelno'] = trim($rs->fields[1]);
				$_SESSION['picknav_disabled']= trim($rs->fields[2]);
				$_SESSION['picknav_nik']     = trim($rs->fields[3]);
				
				$picname     = trim($rs->fields[0]);
				$piclevel    = trim($rs->fields[1]);
				$picnik      = trim($rs->fields[3]);
				
				$sql = "insert into PICLOGIN (NIK, NAME, AKSESDATE, AKSESTIME, STATUS, AKSES) 
						values('{$picnik}','{$picname}','{$date}','{$time}','LOGIN','{$piclevel}')";
				$rs = $db->Execute($sql);
				
				if($_SESSION['picknav_levelno'] == 2 && $_SESSION['picknav_disabled'] == 0){
				   header('location:dashboard.php?smt=home');
				}
				elseif($_SESSION['picknav_levelno'] == 3 && $_SESSION['picknav_disabled'] == 0){
				   header('location:dashboard.php?operator=home');
				}
				else{
				   header('location:dashboard.php');
				}
			}
            else{
               header('location:index.php?warning=wrong');
            }
        }
    }
    elseif( $action == 'logout' ){
		$picname     = trim($_SESSION['picknav_pic']);
		$piclevel    = trim($_SESSION['picknav_levelno']);
		$picnik      = trim($_SESSION['picknav_nik']); 
		
		$sql = "insert into PICLOGIN (NIK, NAME, AKSESDATE, AKSESTIME, STATUS, AKSES) 
				values('{$picnik}','{$picname}','{$date}','{$time}','LOGOUT','{$piclevel}')";
		$rs = $db->Execute($sql);
		
        unset($_SESSION['picknav_pic']);
        unset($_SESSION['picknav_levelno']);
        unset($_SESSION['picknav_disabled']);
        unset($_SESSION['picknav_nik']);
        header('location:index.php');
    }
	
$rs->Close();
?>