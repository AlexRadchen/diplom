<?php

include('inc/pass_admin.php');

//client
if(!empty($_GET['client']))
{
	$client = htmlpost($_GET['client']);	
	if(!preg_match("/^[0-9]+$/", $client)) 
	{
		header('location: clients.php?'.__LINE__);
		exit;
	}
}
else{
	header('location: clients.php?'.__LINE__);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM clients WHERE id='".$client."' LIMIT 1",__FILE__,__LINE__);
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
	$STH = SQL("SELECT id FROM auto WHERE marka='' AND client='".$client."' LIMIT 1",__FILE__,__LINE__);
	$r = $STH->fetch();	
	if(empty($r['id'])) 
	{
		//создать
		SQL("INSERT INTO auto (date,client) VALUES ('".time()."','".$client."')",__FILE__,__LINE__);
		
		//найти в базе
		$STH = SQL("SELECT id FROM auto WHERE client='".$client."' ORDER BY id DESC LIMIT 1",__FILE__,__LINE__);
		$r = $STH->fetch();
	}	
	
	header('location: edit_auto.php?client='.$client.'&id='.$r['id']);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM auto WHERE id='".$id."' AND client='".$client."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();


###############################################################################################
if(!empty($_POST['save']))
{


//marka
if(!empty($_POST['marka']))
{
	$marka = htmlpost($_POST['marka']);
}
else{
	$ups .= 'Введите марку авто<br />';
}

//model
$model = '';
if(!empty($_POST['model']))
{
	$model = htmlpost($_POST['model']);
}

//num
$num = '';
if(!empty($_POST['num']))
{
	$num = htmlpost($_POST['num']);
}

//vin
$vin = '';
if(!empty($_POST['vin']))
{
	$vin = htmlpost($_POST['vin']);
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
	SQL("UPDATE auto SET 
									 modif='".time()."', 
									 marka='".$marka."',
									 model='".$model."', 
									 num='".$num."',									 							 
									 vin='".$vin."',									 							 
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

<h1>Редактор авто</h1>

<a href="info.php">Главная</a> / 
<a href="clients.php">Список клиентов</a> / 
<strong><?=$c['firma']?></strong> / 
<a href="auto.php?client=<?=$c['id']?>">Все авто</a>
<br /><br />


<div class="flex_box">
<div class="box box_2">
<form id="form">
<strong>Марка</strong> <input type="text" name="marka" value="<?=$r['marka']?>" /><br /><br />
<strong>Модель</strong> <input type="text" name="model" value="<?=$r['model']?>" /><br /><br />
<strong>Гос.номер</strong> <input type="text" name="num" value="<?=$r['num']?>" maxlength="10" /><br /><br />
<strong>VIN</strong> <input type="text" name="vin" value="<?=$r['vin']?>" maxlength="30" /><br /><br />

<br />
<strong>Заметки</strong>
<textarea name="zam"><?=$r['zam']?></textarea><br /><br />


<div class="status"></div>
<strong></strong><button type="submit" class="button" onclick="form_send('form'); return false">Сохранить</button>

</form>
</div>
</div>

<br />
<br />

