<?php

include('inc/pass_admin.php');



//auto
if(!empty($_GET['auto']))
{
	$auto = htmlpost($_GET['auto']);	
	if(!preg_match("/^[0-9]+$/", $auto)) 
	{
		header('location: clients.php');
		exit;
	}
}
else{
	header('location: clients.php');
	exit;
}


//auto 
$STH = SQL("SELECT * FROM auto WHERE id='".$auto."' LIMIT 1",__FILE__,__LINE__);
$a = $STH->fetch();

//client 
$STH = SQL("SELECT * FROM clients WHERE id='".$a['client']."' LIMIT 1",__FILE__,__LINE__);
$c = $STH->fetch();



//id
if(!empty($_GET['id']))
{
	$id = htmlpost($_GET['id']);	
	if(!preg_match("/^[0-9]+$/", $id)) 
	{
		header('location: clients.php?'.__LINE__);
		exit;
	}
}
else{
	//найти в базе
	$STH = SQL("SELECT id FROM tahograf WHERE num='' AND auto='".$auto."' LIMIT 1",__FILE__,__LINE__);
	$r = $STH->fetch();	
	if(empty($r['id'])) 
	{
		//создать
		SQL("INSERT INTO tahograf (date,auto) VALUES ('".time()."','".$auto."')",__FILE__,__LINE__);
		
		//найти в базе
		$STH = SQL("SELECT id FROM tahograf WHERE auto='".$auto."' ORDER BY id DESC LIMIT 1",__FILE__,__LINE__);
		$r = $STH->fetch();
	}	
	
	header('location: edit_tahograf.php?auto='.$auto.'&id='.$r['id']);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM tahograf WHERE id='".$id."' AND auto='".$auto."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();


###############################################################################################
if(!empty($_POST['save']))
{

//name
$name = '';
if(!empty($_POST['name']))
{
	$name = htmlpost($_POST['name']);
}

//num
if(!empty($_POST['num']))
{
	$num = htmlpost($_POST['num']);
}
else{
	$ups .= 'Введите номер тахографа<br />';
}

//k
$k = '';
if(!empty($_POST['k']))
{
	$k = htmlpost($_POST['k']);
}

//odometr
$odometr = '';
if(!empty($_POST['odometr']))
{
	$odometr = htmlpost($_POST['odometr']);
}

//type
$type = '';
if(!empty($_POST['type']))
{
	$type = htmlpost($_POST['type']);
}

//w
$w = '';
if(!empty($_POST['w']))
{
	$w = htmlpost($_POST['w']);
}

//len
$len = '';
if(!empty($_POST['len']))
{
	$len = htmlpost($_POST['len']);
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

//zam
$zam = '';
if(!empty($_POST['zam']))
{
	$zam = htmlpost($_POST['zam']);
}

//обновить в бд
if(empty($ups))
{
	SQL("UPDATE tahograf SET 
									 modif='".time()."', 
									 name='".$name."',
									 num='".$num."', 
									 k='".$k."',	
									 odometr='".$odometr."',	
									 type='".$type."',	
									 w='".$w."',	
									 len='".$len."',									 							 
									 level='".$level."',
									 zam='".$zam."'
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

<h1>Редактор тахографов</h1>

<a href="info.php">Главная</a> / 
<a href="clients.php">Список клиентов</a> / 
<?=$c['firma']?> / 
<a href="auto.php?client=<?=$c['id']?>">Все авто</a> / 
<strong><?=$a['marka']?> <?=$a['model']?> <?=$a['num']?></strong> / 
<a href="tahograf.php?auto=<?=$a['id']?>">Все тахографы</a>
<br /><br />


<div class="flex_box">
<div class="box box_3">
<form id="form">
<strong>Марка тахографа</strong> <input type="text" name="name" value="<?=$r['name']?>" /><br /><br />
<strong>Номер</strong> <input type="number" name="num" value="<?=$r['num']?>" /><br /><br />
<strong>K</strong> <input type="number" name="k" value="<?=$r['k']?>" maxlength="5" /><br /><br />
<strong>Одометр</strong> <input type="text" name="odometr" value="<?=$r['odometr']?>" maxlength="7" /><br /><br />
<strong>Тип шины</strong> <input type="text" name="type" value="<?=$r['type']?>" maxlength="15" /><br /><br />
<strong>W</strong> <input type="number" name="w" value="<?=$r['w']?>" maxlength="5" /><br /><br />
<strong>L</strong> <input type="number" name="len" value="<?=$r['len']?>" /><br /><br />

<br />
<strong>Заметки</strong>
<textarea name="zam"><?=$r['zam']?></textarea><br /><br />

<strong>Статус</strong> <select size="1" name="level">
<option value="1" <? if($r['level']==1 or $r['level']==0){echo 'selected="selected"';} ?>>ВКЛ</option>
<option value="4" <? if($r['level']==4){echo 'selected="selected"';} ?>>откл</option>
</select><br /><br />


<div class="status"></div>
<strong></strong><button type="submit" class="button" onclick="form_send('form'); return false">Сохранить</button>

</form>
</div>
</div>

<br />
<br />

