<?php

class Router {
    public function route() {
        $url = $_GET['url'] ?? 'home/index';
        $url = explode('/', trim($url, '/'));

        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        if (file_exists("../app/controllers/$controllerName.php")) {
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Metoda '$method' neexistuje.";
            }
        } else {
            echo "Kontroler '$controllerName' neexistuje.";
        }
    }
}
