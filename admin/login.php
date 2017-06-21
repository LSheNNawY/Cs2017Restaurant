<?php
    require('../globals.php');
    require('../includes/users.class.php');

    if(checkLogin())
        exit('Youe are already logged in.');

    $error   = '';
    $success = '';

    if(count($_POST) > 0)
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userObject = new Users();
        $userData = $userObject->login($email, $password);

        if($userData && count($userData) > 0)
        {
            $_SESSION['user'] = $userData;

            // check user type to edirect him
            if (checkAdminLogin())
                header('LOCATION: index.php');
            else
                header('LOCATION: ../index.php');
        }

        else
            $error = 'Invalid email address or password  ';
    }


    include('../templates/back/admin/login.html');
