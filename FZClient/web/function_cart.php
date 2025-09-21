<?php

$cart = $_SESSION['cart'];

$action = $_GET['action'];
$unidades = $_GET['unidades'];
switch ($action) {
	case 'add':
		for($i = 0; $i < $unidades; $i++){
			if ($cart) {
				$cart .= ','.$_GET['id_producto'];
			} else {
				$cart = $_GET['id_producto'];
			}
		}
		break;
	case 'disminuir':
		if ($cart) {
			$items = explode(',',$cart);
			$newcart = '';
			$id = $_REQUEST['id_producto'];
			$i = 0;
			foreach ($items as $item) {
				//echo($_REQUEST['id_producto']." != ".$item."<br>");
				if ($id != $item) {
					if ($newcart != '') {
						$newcart .= ','.$item;
					} else {
						$newcart = $item;
					}
				}else{
					$i++;
				}
				if($i == $unidades){
					$id = "";
				}
			}
			$cart = $newcart;
		}
		break;
	case 'delete':
		if ($cart) {
			$items = explode(',',$cart);
			$newcart = '';
			foreach ($items as $item) {
				//echo($_REQUEST['id_producto']." != ".$item."<br>");
				if ($_REQUEST['id_producto'] != $item) {
					if ($newcart != '') {
						$newcart .= ','.$item;
					} else {
						$newcart = $item;
					}
				}
			}
			$cart = $newcart;
		}
		break;


		
// NO SE USA		
		
	case 'update':
	if ($cart) {
		$newcart = '';
		foreach ($_POST as $key=>$value) {
			if (stristr($key,'qty')) {
				$id = str_replace('qty','',$key);
				$items = ($newcart != '') ? explode(',',$newcart) : explode(',',$cart);
				$newcart = '';
				foreach ($items as $item) {
					if ($id != $item) {
						if ($newcart != '') {
							$newcart .= ','.$item;
						} else {
							$newcart = $item;
						}
					}
				}
				for ($i=1;$i<=$value;$i++) {
					if ($newcart != '') {
						$newcart .= ','.$id;
					} else {
						$newcart = $id;
					}
				}
			}
		}
	}
	$cart = $newcart;
	break;
}

$_SESSION['cart'] = $cart;

if($_REQUEST['vaciar'] == "ok"){
	session_destroy();
	header("Location: ventas.php");
}

?>
