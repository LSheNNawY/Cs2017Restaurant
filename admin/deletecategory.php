<?php 
	require ('../globals.php');
	require ('../includes/categories.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    if (count($_POST) > 0)
    {
        // meal id comes with ajax
        $category_id = $_POST['category_id'];

        // success and failure varables
        $success = '';
        $error = '';
        // collect result variables in array
        $resultArr = array();
        // deleting category by id
        $catObj = new Meals_categories();
        // delete category 
        $deleteCategory = $catObj->deletCategory($category_id);
        // check if the category updated successfully
        if($deleteCategory)
            $success = 'Category deleted successfully';
        else
            $error = 'Error deleting category!';

        // adding success and error variables to result array
        $resultArr['success'] = $success;
        $resultArr['error'] = $error;
        // encoding result array as json to use with ajax
        echo json_encode($resultArr);
    } 
