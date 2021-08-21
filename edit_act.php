<?php

include('inc/pass_admin.php');


//tahograf
$tahograf = 0;
if(!empty($_GET['tahograf']))
{
	$tahograf = htmlpost($_GET['tahograf']);	
	if(!preg_match("/^[0-9]+$/", $tahograf)) 
	{
		header('location: clients.php');
		exit;
	}
}
else{
	//header('location: clients.php');
	//exit;
}




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
	$STH = SQL("SELECT id FROM acts WHERE date<10 AND tahograf='".$tahograf."' LIMIT 1",__FILE__,__LINE__);
	$r = $STH->fetch();	
	if(empty($r['id'])) 
	{
		//создать
		SQL("INSERT INTO acts (date,tahograf) VALUES ('".time()."','".$tahograf."')",__FILE__,__LINE__);
		
		//найти в базе
		$STH = SQL("SELECT id FROM acts WHERE tahograf='".$tahograf."' ORDER BY id DESC LIMIT 1",__FILE__,__LINE__);
		$r = $STH->fetch();
	}	
	
	header('location: edit_act.php?id='.$r['id']);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM acts WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();

if(empty($tahograf)) $tahograf = $r['tahograf'];

//tahograf 
$STH = SQL("SELECT * FROM tahograf WHERE id='".$tahograf."' LIMIT 1",__FILE__,__LINE__);
$t = $STH->fetch();

//auto 
$STH = SQL("SELECT * FROM auto WHERE id='".$t['auto']."' LIMIT 1",__FILE__,__LINE__);
$a = $STH->fetch();

//client 
$STH = SQL("SELECT * FROM clients WHERE id='".$a['client']."' LIMIT 1",__FILE__,__LINE__);
$c = $STH->fetch();


