<?php
	require ('../globals.php');
	require ('../includes/tables.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

	$tablesObject = new Tables();
	$tables       = $tablesObject->getTables();

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');
	if($tables && count($tables) > 0 )
	    include ('../templates/back/admin/tables.html');

	include ('../templates/back/admin/footer.html');

