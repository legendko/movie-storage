<?php

class Router
{
	public static function start() {
		
		$routes = require 'routes.php';

		$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

		if(array_key_exists($uri, $routes)) {

		    $route = explode(':', $routes[$uri]);

		    $controller = "Controllers\\{$route[0]}";

		    $method = $route[1];

		    $controller = new $controller;

		    if (! method_exists($controller, $method)) {
		        throw new Exception("No such method {$method} for controller {$controller}");
		    }

		    return $controller->$method();
		}

		throw new Exception('No route defined for this URI.');
	}
}