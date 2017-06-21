<?php
	// get all meals page
	require ('../globals.php');
	require ('../includes/meals.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');


	$mealsObj = new Meals();
	$meals = $mealsObj->getMeals();

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');
	include ('../templates/back/admin/meals.html');
	include ('../templates/back/admin/footer.html');



