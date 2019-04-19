<?php

 class Bootstrap {
	private $controller = "Home";
	private $method = "index";

	public function __construct() {
		if (isset($_GET["url"])) $params = explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));

		if (isset($params[0])) {
			if (file_exists("app/controllers/$params[0].php")) {
				$this->controller = $params[0];
				unset($params[0]);
			}
		}

		require "app/controllers/$this->controller.php";
		$this->controller = new $this->controller;

		if (isset($params[1])) {
			if (method_exists($this->controller, $params[1])) {
				$this->method = $params[1];
				unset($params[1]);
			}
		}

		call_user_func_array(array($this->controller, $this->method), $params ? array_values($params) : array());
		unset($params);
	}
}

?>