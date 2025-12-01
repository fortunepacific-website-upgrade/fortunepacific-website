<?php
require_once(dirname(__FILE__).'/verification.class.php');

$session_id=$_REQUEST['gt'];
$challenge=$_REQUEST['challenge'];

$error=0;

if($session_id && $challenge){
	$VerCode=new VerCode();
	if($VerCode->check()){
		if($session_id==$_COOKIE['session_id']){
			$_SESSION['Ueeshop']['VerCode']=$challenge;
			$_SESSION['v_code_check']='ok';
			echo "ok";
		}else{
			$error=1;
		}
	}else{
		$error=1;
	}
}else{
	$error=1;
}


if($error==1){
	$_SESSION['v_code_check']='error';
	echo "error";
}
?>
