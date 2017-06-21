<?php
    require ('../globals.php');
    require ('../includes/users.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    $userObject = new Users();
    //get user by url id
    $idFromUrl  = isset($_GET['id'])? (int)$_GET['id'] : 0;
    $user       = $userObject->getUserById($idFromUrl);

    $error   = '';
    $success = '';

    if(count($_POST) > 0)
    {
        $idFromForm       = $_POST['user_id'];
        $username         = htmlentities($_POST['username']);
        $password         = $_POST['password'];
        $email            = htmlentities($_POST['email']);
        $address          = htmlentities($_POST['address']);
        $phone            = htmlentities($_POST['phone']);
        $type             = $_POST['type'];


        // array of errors
        $errors = array();

        // check username field
        if (strlen($username) > 0 && strlen($username) < 3) 
            $errors[] = 'Username must be at least 3 chars.';
        elseif (strlen($username) > 15)
            $errors[] = 'Username can\'t be more than 15 chars.';

        // check email feild
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'Invalid email address';

        // check password
        if (strlen($password) > 0 && strlen($password) < 6) 
            $errors[] = 'Password must be at least 6 chars.';
        elseif (strlen($password) > 25)
            $errors[] = 'Password can\'t be more than 25 chars.';


        // check address
        if (strlen($address) > 0 && strlen($address) < 5) 
            $errors[] = 'Address must be at least 5 chars.';
        elseif (strlen($address) > 30)
            $errors[] = 'Address can\'t be more than 30 chars.';

        // check phone number 
        if(!preg_match('/^[0-9\/-]+$/', trim($phone)))
            $errors[] = 'Invalid phone number.';

        if (count($errors) == 0)
        {
            if ($userObject->updateUser($idFromForm,$username,$password,$email,$address,$phone,$type))
                $success = 'User Updated Successfully';
            else
                $error = 'Error Updating User';
        } else
            $_SESSION['errors'] = $errors;
        
    }

    include ('../templates/back/admin/header.html');
    include ('../templates/back/admin/menu.html');
    include ('../templates/back/admin/updateuser.html');
    include ('../templates/back/admin/footer.html');