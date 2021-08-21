<?php


//include('inc/pass_admin.php');
include('inc/config.php');
if(empty(ADMIN_ID))
{
	header('location: info.php?'.__LINE__);
	exit;
}



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


require_once 'inc/PHPExcel/PHPExcel/IOFactory.php';
require_once 'inc/PHPExcel/PHPExcel.php';
//$pExcel = PHPExcel_IOFactory::createReader('Excel2007'); // не работает с php >7
//$pExcel = $pExcel->load('inc/act.xlsx');
$pExcel = PHPExcel_IOFactory::createReader('Excel5');
$pExcel = $pExcel->load('inc/docs.xls');


######################################################################
$pExcel->setActiveSheetIndex(0); // СВИДЕТЕЛЬСТВО

// данные
$pExcel->getActiveSheet()->setCellValue('B18', date('d.m.Y', $r['date']));
$pExcel->getActiveSheet()->setCellValue('G18', date('d.m.Y', $r['date'] + (86400 * 365)));
$pExcel->getActiveSheet()->setCellValue('G63', $r['admin_name']);

// фирма
$pExcel->getActiveSheet()->setCellValue('E8', html_entity_decode($r['firma']));
$pExcel->getActiveSheet()->setCellValue('E9', html_entity_decode($r['adr']));
$pExcel->getActiveSheet()->setCellValue('E10', html_entity_decode($r['adr']));
//$pExcel->getActiveSheet()->setCellValue('A2', $r['unp']);
//$pExcel->getActiveSheet()->setCellValue('A3', $r['okpo']);
//$pExcel->getActiveSheet()->setCellValue('A4', html_entity_decode($r['bank']));

// авто
$pExcel->getActiveSheet()->setCellValue('E12', $r['marka'].' '.$r['model']);
$pExcel->getActiveSheet()->setCellValue('E14', $r['vin']);
$pExcel->getActiveSheet()->setCellValue('E16', $r['auto_num']);


// тахограф
$pExcel->getActiveSheet()->setCellValue('C22', $r['name']);
$pExcel->getActiveSheet()->setCellValue('G22', $r['num']);
$pExcel->getActiveSheet()->setCellValue('D26', $r['odometr']);
$pExcel->getActiveSheet()->setCellValue('C30', $r['type']);


######################################################################
$pExcel->setActiveSheetIndex(1); // СЧЁТ

// данные
$pExcel->getActiveSheet()->setCellValue('L9', $r['id']);
$pExcel->getActiveSheet()->setCellValue('R9', date('d.m.Y', $r['date']));

// фирма
$pExcel->getActiveSheet()->setCellValue('F14', html_entity_decode($r['firma']));
$pExcel->getActiveSheet()->setCellValue('F16', html_entity_decode($r['firma']));
$pExcel->getActiveSheet()->setCellValue('W14', $r['unp']);
$pExcel->getActiveSheet()->setCellValue('W16', $r['unp']);
$pExcel->getActiveSheet()->setCellValue('AC14', $r['okpo']);
$pExcel->getActiveSheet()->setCellValue('AC16', $r['okpo']);
//$pExcel->getActiveSheet()->setCellValue('A4', html_entity_decode($r['bank']));

// товары
$products = explode(',', $r['products']);
$kols = json_decode($r['kols'], true);
$prices = json_decode($r['prices'], true);
$STH = SQL("SELECT * FROM products WHERE name!='' AND type='1' ORDER BY name DESC",__FILE__,__LINE__);
$n = 0;
$amount_uslug = 0;
$line = '';
$L = 23; 
while($p = $STH->fetch())
{
	if(in_array($p['id'], $products))
	{
		if(empty($kols[$p['id']]))   $kols[$p['id']] = '';
		if(empty($prices[$p['id']]))   $prices[$p['id']] = '';
		if(empty($r['prices']))   $prices[$p['id']] = $p['price'];
		$n++;
		$amount_uslug = $amount_uslug + ($kols[$p['id']] * $prices[$p['id']]);		
		/*
		$line .= '
		  <tr>
			<td>'.$n.'</td>
			<td>'.$p['name'].'</td>
			<td>'.$kols[$p['id']].'</td>
			<td>'.$prices[$p['id']].'</td>
			<td>'.$r['admin_name'].'</td>
		  </tr>';
		  */
		 $type = 'шт';  if($p['type'] == 1) $type = 'норма-часы';
		  
		 $pExcel->getActiveSheet()->setCellValue('A'.$L, $n);
		 $pExcel->getActiveSheet()->setCellValue('C'.$L, $p['name']);
		 $pExcel->getActiveSheet()->setCellValue('L'.$L, $type);
		 $pExcel->getActiveSheet()->setCellValue('N'.$L, $kols[$p['id']]);
		 $pExcel->getActiveSheet()->setCellValue('P'.$L, $prices[$p['id']]);
		 $pExcel->getActiveSheet()->setCellValue('S'.$L, ($kols[$p['id']] * $prices[$p['id']]) / 100 * 80);
		 $pExcel->getActiveSheet()->setCellValue('Y'.$L, ($kols[$p['id']] * $prices[$p['id']]) / 100 * 20);
		 $pExcel->getActiveSheet()->setCellValue('AC'.$L, ($kols[$p['id']] * $prices[$p['id']]));
		 $L++;
	}
}

######################################################################
$pExcel->setActiveSheetIndex(2); // АКТ

// данные
$pExcel->getActiveSheet()->setCellValue('N3', $r['id'].' от '.date('d.m.Y', $r['date']));

// фирма
$pExcel->getActiveSheet()->setCellValue('A5', html_entity_decode($r['firma']));
//$pExcel->getActiveSheet()->setCellValue('A4', html_entity_decode($r['bank']));

// авто
$pExcel->getActiveSheet()->setCellValue('A14', $r['marka'].' '.$r['model']);


######################################################################


//$objWriter = PHPExcel_IOFactory::createWriter($pExcel, 'Excel2007');
//$objWriter->save('inc/act.xlsx');

//$objWriter = PHPExcel_IOFactory::createWriter($pExcel, 'Excel5');
//$objWriter->save('inc/act.xls');
//exit;


header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=act_'.$id.'.xls');

$writer = PHPExcel_IOFactory::createWriter($pExcel, 'Excel5');
$writer->save('php://output');

?>