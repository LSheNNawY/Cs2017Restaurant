<?php

    require ('../globals.php');
    require ('../includes/users.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
    {
        header('Location: login.php');
        exit;
    }

    $error   = '';
    $success = '';
    if(count($_POST) > 0)
    {
        $username = htmlentities($_POST['username']);
        $password = $_POST['password'];
        $email    = htmlentities($_POST['email']);
        $address  = htmlentities($_POST['address']);
        $phone    = htmlentities($_POST['phone']);
        $type     = $_POST['type'];

        // errors array 
        $errors = array();

        // check username field
        if (empty($username))
            $errors[] = 'Username is a required field.';
        elseif (strlen($username) > 0 && strlen($username) < 3) 
            $errors[] = 'Username must be at least 3 chars.';
        elseif (strlen($username) > 15)
            $errors[] = 'Username can\'t be more than 15 chars.';

        // check email feild
        if (empty($email))
            $errors[] = 'Email is a required field.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'Invalid email address';

        // check password
        if (empty($password))
            $errors[] = 'Password is a required field.';
        elseif (strlen($password) > 0 && strlen($password) < 6) 
            $errors[] = 'Password must be at least 6 chars.';
        elseif (strlen($password) > 25)
            $errors[] = 'Password can\'t be more than 25 chars.';

        // check address
        if (empty($address))
            $errors[] = 'Address is a required field.';
        elseif (strlen($address) > 0 && strlen($address) < 5) 
            $errors[] = 'Address must be at least 5 chars.';
        elseif (strlen($address) > 30)
            $errors[] = 'Address can\'t be more than 30 chars.';

        // check phone number 
        if (empty($phone))
            $errors[] = 'Phone number is a required field.';
        elseif(!preg_match('/^[0-9\/-]+$/', trim($phone)))
            $errors[] = 'Invalid phone number.';
        
        if (count($errors) == 0)
        {
            $userObject = new Users();

            if ($userObject->addUser($username, $password,$email,$phone,$address,$type))
                $success = 'User added successfully';
            else
                $error = 'Error adding user';
        } else 
            $_SESSION['errors'] = $errors;


        


    }

    include ('../templates/back/admin/header.html');
    include ('../templates/back/admin/menu.html');
    include ('../templates/back/admin/adduser.html');
    include ('../templates/back/admin/footer.html');