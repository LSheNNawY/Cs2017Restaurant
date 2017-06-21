<?php

	require ('../globals.php');
	require ('../includes/users.class.php');

	// check check admin login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');

	$usersObject = new Users();
	$users = $usersObject->getUsers();

	if($users && count($users)>0 )
	    include ('../templates/back/admin/users.html');

	include ('../templates/back/admin/footer.html');

