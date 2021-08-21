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

<h1>Акт №<strong><?=$r['id']?>Т</strong> <br />
о выполненных работах от <?=date('d.m.Y', $r['date'])?></h1>


Настоящий акт составлен, с одной стороны, Филиал "Эталон" РУП "Витебский ЦСМС" (210001, г.Витебск, ул.Белорусская,5, УНП 300990125)  именуемой в дальнейшем   "Исполнитель"   и с другой стороны <strong><?=$r['firma']?></strong>, именуемое в дальнейшем "Заказчик", в том, что Исполнитель, выполнил  на оборудовании установленном на транспортном средстве:																												
<br /><br />
				
                																							
<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <tr>
    <td class="green">Модель</td>
    <td class="green">Кузов(шасси) №</td>
    <td class="green">Номерной знак</td>
  </tr>
  <tr>
    <td><?=$r['marka']?> <?=$r['model']?></td>
    <td><?=$r['vin']?></td>
    <td><?=$r['auto_num']?></td>
  </tr>
</table>
<br /><br />


<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <tr>
    <td class="green">Тип</td>
    <td><?=$r['type']?></td>
    <td class="green">№</td>
    <td><?=$r['num']?></td>
    <td class="green">Одометр</td>
    <td><?=$r['odometr']?></td>
  </tr>
</table>
<br /><br />



<?
$products = explode(',', $r['products']);
$kols = json_decode($r['kols'], true);
$prices = json_decode($r['prices'], true);
$STH = SQL("SELECT * FROM products WHERE name!='' AND type='1' ORDER BY name DESC",__FILE__,__LINE__);
$n = 0;
$amount_uslug = 0;
$line = '';
while($p = $STH->fetch())
{
	if(in_array($p['id'], $products))
	{
		if(empty($kols[$p['id']]))   $kols[$p['id']] = '';
		if(empty($prices[$p['id']]))   $prices[$p['id']] = '';
		if(empty($r['prices']))   $prices[$p['id']] = $p['price'];
		$n++;
		$amount_uslug = $amount_uslug + ($kols[$p['id']] * $prices[$p['id']]);
		$line .= '
		  <tr>
			<td>'.$n.'</td>
			<td>'.$p['name'].'</td>
			<td>'.$kols[$p['id']].'</td>
			<td>'.$prices[$p['id']].'</td>
			<td>'.$r['admin_name'].'</td>
		  </tr>';
	}
}

if(!empty($line))
{
	?>
    выполнены следующие виды работ:<br />
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
      <tr class="title">
        <td>№</td>
        <td>Наименование работ (код)</td>
        <td>Норматив времени,<br />час</td>
        <td>Стоимость услуг,<br />руб</td>
        <td>Исполнитель</td>
      </tr>
      <?=$line?>
      <tr class="title">
        <td></td>
        <td></td>    
        <td align="right"><strong>Итого:</strong></td>
        <td><?=$amount_uslug?></td>
        <td></td>
      </tr>
    </table>
    <br /><br />
    <?
}
?>





<?
$products = explode(',', $r['products']);
$kols = json_decode($r['kols'], true);
$prices = json_decode($r['prices'], true);
$STH = SQL("SELECT * FROM products WHERE name!='' AND type='0' ORDER BY name DESC",__FILE__,__LINE__);
$n = 0;
$amount_products = 0;
$line = '';
while($p = $STH->fetch())
{
	if(in_array($p['id'], $products))
	{
		if(empty($kols[$p['id']]))   $kols[$p['id']] = '';
		if(empty($prices[$p['id']]))   $prices[$p['id']] = '';
		if(empty($r['prices']))   $prices[$p['id']] = $p['price'];
		$n++;
		$amount_products = $amount_products + ($kols[$p['id']] * $prices[$p['id']]);
		$line .= '
		  <tr>
			<td>'.$n.'</td>
			<td>'.$p['name'].'</td>
			<td>'.$kols[$p['id']].'</td>
			<td>'.$prices[$p['id']].'</td>
			<td>'.$r['admin_name'].'</td>
		  </tr>';
	}
}

if(!empty($line))
{
	?>
    при выполнении работ были использованы следующие запасные части и материалы, оплачиваемые заказчиком:<br />																									
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
      <tr class="title">
        <td>№</td>
        <td>Наименование работ (код)</td>
        <td>Норматив времени,<br />час</td>
        <td>Стоимость услуг,<br />руб</td>
        <td>Исполнитель</td>
      </tr>
          <?=$line?>
      <tr class="title">
        <td></td>
        <td></td>    
        <td align="right"><strong>Итого:</strong></td>
        <td><?=$amount_products?></td>
        <td></td>
      </tr>
    </table>
    <br /><br />
    <?
}
?>



Окончательная стоимость выполненных работ:<br />
<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <tr class="title">
    <td>услуг</td>
    <td>запчастей</td>
    <td>всего</td>
    <td>ставка НДС</td>
    <td>сумма НДС, руб.</td>
    <td>окончательная стоимость заказа с НДС, руб.</td>
  </tr>
  <tr>
    <td><?=$amount_uslug?></td>
    <td><?=$amount_products?></td>
    <td><?=$r['amount']?></td>
    <td>20%</td>
    <td><?=round($r['amount'] / 100 * 20, 2)?></td>
    <td class="red"><?=$r['amount']?></td>
  </tr>
</table>
<br /><br />

		
																												
<strong>Всего:</strong> <?=num2str($r['amount'])?><br />																						
<strong>Сумма НДС:</strong> <?=num2str(round($r['amount'] / 100 * 20, 2))?><br />
<br />																							
<strong>Окончательная стоимость выполненных работ с НДС:</strong> <?=num2str($r['amount'])?><br /><br />																			
																												
																												
Заказ выполнил: _________________ / <?=$r['admin_name']?> /<br />
<span style="margin:0 0 0 120px">механик (подпись)</span><br /><br /><br />																							
																									 			
																												
Руководитель предприятия _________________ / Рыбаков И.Л /<br />																											
<span style="margin:0 0 0 180px">инженер (подпись) М.П.</span><br /><br /><br />	

																											
Заказчик по качеству  и объему выполненных работ претензий не имеет.<br />
Право подписи акта выполненных работ со стороны Заказчика имеет любой сотрудник, уполномоченный на то доверенностью.<br />
Заказчик оплачивает выполненные работы не позднее 5(пяти) календарных дней после подписания настоящего акта.<br />
<br />
С объемом работ согласен, претензий к выполненным работам не имею, ознакомлен,  акт получил:<br /><br />
																												
Заказчик _____________________ / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /<br />				
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