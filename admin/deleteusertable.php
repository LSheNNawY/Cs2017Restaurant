<?php

	require ('../globals.php');
	require ('../includes/users.class.php');
	require ('../includes/tables.class.php');
	require ('../includes/users_tables.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

	if (count($_POST) > 0)
	{
		// user id comes with ajax
        $user_id = $_POST['user_id'];
        // table id comes with ajax
        $table_id = $_POST['table_id'];

        // success and failure varables
        $success = '';
        $error = '';
        // collect result variables in array
        $resultArr = array();
        // deleting table reservation
        $tableResObj = new UsersTables();
        $deleteReservation = $tableResObj->removeReservation($user_id, $table_id);

		if($deleteReservation)
		    $success = 'Reservation deleted successfully';
		else 
		 	$error = 'Error deleting reservation';

		// adding success and error variables to result array
        $resultArr['success'] = $success;
        $resultArr['error'] = $error;
        // encoding result array as json to use with ajax
        echo json_encode($resultArr);
	}
