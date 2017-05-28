<?php

class AuthController
{
	/**
	 * Login user in app
	 *
	 */
	public function login()
	{
		$errors = [];

    	if (isset($_POST['submit'])) {

	        $login = $_POST['login'];
	        $password = $_POST['password'];

	        if (!$login) {
	            $errors[] = 'Field login cannot be empty';
	        } 

	        if (!$password) {
	            $errors[] = 'Field password cannot be empty';
	        } 

	        if ($login && $password) {        	
		        $user = Auth::check_user($login, $password);

		    	if (!$user) {
		            $errors[] = 'Not correct login or password';
		        } else {
		            $_SESSION['user'] = $user;
		            $_SESSION['success'] = "Authorization successful";

		            header("Location: /admin");
		        }
	        }
    	}
        
        require_once(ROOT . '/views/auth/login.php');
        return true;
	}

	/**
	 * Delete user from session
	 *
	 */
    public function logout() {
        unset($_SESSION["user"]);
		header("Location: /admin/login");
    }
}