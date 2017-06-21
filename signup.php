<?php
    require ('globals.php');
    require ('includes/users.class.php');

    $active = 'login';

    $success = "";
    $error   = "";

    // ********** login ********* //
    if (isset($_POST['login']))
    {
        $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];


        $user     = new Users();
        $userData = $user->login($email, $password);

        if($userData && count($userData) > 0)
        {
            $_SESSION['user'] = $userData;

            if(checkLogin())
                header('LOCATION: index.php');
        }
        else
            $error = "Invalid Data Entered!!";
    }

    //*********** sign Up **********//
    if(isset($_POST['signup']))
    {
        $username  = htmlentities($_POST['username']);
        $email     = htmlentities($_POST['email']);
        $password  = $_POST['password'];
        $address   = htmlentities($_POST['address']);
        $phone     = htmlentities($_POST['phone']);

        // array of errors
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
        
        // check if there were errors 
        if (count($errors) == 0)
        {
            $user      = new Users();
            $userData  = $user->addUser($name,$password,$email,$phone,$address);
            if($userData)
            {
                $userLogin           =  $user->login($email,$password);
                $_SESSION['user']    = $userLogin;
                if(checkLogin())
                    header('LOCATION: index.php');
            }
            else
                $error = "Invalid Data Entered!!";

        } else
            $_SESSION['errors'] = $errors;
    }


    include ('templates/front/header.html');
    include ('templates/front/login.html');
    include ('templates/front/footer.html');