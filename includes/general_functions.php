<?php 
	/**
	 * check login function
	 * return boolean
	 */
	function checkLogin() 
	{
		return (isset($_SESSION['user'])) ? true : false;
	}

	/**
	 * check admin login
	 * @return boolean
	 */
	function checkAdminLogin()
	{
		$user_type = (isset($_SESSION['user']['user_type']))? $_SESSION['user']['user_type'] : null;
		if ($user_type != null && ($user_type == 1 || $user_type == 2))
			return true;
		return false;
	}


	/**
	 * a function to hash psswords
	 * @param   $password 
	 * @return  string password          
	 */
	function hashPassword($password)
	{
		return sha1('prefix_'.md5($password).'ReStauRanT_ProJ');
	}


	/**
	 * create random and more unique id
	 * @return integer
	 */
	function createUniqueRandomID()
	{
		return (int)(rand(99, 999999).date('U'));
	}

	/**
	 * mysql escape string function for sql injection
	 */
	function msql_escape_string (array $inputs, $connection)
		{
			$escaped_inputs = [];

			foreach ($inputs as $key => $value) 
			{
				$input = $connection->escape_string($value);
				$escaped_inputs[$key] = $value;
			}
			
			return $escaped_inputs;
		}
