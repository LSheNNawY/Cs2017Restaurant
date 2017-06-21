<?php
    require ('../globals.php');
    require ('../includes/tables.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    $userObject = new Tables();
    //get table by url id
    $idFromUrl   = isset($_GET['id'])? (int)$_GET['id'] : 0;
    $table       = $userObject->getTableById($idFromUrl);

    $error   = '';
    $success = '';

    if(count($_POST) > 0)
    {
        $idFromForm   = $_POST['table_id'];
        $title        = $_POST['title'];
        $number       = $_POST['number'];
        $available    = $_POST['available'];

        if(strlen($title) >= 2)
        {
            if ($userObject->updateTable($idFromForm,$title,$number,$available))
                $success = 'Table updated successfully';
            else
                $error = 'Error updating table';
        }
        else
            $error = 'Table title must equal or greate than 2 characters';
    }

    include ('../templates/back/admin/header.html');
    include ('../templates/back/admin/menu.html');
    include ('../templates/back/admin/updatetable.html');
    include ('../templates/back/admin/footer.html');