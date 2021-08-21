<?php

include('inc/pass_admin.php');

//id
if(!empty($_GET['id']))
{
	$id = htmlpost($_GET['id']);	
	if(!preg_match("/^[0-9]+$/", $id)) 
	{
		header('location: products.php');
		exit;
	}
}
else{
	//найти в базе
	$STH = SQL("SELECT id FROM products WHERE name='' LIMIT 1",__FILE__,__LINE__);
	$r = $STH->fetch();	
	if(empty($r['id'])) 
	{
		//создать
		SQL("INSERT INTO products (date) VALUES ('".time()."')",__FILE__,__LINE__);
		
		//найти в базе
		$STH = SQL("SELECT id FROM products ORDER BY id DESC LIMIT 1",__FILE__,__LINE__);
		$r = $STH->fetch();
	}		
	header('location: edit_product.php?id='.$r['id']);
	exit;
}


//данные 
$STH = SQL("SELECT * FROM products WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
$r = $STH->fetch();


###############################################################################################
if(!empty($_POST['save']))
{

//name
if(!empty($_POST['name']))
{
	$name = htmlpost($_POST['name']);
}
else{
	$ups .= 'Введите название товара или услуги<br />';
}

//price
$price = '';
if(!empty($_POST['price']))
{
	$price = htmlpost($_POST['price']);
	$price = str_replace([',','*','/','-','+'], '.', $price);
}

//type
$type = 0;
if(!empty($_POST['type']))
{
	$type = 1;
}

//обновить в бд
if(empty($ups))
{
	SQL("UPDATE products SET 
									 modif='".time()."',
									 name='".$name."', 
									 price='".$price."',
									 type='".$type."'
												 WHERE id='".$id."' LIMIT 1",__FILE__,__LINE__);
	$oke .= 'Данные сохранены<br />';
}

echo ups($ups);
echo oke($oke);
exit;
}
###############################################################################################

include(DR.'inc/header.php');

?>

<h1>Редактор товаров / услуг</h1>

<a href="info.php">Главная</a> / <a href="products.php">Список товаров / услуг</a>


<form id="form">
<br />
<br />
Наименование <input type="text" name="name" value="<?=$r['name']?>" style="width:500px" /><br /><br />
Цена <input type="text" name="price" value="<?=$r['price']?>" style="width:100px" /> руб<br /><br />

Тип <select size="1" name="type">
<option value="0" <? if($r['type']!=1){echo 'selected="selected"';} ?>>Товар</option>
<option value="1" <? if($r['type']==1){echo 'selected="selected"';} ?>>Услуга</option>
</select><br /><br />

<div class="status"></div>
<button type="submit" class="button" onclick="form_send('form'); return false">Сохранить</button>
<br />
<br />
<br />
<br />
</form>


