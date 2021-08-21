<?php

include('inc/pass_admin.php');


//tahograf
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
	header('location: clients.php');
	exit;
}


//tahograf 
$STH = SQL("SELECT * FROM tahograf WHERE id='".$tahograf."' LIMIT 1",__FILE__,__LINE__);
$t = $STH->fetch();

//auto 
$STH = SQL("SELECT * FROM auto WHERE id='".$t['auto']."' LIMIT 1",__FILE__,__LINE__);
$a = $STH->fetch();

//client 
$STH = SQL("SELECT * FROM clients WHERE id='".$a['client']."' LIMIT 1",__FILE__,__LINE__);
$c = $STH->fetch();


include(DR.'inc/header.php');

?>

<h1>Список актов на тахограф</h1>

<a href="info.php">Главная</a> / 
<a href="clients.php">Список клиентов</a> / 
<strong><?=$c['firma']?></strong> / 
<a href="auto.php?client=<?=$c['id']?>">Все авто</a> / 
<strong><?=$a['marka']?> <?=$a['model']?> <?=$a['num']?></strong> /
<a href="tahograf.php?auto=<?=$a['id']?>">Все тахографы</a> / 
<strong><?=$t['num']?></strong>
<br /><br />

<a href="edit_act.php?tahograf=<?=$t['id']?>">Добавить акт</a><br /><br />


<table border="1" class="table table_acts">
  <tr class="title">
    <td>id</td>
    <td>Дата</td>
    <td>Клиент</td>
    <td>Сумма</td>
    <td>Акт</td>
    <td>Счёт</td>
    <td>Свид.</td>
    <td></td>
  </tr>

<?

$STH = SQL("SELECT * FROM acts WHERE date>10 AND tahograf='".$t['id']."' ORDER BY id DESC",__FILE__,__LINE__);
while($r = $STH->fetch())
{
	$STH2 = SQL("SELECT id,firma FROM clients WHERE id='".$r['client']."' LIMIT 1",__FILE__,__LINE__);
	$c = $STH2->fetch();
	echo '
  <tr>
    <td>'.$r['id'].'</td>
	<td><a href="edit_act.php?id='.$r['id'].'">'.date('d.m.Y', $r['date']).'</a></td>
	<td><a href="auto.php?client='.$c['id'].'">'.$c['firma'].'</a></td>
	<td>'.$r['amount'].' руб</td>
	<td><a href="print_act.php?id='.$r['id'].'" target="_blank">Печать</a></td>
	<td><a href="print_bill.php?id='.$r['id'].'" target="_blank">Печать</a></td>
	<td><a href="print_certificate.php?id='.$r['id'].'" target="_blank">Печать</a></td>
	<td><a href="exel_act.php?id='.$r['id'].'" target="_blank">XLS</a></td>
  </tr>';
}

?>
</table>


