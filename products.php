<?php

include('inc/pass_admin.php');

include(DR.'inc/header.php');

?>

<h1>Список товаров / услуг</h1>

<div id="menu">
<a href="info.php">Главная</a>
<a href="edit_product.php">Добавить товар / услугу</a>
</div>


<table border="1" class="table table_products">
  <tr class="title">
    <td>id</td>
    <td>Товар / услуга</td>
    <td>Цена</td>
    <td>Тип</td>
  </tr>
<?
$STH = SQL("SELECT * FROM products WHERE name!='' ORDER BY type,name DESC",__FILE__,__LINE__);
while($r = $STH->fetch())
{
	$type = 'Товар';   if($r['type'] == 1) $type = 'Услуга';
	
	echo '
  <tr>
    <td>'.$r['id'].'</td>
	<td><a href="edit_product.php?id='.$r['id'].'">'.$r['name'].'</a></td>
	<td>'.$r['price'].' руб</td>
	<td>'.$type.'</td>
  </tr>';
}
?>
</table>


