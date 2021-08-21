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
	
	//auto 
	$STH = SQL("SELECT * FROM auto WHERE id='".$auto."' LIMIT 1",__FILE__,__LINE__);
	$a = $STH->fetch();
	
	//client 
	$STH = SQL("SELECT * FROM clients WHERE id='".$a['client']."' LIMIT 1",__FILE__,__LINE__);
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
    <h1>Список тахографов</h1>
    
    <a href="info.php">Главная</a> / 
    <a href="clients.php">Список клиентов</a>
    <br /><br />
    <?
	$w = htmlpost($_GET['w']);
	$STH = SQL("SELECT * FROM tahograf WHERE 
			   							name LIKE '%".$w."%' OR 
										num LIKE '%".$w."%' OR 
										zam LIKE '%".$w."%' 
											ORDER BY id DESC",__FILE__,__LINE__);
	echo '<h3>Поиск тахографа: <em>'.$w.'</em></h3>';
}
else{
	$STH = SQL("SELECT * FROM tahograf WHERE num!='' AND auto='".$a['id']."' ORDER BY id DESC",__FILE__,__LINE__);
?>
<h1>Список тахографов на авто</h1>

<strong><?=ADMIN['name']?></strong><br /><br />
<a href="info.php">Главная</a> / 
<a href="clients.php">Список клиентов</a> / 
<?=$c['firma']?> / 
<a href="auto.php?client=<?=$c['id']?>">Все авто</a> / 
<strong><?=$a['marka']?> <?=$a['model']?> <?=$a['num']?></strong>
<br /><br />

<a href="edit_tahograf.php?auto=<?=$a['id']?>">Добавить тахограф</a><br /><br />
<? } ?>


<table border="1" class="table table_tahograf">
  <tr class="title">
    <td>id</td>
    <td>Марка</td>
    <td>Номер</td>
    <td>К</td>
    <td>Одометр</td>
    <td>Тип шины</td>
    <td>L</td>
    <td>W</td>
    <td>Статус</td>
    <td>Акты</td>
  </tr>
<?
while($r = $STH->fetch())
{
	$level = 'откл.'; if($r['level'] == 1) $level = 'ВКЛ.'; 
	$STH2 = SQL("SELECT id FROM acts WHERE date>10 AND tahograf='".$r['id']."'",__FILE__,__LINE__);
	
	echo '
  <tr>
    <td>'.$r['id'].'</td>
	<td>'.$r['name'].'</td>
	<td><a href="edit_tahograf.php?auto='.$r['auto'].'&id='.$r['id'].'">'.$r['num'].'</a></td>
	<td>'.$r['k'].'</td>	
	<td>'.$r['odometr'].'</td>	
	<td>'.$r['type'].'</td>
	<td>'.$r['len'].'</td>
	<td>'.$r['w'].'</td>
	<td>'.$level.'</td>
	<td><a href="acts.php?tahograf='.$r['id'].'">'.$STH2->rowCount().'</a></td>
  </tr>';
}
?>
</table>


