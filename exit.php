<?php

include('inc/config.php');

//проверить сессию 
if(empty(ADMIN_ID))
{
	header('location: /info.php');
	exit;
}

unset($_SESSION['cms_admin']);
setcookie('cms_admin_id', '', time() + 15000000, '/');
setcookie('cms_admin_pass', '', time() + 15000000, '/');

$oke = 'Вы успешно вышли из аккаунта <img src="/img/load.gif" width="20" height="20" /><br />';
header('location: /info.php');

//echo '===<pre>';    print_r($_SESSION);    echo '</pre>';
//echo '==='.ADMIN_ID;

?>