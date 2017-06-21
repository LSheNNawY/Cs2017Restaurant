<?php
	require ('../globals.php');
    require ('../includes/categories.class.php');
    require ('../includes/meals.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    $success = '';
    $error = '';
    if (count($_POST) > 0)
    {
        $category_title = $_POST['category'];

        $categoriesObj = new Meals_categories();
        if ($categoriesObj->addCategory($category_title))
            $success = 'category added successfully';
        else
            $error = 'Error adding category';
    }

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');
	include ('../templates/back/admin/addcategory.html');
	include ('../templates/back/admin/footer.html');