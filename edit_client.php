<?php

include('inc/pass_admin.php');


//id
if(!empty($_GET['id']))
{
	$id = htmlpost($_GET['id']);	
	if(!preg_match("/^[0-9]+$/", $id)) 
	{
		header('location: clients.php');
		exit;
	}
}
else{
	//найти в базе
	$STH = SQL("SELECT id FROM clients WHERE firma='' LIMIT 1",__FILE__,__LINE__);
	$r = $STH->fetch();	
	if(empty($r['id'])) 
	{
		//создать
		SQL("INSERT INTO clients (date) VALUES ('".time()."')",__FILE__,__LINE__);
		
		//найти в базе
		$STH = SQL("SELECT id FROM clients ORDER BY id DESC LIMIT 1",__FILE__,__LINE__);
		$r = $STH->fetch();
	}	
	
	header('location: edit_client.php?id='.$r['id']);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM clients WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();


###############################################################################################
if(!empty($_POST['save']))
{


//firma
if(!empty($_POST['firma']))
{
	$firma = htmlpost($_POST['firma']);
}
else{
	$ups .= 'Введите наименование организации<br />';
}

//unp
$unp = '';
if(!empty($_POST['unp']))
{
	$unp = htmlpost($_POST['unp']);
}

//okpo
$okpo = '';
if(!empty($_POST['okpo']))
{
	$okpo = htmlpost($_POST['okpo']);
}

//adr
$adr = '';
if(!empty($_POST['adr']))
{
	$adr = htmlpost($_POST['adr']);
}

//phone
$phone = '';
if(!empty($_POST['phone']))
{
	$phone = htmlpost($_POST['phone']);
}

//zam
$zam = '';
if(!empty($_POST['zam']))
{
	$zam = htmlpost($_POST['zam']);
}

//bank
$bank = '';
if(!empty($_POST['bank']))
{
	$bank = htmlpost($_POST['bank']);
}

//bank_bik
$bank_bik = '';
if(!empty($_POST['bank_bik']))
{
	$bank_bik = htmlpost($_POST['bank_bik']);
}

//bank_rs
$bank_rs = '';
if(!empty($_POST['bank_rs']))
{
	$bank_rs = htmlpost($_POST['bank_rs']);
}

//dog_num
$dog_num = '';
if(!empty($_POST['dog_num']))
{
	$dog_num = htmlpost($_POST['dog_num']);
}

//dog_date
$dog_date = '';
if(!empty($_POST['dog_date']))
{
	$dog_date = htmlpost($_POST['dog_date']);
	$dog_date = strtotime($dog_date);
}



//обновить в бд
if(empty($ups))
{
	SQL("UPDATE clients SET 
									 modif='".time()."',
									 firma='".$firma."', 
									 unp='".$unp."', 
									 okpo='".$okpo."', 
									 adr='".$adr."', 
									 phone='".$phone."',	
									 bank='".$bank."', 
									 bank_bik='".$bank_bik."', 
									 bank_rs='".$bank_rs."', 
									 dog_num='".$dog_num."', 
									 dog_date='".$dog_date."',									 							 
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

<h1>Редактор клиентов</h1>

<div id="menu">
<a href="info.php">Главная</a>
<a href="clients.php">Список клиентов</a>
<a href="edit_client.php">Добавить клиента</a>
</div>

<div class="flex_box">
<div class="box box_1">
<form id="form">
<strong>Фирма</strong> <input type="text" name="firma" value="<?=$r['firma']?>" style="width:500px" /><br /><br />
<strong>УНП</strong> <input type="number" name="unp" value="<?=$r['unp']?>" /><br /><br />
<strong>ОКПО</strong> <input type="number" name="okpo" value="<?=$r['okpo']?>" /><br /><br />

<br />
<strong>Банк</strong> <input type="text" name="bank" value="<?=$r['bank']?>" style="width:400px" /><br /><br />
<strong>БИК</strong> <input type="text" name="bank_bik" value="<?=$r['bank_bik']?>" /><br /><br />
<strong>Р/с</strong> <input type="text" name="bank_rs" value="<?=$r['bank_rs']?>" style="width:200px" /><br /><br />

<br />
<strong>Номер договора</strong> <input type="number" name="dog_num" value="<?=$r['dog_num']?>" /><br /><br />
<strong>Дата договора</strong> <input type="date" name="dog_date" value="<?=date('Y-m-d', $r['dog_date'])?>" /><br /><br />

<br />
<strong>Заметки</strong>
<textarea name="zam"><?=$r['zam']?></textarea><br /><br />
<strong>Телефон</strong> <input type="tel" name="phone" value="<?=$r['phone']?>" /><br /><br />


<div class="status"></div>
<strong></strong><button type="submit" class="button" onclick="form_send('form'); return false">Сохранить</button>

</form>
</div>
</div>

<br />
<br />

