<?php
    require ('../globals.php');
    require ('../includes/categories.class.php');
    require ('../includes/meals.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    include ('../templates/back/admin/header.html');
    include ('../templates/back/admin/menu.html');

    $success = '';
    $error = '';

    $categoriesObj = new Meals_categories();
    //get category by url id
    $idFromUrl  = isset($_GET['cat_id'])? (int)$_GET['cat_id'] : 0;
    $category = $categoriesObj-> getCategoryById($idFromUrl);


    if(count($_POST) > 0)
    {
        $category_id      = $_POST['category_id'];
        $category_title   = $_POST['category_title'];
    
        if(strlen($category_title) > 3)
        {
            if ($categoriesObj->updateCategory($category_id, $category_title))
                $success = 'Category updated successfully';
            else
                $error = "Error updating category";
        }
        else
            $error = 'Category title must be greater than 3 characters';
    }   
     
    include ('../templates/back/admin/updatecategory.html');
    include ('../templates/back/admin/footer.html');

    