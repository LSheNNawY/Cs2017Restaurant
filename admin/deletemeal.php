<?php 
	require ('../globals.php');
	require ('../includes/meals.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    if (count($_POST) > 0)
    {
        // meal id comes with ajax
        $meal_id = $_POST['meal_id'];

        // success and failure varables
        $success = '';
        $error = '';
        // collect result variables in array
        $resultArr = array();
        // deleting meal by id
        $mealObj = new Meals();
        // get meal data to delete its image
        $mealData = $mealObj->getMealById($meal_id);
        // delete meal 
        $deleteMeal = $mealObj->deleteMeal($meal_id);
        // check if the meal updated successfully
        if($deleteMeal)
        {
            // delete the image of deleted meal if existed
            if(file_exists('../uploads/meals/'.$mealData['meal_image']))
                unlink('../uploads/meals/'.$mealData['meal_image']);
            
            $success = 'Meal deleted successfully';
        } 
        else
            $error = 'Error deleting meal!';

        // adding success and error variables to result array
        $resultArr['success'] = $success;
        $resultArr['error'] = $error;
        // encoding result array as json to use with ajax
        echo json_encode($resultArr);
    } 
