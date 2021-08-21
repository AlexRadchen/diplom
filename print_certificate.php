<?php

include('inc/pass_admin.php');


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
	header('location: clients.php?'.__LINE__);
	exit;
}


//act 
$STH = SQL("SELECT * FROM acts WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();

//tahograf 
$STH = SQL("SELECT * FROM tahograf WHERE id='".$r['tahograf']."' LIMIT 1",__FILE__,__LINE__);
$t = $STH->fetch();

//auto 
$STH = SQL("SELECT * FROM auto WHERE id='".$t['auto']."' LIMIT 1",__FILE__,__LINE__);
$a = $STH->fetch();

//client 
$STH = SQL("SELECT * FROM clients WHERE id='".$a['client']."' LIMIT 1",__FILE__,__LINE__);
$c = $STH->fetch();

?>

<style>
#page {margin:auto; max-width:800px; text-align:left; font-size:13px; font-family:Verdana, Geneva, sans-serif}
#page h1 {font-size:20px; font-weight:normal; width:100%; text-align:center; }
table {font-size:13px; font-family:Verdana, Geneva, sans-serif; }
table .title {background-color:#EBEBEB; }
table .green {background-color:#d7f7ce; }
table .red {background-color:#fcb6ab; }
</style>


<div id="page">

<div id="header">
Филиал "Эталон" Витебский ЦСМС	<br />			
210000 г.Витебск Бешенковичское шоссе,12	<br />			
т.36-51-82	<br />			
</div>


<h1>СВИДЕТЕЛЬСТВО №<strong><?=$r['id']?></strong> <br />
о техническом состоянии цифрового тахографа </h1>


1. Общие указания	<br />								
Владелец транспортного средства/арендатор: <?=$r['firma']?>		<br />	
Адрес:	<?=$r['adr']?>	<br />							
Индекс и место регистрации ТС:	<br />								
<br />	
Тип  транспортного средства: <?=$r['marka']?> <?=$r['model']?>	<br />				
<br />
Идентификационный номер (VIN):	<?=$r['vin']?>	<br />				
<br />
Государственный регистрационный знак: <?=$r['auto_num']?>	<br />		
<br />
Дата:	05.08.2021		Дата  следующей проверки:			05.08.2022<br />			
<br />
Номер рабочей карты:				Номер клиента:	<br />				
<br />
Тип тахографа: <?=$r['type']?>		Номер тахографа: <?=$r['num']?>	<br />
<br />
Тахограф		□ установка нового		□ установка параметров		□ ремонт/обновл. ПО		<br />	
<br />
Показания одометра:			<?=$r['odometr']?>	км.<br />
<br />
2. Проверка ТС				Замена  батареи:	да		Отказ<br />		
							по инициативе клиента<br />		
Размер шин:		<?=$r['type']?>							подпись<br />
<br />
Шины		□ Радиальные			□ Диагональные		<br />		
<br />
Давление в шинах:			□ Проверено		атм.<br />				
							Vitebskii TSSMS Filial "Etalon"	<br />	
Коэфф. коррекции мерного участка:				-_______%	+_______%		Vitebsk Beshenkovichskoe <br />		
								             shosse 12	<br />
Диаметр качения колеса:			<?=$r['k']?>	мм				              BY 001	037<br />
<br />
Число оборотов/			U/км				Data:		44785<br />
<br />
Число импульсов W'=		<?=$r['w']?>	имп/км				vin:	<?=$r['vin']?>	<br />
<br />
Усреднённое							TNo:		0000474772<br />
<br />
Число импульсов: *		Wang'=		метр			Opony:		<?=$r['type']?><br />
<br />
3. Проверка прибора							W		<?=$r['w']?><br />
<br />
Аппаратная константа:		К'=	9550	имп/км			K		<?=$r['k']?><br />
<br />
 Проверка скорости:    40 км/ч     80 км/ч     120 км/ч							L		<?=$r['len']?><br />
								Vset'=90km/h	<br />
Проверка одометра:		-0,1	метр<br />						
<br />
Проверка ограничения скорости: Vset'= 90 км/ч	<br />								
<br />
<br />
<br />
				Заключение о техническом состоянии:					Годен<br />
<br />
						<?=$r['admin_name']?>	<br />		
<br />
Штамп сервисного пункта				Подпись ответственного лица					
									

												
</div>









<div style="display:none">

<h3>Фирма</h3>
Фирма <?=$r['firma']?>
УНП <?=$r['unp']?>
ОКПО <?=$r['okpo']?>

<br />
Банк <?=$r['bank']?>
БИК <?=$r['bank_bik']?>
Р/с <?=$r['bank_rs']?>

<br />
Номер договора <?=$r['dog_num']?>
Дата договора <?=date('d.m.Y', $r['dog_date'])?>

Телефон <?=$r['phone']?>



<h3>Авто</h3>
Марка <?=$r['marka']?>
Модель <?=$r['model']?>
Гос.номер <?=$r['auto_num']?>
VIN <?=$r['vin']?>


<h3>Тахограф</h3>
Марка тахографа <?=$r['name']?>
Номер <?=$r['num']?>
K <?=$r['k']?>
Одометр <?=$r['odometr']?>
Тип шины <?=$r['type']?>
W <?=$r['w']?>
L <?=$r['len']?>




<h3>Товары / услуги</h3>
<?
$products = explode(',', $r['products']);
$kols = json_decode($r['kols'], true);
$prices = json_decode($r['prices'], true);
$STH = SQL("SELECT * FROM products WHERE name!='' ORDER BY name DESC",__FILE__,__LINE__);
while($p = $STH->fetch())
{
	if(in_array($p['id'], $products))
	{
		if(empty($kols[$p['id']]))   $kols[$p['id']] = '';
		if(empty($prices[$p['id']]))   $prices[$p['id']] = '';
		if(empty($r['prices']))   $prices[$p['id']] = $p['price'];
		echo '
		<strong>'.$p['name'].'</strong><br />	
		Количество '.$kols[$p['id']].'<br />
		Цена   '.$prices[$p['id']].' руб		 
		<br /><br />';
	}
}
?>
<br />

</div>