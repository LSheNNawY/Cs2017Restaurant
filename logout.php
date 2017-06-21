<?php
	session_start();
	if ($_SESSION['user']['user_type']==1 || $_SESSION['user']['user_type']==2)
	{
	session_destroy();

	header('Location: admin/login.php');
    }
    elseif ($_SESSION['user']['user_type']==3)
    {
        session_destroy();

        header('location: signup.php');
    }