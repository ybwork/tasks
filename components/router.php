<?php

class Router 
{
	private $routes;

	/**
	 * Set connection with routes
	 *
	 */
	public function __construct()
	{
		$routes_path = ROOT. '/routes/routes.php';
		$this->routes = include($routes_path);
	}

	/**
	 * Return processed current url
	 *
	 * @return {string} processed current url
	 */
	private function get_url()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			// 3 параметр - возвращаемый массив будет содержать максимум limit элементов
            $get_params = explode('?', $_SERVER['REQUEST_URI'], 2);
            return trim($get_params[0], '/');
		}
	}

	/**
	 * Start processing work with routes 
	 *
	 */
	public function run()
	{	
		$uri = $this->get_url();

		// For compare the query string with routes
		foreach ($this->routes as $uri_pattern => $path) {
			// Выполняет проверку на соответствие регулярному выражению
			if (preg_match("~$uri_pattern~", $uri)) {
				$query_string = preg_replace("~$uri_pattern~", $path, $uri);

				$handlers = explode('/', $query_string);

				$controller_name = ucfirst(array_shift($handlers) . 'Controller');

				$method_name = array_shift($handlers);
				
				$params = $handlers;

				$controller_file = ROOT . '/controllers/' . $controller_name . '.php';

				if (file_exists($controller_file)) {
					include_once($controller_file);
				}

				$controller_object = new $controller_name;

				try {
					// For pass to the method values which are represented as variables
					$result = call_user_func_array(
						array(
							$controller_object,
							$method_name
						), 
						$params
					);

					if ($result == null) {
						throw new Exception('Sorry, page not found!');
					}	
				} catch (Exception $e) {
					echo $e->getMessage();
				}

				break;
			}
		} 
	}
}