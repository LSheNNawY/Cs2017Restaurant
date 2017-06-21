<?php

	require ('../globals.php');
	require ('../includes/users.class.php');
	require ('../includes/tables.class.php');
	require ('../includes/users_tables.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . ' <a href="login.php">Login</a>');


	$utObject    = new UsersTables();
	$objects = $utObject->getAllReservations();

	$error = '';

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');

	if($objects && count($objects) > 0)
	    include ('../templates/back/admin/users_tables.html');

	else
	    $error = 'There are no users ';

	include ('../templates/back/admin/footer.html');


