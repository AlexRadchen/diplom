<?php

include('inc/pass_admin.php');


//client
if(!empty($_GET['client']))
{
	$client = htmlpost($_GET['client']);	
	if(!preg_match("/^[0-9]+$/", $client)) 
	{
		header('location: clients.php');
		exit;
	}
	//данные 
	$STH = SQL("SELECT * FROM clients WHERE id='".$client."' LIMIT 1",__FILE__,__LINE__);
	$c = $STH->fetch();
}
else{
	if(empty($_GET['w']))
	{
		header('location: clients.php');
		exit;
	}
}

include(DR.'inc/header.php');

?>


<?
if(!empty($_GET['w']))
{
	?>
    <h1>Список авто</h1>
    
    <strong><?=ADMIN['name']?></strong><br /><br />
    <a href="info.php">Главная</a> / 
    <a href="clients.php">Список клиентов</a>
    <br /><br />
    <?
	$w = htmlpost($_GET['w']);
	$STH = SQL("SELECT * FROM auto WHERE 
			   							marka LIKE '%".$w."%' OR 
										model LIKE '%".$w."%' OR 
										num LIKE '%".$w."%' OR 
										vin LIKE '%".$w."%' OR 
										zam LIKE '%".$w."%'
											ORDER BY id DESC",__FILE__,__LINE__);
	echo '<h3>Поиск авто: <em>'.$w.'</em></h3>';
}
else{
	$STH = SQL("SELECT * FROM auto WHERE model!='' AND client='".$c['id']."' ORDER BY id DESC",__FILE__,__LINE__);
?>
<h1>Список авто клиента</h1>

<a href="info.php">Главная</a> / 
<a href="clients.php">Список клиентов</a> / 
<strong><?=$c['firma']?></strong>
<br /><br />

<a href="edit_auto.php?client=<?=$c['id']?>">Добавить авто</a><br /><br />
<? } ?>

<table border="1" class="table table_auto">
  <tr class="title">
    <td>id</td>
    <td>Авто</td>
    <td>Гос.номер</td>
    <td>VIN</td>
    <td>Тахограф</td>
  </tr>
<?
while($r = $STH->fetch())
{
	//auto 
	$STH2 = SQL("SELECT num FROM tahograf WHERE auto='".$r['id']."' AND level='1' LIMIT 1",__FILE__,__LINE__);
	$t = $STH2->fetch();	
	$tahograf = 'нет'; if(!empty($t['num'])) $tahograf = $t['num'];
	
	echo '
  <tr>
    <td>'.$r['id'].'</td>
	<td>'.$r['marka'].' '.$r['model'].'</td>	
	<td>'.$r['num'].'</td>
	<td><a href="edit_auto.php?client='.$r['client'].'&id='.$r['id'].'">'.$r['vin'].'</a></td>
	<td><a href="tahograf.php?auto='.$r['id'].'">'.$tahograf.'</a></td>
  </tr>';
}
?>
</table>


