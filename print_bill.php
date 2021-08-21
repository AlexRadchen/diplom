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
<u>Государственный комитет по стандартизации<br />
Республики Беларусь</u> <strong>Филиал "Эталон"<br />
РУП "Витебский ЦСМС"</strong> 210001, г.Витебск,<br />				
ул.Белорусская,5 тел.66-02-40, 66-51-82     IBAN	<br />											
BY45BPSB30121544590159330000 в Региональной  	<br />											
дирекции №200 по Витебской области ОАО     <br />												
 "БПС-Сбербанк",210602  г .Витебск,  ул.Ленина,26/2	<br />											
 BIC BPSBBY2X,  УНП 300990125												
</div>

<h1>СЧЕТ-ПРОТОКОЛ    №<strong><?=$r['id']?></strong> от <?=date('d.m.Y', $r['date'])?></h1>


согласования свободных, договорных отпускных цен на оказываемые услуги при производстве работ, связанных с ремонтом тахографов (восстановлением деталей, заменой узлов, механизмов и т.д.)																					
<br /><br />


			
                																							
<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <tr>
    <td>Заказчик:</td>
    <td class="green"><?=$r['firma']?></td>
    <td>УНП:</td>
    <td class="green"><?=$r['unp']?></td>
    <td>ОКПО:</td>
    <td class="green"><?=$r['okpo']?></td>
  </tr>
  <tr>
    <td>Плательщик:</td>
    <td class="green"><?=$r['firma']?></td>
    <td>УНП:</td>
    <td class="green"><?=$r['unp']?></td>
    <td>ОКПО:</td>
    <td class="green"><?=$r['okpo']?></td>
  </tr>
</table>
<br /><br />




<?
$products = explode(',', $r['products']);
$kols = json_decode($r['kols'], true);
$prices = json_decode($r['prices'], true);
$STH = SQL("SELECT * FROM products WHERE name!='' ORDER BY name DESC",__FILE__,__LINE__);
$n = 0;
$amount = 0;
$amount_nds = 0;
$amount_full = 0;
$line = '';
while($p = $STH->fetch())
{
	//print_r($p);
	if(in_array($p['id'], $products))
	{
		if(empty($kols[$p['id']]))   $kols[$p['id']] = '';
		if(empty($prices[$p['id']]))   $prices[$p['id']] = '';
		if(empty($r['prices']))   $prices[$p['id']] = $p['price'];
		$n++;
		$am = $kols[$p['id']] * $prices[$p['id']];
		$amount = $amount + ($am / 100 * 80);
		$amount_nds = $amount_nds + ($am / 100 * 20);
		$amount_full = $amount_full + $am;
		$type = 'шт.'; if($p['type'] == 1) $type = 'норма-часы';
		$line .= '
		  <tr>
			<td>'.$n.'</td>
			<td>'.$p['name'].'</td>
			<td>'.$type.'</td>
			<td>'.$kols[$p['id']].'</td>
			<td>'.$prices[$p['id']].'</td>
			<td>'.$am.'</td>
			<td>20</td>
			<td>'.($am / 100 * 20).'</td>
			<td>'.($am / 100 * 120).'</td>
		  </tr>';
	}
}

if(!empty($line))
{
	?>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
      <tr class="title">
        <td>№</td>
        <td>Наименование товара</td>
        <td>Ед. изм.</td>
        <td>Кол.</td>
        <td>Цена, руб</td>
        <td>Сумма, руб</td>
        <td>Ставка НДС,%</td>
        <td>Сумма НДС</td>
        <td>Всего с НДС</td>
      </tr>
      <?=$line?>
      <tr class="title">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"><strong>Итого:</strong></td>
        <td><strong><?=$amount?></strong></td>
        <td></td>
        <td><strong><?=$amount_nds?></strong></td>  
        <td><strong><?=$amount_full?></strong></td>
      </tr>
    </table>
    <br /><br />
    <?
}
?>




<strong>Сумма НДС:</strong> <?=num2str(round($r['amount'] / 100 * 20, 2))?><br />																				
<strong>Всего к оплате на сумму с НДС:</strong> <?=num2str($r['amount'])?><br /><br />	



Данный  счет-протокол  является  протоколом   согласования  цен.	<br />																														
Данный счет-протокол действительн в течении 5-ти банковских дней.<br />	
<br />																														
Приемка всех выполненных работ производится "Заказчиком" согласно акта выполненных работ или ТН-2. Право подписи акта выполненных работ со стороны Заказчика имеет любой сотрудник, уполномоченный на то доверенностью.	<br />		
<br />																												
При просрочке платежа согласно счет-протокола за объем указанных работ. "Подрядчик" не гарантирует действительность указанных в данном протоколе цен.	<br />																														
<br />														
Цены действительны в течении срока, указанного в счет-протоколе.	<br />																														
Внимание! При получении товара иметь при себе доверенность и копию платежного документа!<br />

<br />
<br />																														



Руководитель предприятия _________________ / Рыбаков И.Л /<br />																											
<span style="margin:0 0 0 222px">(подпись)</span><br /><br /><br />


Главный бухгалтер _________________ / Шатравко А.В. /<br />																											
<span style="margin:0 0 0 140px">М.П. (подпись)</span><br /><br /><br />																		
																												
															
																									 			
																												
Плательщик _____________________ / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /<br />				
<span style="margin:0 0 0 100px">М.П. (подпись)</span><br />	

	
																												
												
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