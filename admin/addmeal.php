<?php 
	// add new meal page
	require ('../globals.php');
	require ('../includes/categories.class.php');
	require ('../includes/meals.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

	

	$success = '';
	$error = '';

	// check if the form is submitted
	if (count($_POST) > 0)
	{
		$meal_title 		= $_POST['meal_title'];
		$meal_category 		= $_POST['meal_category'];
		$meal_description 	= $_POST['meal_description'];
		$meal_price 		= $_POST['meal_price'];

		$meal_image 		= '';

		// check if the file [image] is uploaded
        if (count($_FILES) > 0)
        {
            // uploaded image details
            $name = $_FILES['meal_image']['name'];
            $type = $_FILES['meal_image']['type'];
            $size = $_FILES['meal_image']['size'];
            $temp = $_FILES['meal_image']['tmp_name'];
            $err  = $_FILES['meal_image']['error'];

            // generate new name for the image
            $newName = md5(date('U').rand(1000, 10000)).$name;

            // check the uploaded image type and make sure that there is no error
            if (($type == 'image/png' || 'image/jpeg' || 'image/jpg') && $err == 0) 
            {
                // check if the image uploaded successfully and move it to upload directory
                move_uploaded_file($temp, '../uploads/meals/' . $newName);
                // the full path of the image
                $meal_image = $newName;
            }
        }

		$mealsObj = new Meals();
		if ($mealsObj->addMeal($meal_title, $meal_category, $meal_description, $meal_image, $meal_price))
			$success = 'Meal added successfully';
		else
			$error = 'Error adding meal';
	} 

	// get meals categories
	$categoriesObj = new Meals_categories();
	$categories = $categoriesObj->getMealscategories();

	include ('../templates/back/admin/header.html');
	include ('../templates/back/admin/menu.html');
	include ('../templates/back/admin/addmeal.html');
	include ('../templates/back/admin/footer.html');


	
