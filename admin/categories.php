<?php
	require ('../globals.php');
    require ('../includes/categories.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    $categoriesObj = new Meals_categories();
    $categories = $categoriesObj->getMealsCategories();

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');
	include ('../templates/back/admin/categories.html');
	include ('../templates/back/admin/footer.html');