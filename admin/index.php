<?php
	require ('../globals.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
	{
		header('Location: login.php');
		exit;
	}

    include ('../templates/back/admin/header.html');
    include ('../templates/back/admin/menu.html');
    include ('../templates/back/admin/index.html');
    include ('../templates/back/admin/footer.html');
