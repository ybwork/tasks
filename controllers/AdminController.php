<?php

class AdminController
{
	/**
	 * Return not done tasks and main page for admin
	 *
	 * @return {array} $tasks - tasks which not done
	 */
	public function index()
	{
		if (isset($_SESSION['user'])) {
	        $tasks = [];
	        $tasks = Task::get_not_done();

	        if (count($tasks) == 0) {
				require_once(ROOT . '/views/admin/index.php');
	        	return true;
	        } 
	        
	        require_once(ROOT . '/views/admin/index.php');
			return $tasks;
        } else {
			header("Location: /admin/login");
        }
	}
}