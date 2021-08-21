<?php

include('inc/pass_admin.php');

include(DR.'inc/header.php');

?>

<div id="menu">
<a href="clients.php">Клиенты</a> <a href="products.php">Товары/услуги</a><br /><br />
</div>

<form action="clients.php" method="get">
<input type="text" name="w" value="" placeholder="Поиск клиента" /> <button type="submit" class="button">Найти</button>
</form><br />

<form action="auto.php" method="get">
<input type="text" name="w" value="" placeholder="Поиск авто" /> <button type="submit" class="button">Найти</button>
</form><br />

<form action="tahograf.php" method="get">
<input type="text" name="w" value="" placeholder="Поиск тахографа" /> <button type="submit" class="button">Найти</button>
</form><br />


<h2>Последние акты</h2>
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
$STH = SQL("SELECT * FROM acts WHERE date>10 ORDER BY id DESC LIMIT 20",__FILE__,__LINE__);
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
<br /><br />
<h2>Статистика</h2>
<table border="1" class="table">
  <tr>
    <td align="left">
    	<strong>Всего</strong><br />
		<?
        $STH = SQL("SELECT id FROM clients WHERE firma!=''",__FILE__,__LINE__);
        echo 'Клиенты: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM auto WHERE num!=''",__FILE__,__LINE__);
        echo 'Авто: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM tahograf WHERE level=1",__FILE__,__LINE__);
        echo 'Тахографы: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM acts WHERE date>10",__FILE__,__LINE__);
        echo 'Акты: '.$STH->rowCount().'<br />';
        ?>
    </td>
    <td align="left">    	
		<?
		$d = '01.'.date('m.Y', time() - (86400*30));
		echo '<strong>В прошлом месяце ('.date('M', strtotime($d)).')</strong><br />';
		$t = strtotime($d);
		
        $STH = SQL("SELECT id FROM clients WHERE firma!='' AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Клиенты: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM auto WHERE num!='' AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Авто: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM tahograf WHERE level=1 AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Тахографы: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM acts WHERE date>10 AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Акты: '.$STH->rowCount().'<br />';
        ?>
    </td>
    <td align="left">    	
		<?
		$d = '01.'.date('m.Y');
		echo '<strong>В этом месяце ('.date('M', strtotime($d)).')</strong><br />';
		$t = strtotime($d);
		
        $STH = SQL("SELECT id FROM clients WHERE firma!='' AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Клиенты: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM auto WHERE num!='' AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Авто: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM tahograf WHERE level=1 AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Тахографы: '.$STH->rowCount().'<br />';
        
        $STH = SQL("SELECT id FROM acts WHERE date>10 AND date>='".$t."'",__FILE__,__LINE__);
        echo 'Акты: '.$STH->rowCount().'<br />';
        ?>
    </td>
  </tr>
</table>
<br /><br /><br />
<div id="copy">&copy; Радченко А.П. 2021</div>
