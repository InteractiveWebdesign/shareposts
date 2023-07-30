<?php

/*
* App Core Class
* Creates URL & Loads core controller
* URL format - /controller/method/params
*/

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Check if the URL array is not empty before accessing its elements
        if (!empty($url)) {
            // Look in the controller for the first value
            $controllerName = ucwords($url[0]);

            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                // If the controller file exists, set it as the current controller
                $this->currentController = $controllerName;
                unset($url[0]);
            }
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for the second part of the URL
        if (isset($url[1])) {
        
        // Check to see if the method exists in the controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // unset 1 index 
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : []; 

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}

