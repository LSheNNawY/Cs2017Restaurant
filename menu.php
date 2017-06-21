<?php
	require ('globals.php');
	require ('includes/categories.class.php');
	require ('includes/meals.class.php');

	$active = 'menu';

	$catObject  = new Meals_categories();
	$mealObj	= new Meals();

	// get categories
	$categories = $catObject->getMealsCategories();

	// check if user selected a specific category
	$cat = (isset($_GET['cat']))? (int)$_GET['cat'] : 0;

	if ($cat == 0)
		$meals = $mealObj->getMeals();
	else 
		$meals 	= $mealObj->getMealsByCategoryId($cat);


	include ('templates/front/header.html');
	include ('templates/front/menu.html');
	include ('templates/front/footer.html');