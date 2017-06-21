<?php
	require ('../globals.php');
	require ('../includes/users.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

	//$id = isset($_GET['id'])? (int)$_GET['id'] : 0;
	if (count($_POST) > 0)
	{
		$user_id = $_POST['user_id'];
		// success and failure varables
        $success = '';
        $error = '';
        // collect result variables in array
        $resultArr = array();
        // deleting user by id
		$userObject = new Users();
		$user = $userObject->deleteUser($user_id);
		// check if user delete
		if($user)
		    $success = 'User deleted successfully';
		else
		    $error = 'Error deleting user';

		// adding success and error variables to result array
        $resultArr['success'] = $success;
        $resultArr['error'] = $error;
        // encoding result array as json to use with ajax
        echo json_encode($resultArr);
	}