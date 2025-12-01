<?php
error_reporting(0);
require_once(dirname(__FILE__).'/verification.class.php');
$VerCode=new VerCode();
$VerCode->make();
?>
