<?php

include('pass.php');

include(DR.'inc/header.php');

?>

<h1>Список админов</h1>

<a href="edit.php">Добавить админа</a><br /><br />


<table border="1" class="table">
  <tr class="title">
    <td>id</td>
    <td>ФИО</td>
    <td>E-mail</td>
    <td>Телефон</td>
    <td>Статус</td>
  </tr>

<?

$STH = SQL("SELECT * FROM admins WHERE level>0 ORDER BY id DESC",__FILE__,__LINE__);
while($r = $STH->fetch())
{
	$level = 'откл.'; if($r['level'] == 1) $level = 'ВКЛ.'; 
	
	echo '
  <tr>
    <td>'.$r['id'].'</td>
	<td><a href="edit.php?id='.$r['id'].'">'.$r['name'].'</a></td>
	<td>'.$r['email'].'</td>
	<td>'.$r['phone'].'</td>
	<td>'.$level.'</td>
  </tr>';
}

?>
</table>
