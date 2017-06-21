<?php 
	require ('../globals.php');
	require ('../includes/orders.class.php');


	// check check admin login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');


	$ordersObj = new Orders();
	$orders = $ordersObj->getOrders();

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');
	include ('../templates/back/admin/orders.html');
	include ('../templates/back/admin/footer.html');