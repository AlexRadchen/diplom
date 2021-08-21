<?php

include('pass.php');


//id
if(!empty($_GET['id']))
{
	$id = htmlpost($_GET['id']);	
	if(!preg_match("/^[0-9]+$/", $id)) 
	{
		header('location: list.php');
		exit;
	}
}
else{
	//найти в базе
	$STH = SQL("SELECT id FROM admins WHERE name='' LIMIT 1",__FILE__,__LINE__);
	$r = $STH->fetch();	
	if(empty($r['id'])) 
	{
		//создать
		SQL("INSERT INTO admins (date) VALUES ('".time()."')",__FILE__,__LINE__);
		
		//найти в базе
		$STH = SQL("SELECT id FROM admins ORDER BY id DESC LIMIT 1",__FILE__,__LINE__);
		$r = $STH->fetch();
	}	
	
	header('location: edit.php?id='.$r['id']);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM admins WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();


###############################################################################################
if(!empty($_POST['save']))
{


//name
if(!empty($_POST['name']))
{
	$name = htmlpost($_POST['name']);
}
else{
	$ups .= 'Введите имя<br />';
}

//email
if(!empty($_POST['email']))
{
    $email = htmlpost(strtolower($_POST['email']));

    if(!preg_match("/^([A-Za-z,0-9'_\.-])+@([A-Za-z,0-9'_\.-])+(.([A-Za-z,0-9])+)+$/", $email)) 
	{
		$ups .= 'Неверный формат e-mail<br />';
	}
	elseif(strlen($email) < 7) 
	{
		$ups .= 'E-mail короче 7 символов<br />';
	}
	elseif(strlen($email) > 50) 
	{
		$ups .= 'E-mail длинее 50 символов<br />';
	}
}
else{
	$ups .= 'Введите e-mail<br />';
}

//phone
$phone = '';
if(!empty($_POST['phone']))
{
	$phone = htmlpost($_POST['phone']);
}
else{
	//$ups .= 'Введите номер телефона<br />';
}


//пароль
$pass_admin = $r['pass'];
if(!empty($_POST['pass']))
{
	$pass = htmlpost($_POST['pass']);
	
	if(mb_strlen($pass) < 6) 
	{
		$ups .= 'Пароль короче 6 символов<br />';
	}
	elseif(mb_strlen($pass) > 17) 
	{
		$ups .= 'Пароль длинее 17 символов<br />';
	}
	
	//md5 пароль 
	$pass_admin = $pass;
	$pass_admin = md5($pass_admin);
	$pass_admin = mb_substr($pass_admin, 5, 25);
	$pass_admin = 'adm'.$pass_admin.'in';
	$pass_admin = md5($pass_admin);
	$pass_admin = mb_substr($pass_admin, 7, 27);
}

//level
$level = 4;
if(!empty($_POST['level']))
{
	$level = htmlpost($_POST['level']);		
	if(!preg_match("/^[0-9]+$/", $level)) 
	{
		$level = 4;
	}
}


//обновить в бд
if(empty($ups))
{
	SQL("UPDATE admins SET 
									 modif='".time()."',
									 name='".$name."', 
									 email='".$email."',
									 phone='".$phone."',
									 pass='".$pass_admin."',									 
									 level='".$level."'
												 WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
	$oke .= 'Данные сохранены<br />';
}

echo ups($ups);
echo oke($oke);
exit;
}
###############################################################################################


include(DR.'inc/header.php');

?>

<h1>Редактор админов</h1>

<a href="list.php">Список админов</a>

<form id="form">
<br />
<br />
ФИО <input type="text" name="name" value="<?=$r['name']?>" /><br /><br />
E-mail <input type="mail" name="email" value="<?=$r['email']?>" /><br /><br />
Телефон <input type="tel" name="phone" value="<?=$r['phone']?>" /><br /><br />
Новый пароль <input type="text" name="pass" value="<? if(empty($r['pass'])){echo rand(111111,999999);} ?>" /><br /><br />

Статус <select size="1" name="level">
<option value="1" <? if($r['level']==1 or $r['level']==0){echo 'selected="selected"';} ?>>активен</option>
<option value="4" <? if($r['level']==4){echo 'selected="selected"';} ?>>выключен</option>
</select><br /><br />

<div class="status"></div>
<button type="submit" class="button" onclick="form_send('form'); return false">Сохранить</button>
<br />
<br />
</form>