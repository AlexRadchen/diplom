<?php

/*
          управление админами
		  http://radchenko.mega8.ru/admins/list.php
		  
		  пароль ниже
*/
include('../inc/config.php');


#######################################################################################################################
if(empty($_SESSION['super_admin']))
{
	if(!empty($_POST['pass']) and $_POST['pass'] == '5987636') // пароль тут!
	{
		$_SESSION['super_admin'] = 1;
		header('location: /admins/list.php	');
		exit;
	}
	
	include(DR.'inc/header.php');
	
	?>
		<form method="post">
		<br />
		<br />
		<input type="password" name="pass" /> <button type="submit" class="button">Ok</button>
		<br />
		<br />
		</form>
	<?
	exit;
}
#######################################################################################################################
?>