###############################################################################################
if(!empty($_POST['save']))
{
	//echo '<pre>';	print_r($_POST);	echo '</pre>';
//admin_name
$admin_name = '';
if(!empty($_POST['admin_name']))
{
	$admin_name = htmlpost($_POST['admin_name']);
}

//date
$date = time();
if(!empty($_POST['date']))
{
	$date = htmlpost($_POST['date']);
	$date = strtotime($date);
}


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

//auto_num
$auto_num = '';
if(!empty($_POST['auto_num']))
{
	$auto_num = htmlpost($_POST['auto_num']);
}

//vin
$vin = '';
if(!empty($_POST['vin']))
{
	$vin = htmlpost($_POST['vin']);
}




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


//products
$products = '';
$kols = '';
$prices = '';
$amount = 0;
if(!empty($_POST['products']))
{
	$p = $_POST['products'];
	$kols = $_POST['kols'];
	$prices = $_POST['prices'];
	$products = [];
	foreach($p as $k => $v)
	{
		$kols[$k] = str_replace([',','*','/','-','+'], '.', $kols[$k]);
		$prices[$k] = str_replace([',','*','/','-','+'], '.', $prices[$k]);
		if(preg_match("/^[0-9]+$/", $v)) 
		{
			$products[] = $v;
			
			if(!empty($kols[$k]) and !empty($prices[$k]) and preg_match("/^[0-9'.]+$/", $kols[$k]) and preg_match("/^[0-9'.]+$/", $prices[$k]))
			{
				$amount = $amount + ($kols[$k] * $prices[$k]);
			}
		}
	}
	$amount = str_replace([',','*','/','-','+'], '.', $amount);
	$products = implode(',', $products);
	$kols = json_encode($kols, JSON_UNESCAPED_UNICODE);
	$prices = json_encode($prices, JSON_UNESCAPED_UNICODE);	
}
//echo '<pre>';	print_r($products);	echo '</pre>';


//обновить в бд
if(empty($ups))
{
	SQL("UPDATE acts SET 
									 date='".$date."',	
									 admin_name='".$admin_name."',	
									 client='".$c['id']."',	

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
									 
									 marka='".$marka."',
									 model='".$model."', 
									 auto_num='".$auto_num."',									 							 
									 vin='".$vin."',
									 
									 name='".$name."',
									 num='".$num."', 
									 k='".$k."',	
									 odometr='".$odometr."',	
									 type='".$type."',	
									 w='".$w."',	
									 len='".$len."',
									 
									 products='".$products."',
									 kols='".$kols."',
									 prices='".$prices."',
									 amount='".$amount."',
									 
									 modif='".time()."'					 
												 WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
	$oke .= 'Данные сохранены<br />';
	$oke .= 'Сумма счёта: '.$amount.' руб.<br />';
}

echo ups($ups);
echo oke($oke);
exit;
}
###############################################################################################


// Если данных в акте нет, то заполним их из карточек фирмы-авто-тахографа
if(empty($r['firma']))   $r['firma'] = $c['firma'];
if(empty($r['unp']))   $r['unp'] = $c['unp'];
if(empty($r['okpo']))   $r['okpo'] = $c['okpo'];
if(empty($r['adr']))   $r['adr'] = $c['adr'];
if(empty($r['phone']))   $r['phone'] = $c['phone'];
if(empty($r['bank']))   $r['bank'] = $c['bank'];
if(empty($r['bank_bik']))   $r['bank_bik'] = $c['bank_bik'];
if(empty($r['bank_rs']))   $r['bank_rs'] = $c['bank_rs'];
if(empty($r['dog_num']))   $r['dog_num'] = $c['dog_num'];
if(empty($r['dog_date']))   $r['dog_date'] = $c['dog_date'];

if(empty($r['marka']))   $r['marka'] = $a['marka'];
if(empty($r['model']))   $r['model'] = $a['model'];
if(empty($r['auto_num']))   $r['auto_num'] = $a['num'];
if(empty($r['vin']))   $r['vin'] = $a['vin'];

if(empty($r['name']))   $r['name'] = $t['name'];
if(empty($r['num']))   $r['num'] = $t['num'];
if(empty($r['k']))   $r['k'] = $t['k'];
if(empty($r['odometr']))   $r['odometr'] = $t['odometr'];
if(empty($r['type']))   $r['type'] = $t['type'];
if(empty($r['w']))   $r['w'] = $t['w'];
if(empty($r['len']))   $r['len'] = $t['len'];

if(empty($r['admin_name']))   $r['admin_name'] = ADMIN['name'];

include(DR.'inc/header.php');

?>

<h1>Редактор актов</h1>

<a href="info.php">Главная</a> / 
<a href="clients.php">Список клиентов</a> / 
<strong><?=$c['firma']?></strong> / 
<a href="auto.php?client=<?=$c['id']?>">Все авто</a> / 
<strong><?=$a['marka']?> <?=$a['model']?> <?=$a['num']?></strong> /
<a href="tahograf.php?auto=<?=$a['id']?>">Все тахографы</a> / 
<strong><?=$t['num']?></strong> / 
<a href="acts.php?tahograf=<?=$t['id']?>">Все акты</a>
<br /><br />

<form id="form">
<h2>Акт №<span style="color:#F90"><?=$r['id']?></span>Т от <input type="date" name="date" value="<?=date('Y-m-d', $r['date'])?>" /></h2>

<div class="flex_box">

<div class="box box_1">
<h3>Фирма</h3>
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

<strong>Телефон</strong> <input type="tel" name="phone" value="<?=$r['phone']?>" /><br /><br />
</div>

<div class="box box_2">
<h3>Авто</h3>
<strong>Марка</strong> <input type="text" name="marka" value="<?=$r['marka']?>" /><br /><br />
<strong>Модель</strong> <input type="text" name="model" value="<?=$r['model']?>" /><br /><br />
<strong>Гос.номер</strong> <input type="text" name="auto_num" value="<?=$r['auto_num']?>" maxlength="10" /><br /><br />
<strong>VIN</strong> <input type="text" name="vin" value="<?=$r['vin']?>" maxlength="30" /><br /><br />
</div>

<div class="box box_3">
<h3>Тахограф</h3>
<strong>Марка тахографа</strong> <input type="text" name="name" value="<?=$r['name']?>" /><br /><br />
<strong>Номер</strong> <input type="number" name="num" value="<?=$r['num']?>" /><br /><br />
<strong>K</strong> <input type="number" name="k" value="<?=$r['k']?>" maxlength="5" /><br /><br />
<strong>Одометр</strong> <input type="text" name="odometr" value="<?=$r['odometr']?>" maxlength="7" /><br /><br />
<strong>Тип шины</strong> <input type="text" name="type" value="<?=$r['type']?>" maxlength="15" /><br /><br />
<strong>W</strong> <input type="number" name="w" value="<?=$r['w']?>" maxlength="5" /><br /><br />
<strong>L</strong> <input type="number" name="len" value="<?=$r['len']?>" /><br /><br />
</div>

<div class="box box_4">
<h3>Товары / услуги</h3>
<?
$products = explode(',', $r['products']);
$kols = json_decode($r['kols'], true);
$prices = json_decode($r['prices'], true);
$STH = SQL("SELECT * FROM products WHERE name!='' ORDER BY name DESC",__FILE__,__LINE__);
while($p = $STH->fetch())
{
	$checked = ''; if(in_array($p['id'], $products)) $checked = 'checked';
	if(empty($kols[$p['id']]))   $kols[$p['id']] = '';
	if(empty($prices[$p['id']]))   $prices[$p['id']] = '';
	if(empty($r['prices']))   $prices[$p['id']] = $p['price'];
	echo '
	<label>    <input type="checkbox" name="products['.$p['id'].']" value="'.$p['id'].'"    '.$checked.' /> <strong>'.$p['name'].'</strong> ('.$p['price'].' руб)</label><br />	
	Количество <input type="number"   name="kols['.$p['id'].']"     value="'.$kols[$p['id']].'"             maxlength="5" style="width:100px" /> 	
	Цена       <input type="number"   name="prices['.$p['id'].']"   value="'.$prices[$p['id']].'"           maxlength="5" style="width:100px" /> руб		 
	<br /><br />';
}
?>
<strong>Механик</strong> <input type="text" name="admin_name" value="<?=$r['admin_name']?>" /><br /><br />


<br />
<div class="status"></div>
<strong></strong><button type="submit" class="button" onclick="form_send('form'); return false">Сохранить</button><br /><br />
<strong></strong><a href="print_act.php?id=<?=$id?>" target="_blank">Печать</a> | 
<a href="exel_act.php?id=<?=$id?>" target="_blank">XLS</a>
</div>

</div>

<br />
<br />
<br />
<br />
</form>


