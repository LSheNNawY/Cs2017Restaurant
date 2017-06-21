<?php 
    require ('../globals.php');
    require ('../includes/categories.class.php');
    require ('../includes/meals.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');
	
    include('../templates/back/admin/header.html');
    include('../templates/back/admin/menu.html');

    // success and error variables
    $success = '';
    $error = '';

    // check if admin submitted the form 
    if (count($_POST) > 0) 
    {
        // meal id
        $postedMealId = $_POST['meal_id'];

        // get meal details after posting the form 
    	$mealObj = new Meals();
        $mealAfterPostingForm = $mealObj->getMealById($postedMealId);

        $meal_image = $mealAfterPostingForm['meal_image'];

        // checking uploaded image
        if (count($_FILES) > 0)
        {
            // uploaded image details
            $imgName  = $_FILES['meal_image']['name'];
            $imgType  = $_FILES['meal_image']['type'];
            $imgTemp  = $_FILES['meal_image']['tmp_name'];
            $imgError = $_FILES['meal_image']['error'];
            $imgSize  = $_FILES['meal_image']['size'];

            // generate new name for the image
            $newName = md5(date('U').rand(1000, 10000)).$imgName;

            // check the uploaded image type and make sure that there is no error
            if(($imgType == 'image/jpeg' || $imgType == 'image/png') && $imgError == 0)
            {
                // check if the image uploaded successfully and move it to upload directory
                if (move_uploaded_file($imgTemp, '../uploads/meals/'.$newName))
                {
                    // check and delete user's image if existed
                    if (file_exists('../uploads/meals/'.$meal_image))
                    {
                        // delete old image after updating
                        unlink('../uploads/meals/'.$meal_image);
                    }

                    $meal_image = $newName;
                }
            }

        }

        // sumitted data
        $meal_title         = $_POST['meal_title'];
        $meal_category      = $_POST['meal_category'];
        $meal_description   = $_POST['meal_description'];
        $meal_price   = $_POST['meal_price'];
        // check if the meal updated or not
        if ($mealObj->updateMeal($postedMealId, $meal_title, $meal_category, $meal_description, $meal_image, $meal_price))
            $success = 'Meal updated successfully';
        else
            $error = 'Error updating meal';
    }
    else
    {
        // get lesson id from url before submitting the form
        $urlMealId = (isset($_GET['meal_id']))? (int)$_GET['meal_id']: 0;

        // get meal details
        $mealObj = new Meals();
        $meal = $mealObj->getMealById($urlMealId);
        // get categories
        $categoryObj = new Meals_categories();
        $categories = $categoryObj->getMealsCategories();
    }

    include('../templates/back/admin/updatemeal.html');
    include('../templates/back/admin/footer.html');