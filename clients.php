<?php

include('inc/pass_admin.php');

include(DR.'inc/header.php');

?>

<h1>Список клиентов</h1>


<div id="menu">
<a href="info.php">Главная</a>
<a href="edit_client.php">Добавить клиента</a>
</div>



<?
$STH = SQL("SELECT * FROM clients WHERE firma!='' ORDER BY id DESC",__FILE__,__LINE__);

if(!empty($_GET['w']))
{
	$w = htmlpost($_GET['w']);
	$STH = SQL("SELECT * FROM clients WHERE 
			   							firma LIKE '%".$w."%' OR 
										unp LIKE '%".$w."%' OR 
										okpo LIKE '%".$w."%' OR 
										adr LIKE '%".$w."%' OR 
										phone LIKE '%".$w."%' OR 
										bank_rs LIKE '%".$w."%' OR 
										zam LIKE '%".$w."%'
											ORDER BY firma",__FILE__,__LINE__);
	echo '<h3>Поиск: <em>'.$w.'</em></h3>';
}
?>
<table border="1" class="table table_client">
  <tr class="title">
    <td>id</td>
    <td>ФИО</td>
    <td>УНП</td>
    <td>Телефон</td>
    <td>№ договора</td>
    <td>Автомобили</td>
  </tr>
<?
while($r = $STH->fetch())
{
	$dog = ''; if(!empty($r['dog_num'])) $dog = '№'.$r['dog_num'].'Т от '.date('d.m.Y', $r['dog_date']);
	$STH2 = SQL("SELECT id FROM auto WHERE model!='' AND client='".$r['id']."'",__FILE__,__LINE__);
	echo '
  <tr>
    <td>'.$r['id'].'</td>
	<td><a href="edit_client.php?id='.$r['id'].'">'.$r['firma'].'</a></td>
	<td>'.$r['unp'].'</td>
	<td>'.$r['phone'].'</td>
	<td>'.$dog.'</td>
	<td><a href="auto.php?client='.$r['id'].'">'.$STH2->rowCount().'</a></td>
  </tr>';
}
?>
</table>


