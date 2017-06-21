<?php

    require ('../globals.php');
    require ('../includes/tables.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    $error   = '';
    $success = '';

    if(count($_POST) > 0)
    {
        $title  = $_POST['title'];
        $number = $_POST['number'];

        $userObject = new Tables();

        if(strlen($title) >= 2)
        {
            if ($userObject->addTable($title,$number))
                $success = 'Table added successfully';
            else 
                $error = 'Error adding table!';
        }
        else
            $error = 'Table title must equal or greate than 2 characters';
    }

    include ('../templates/back/admin/header.html');
    include ('../templates/back/admin/menu.html');
    include ('../templates/back/admin/addtable.html');
    include ('../templates/back/admin/footer.html');