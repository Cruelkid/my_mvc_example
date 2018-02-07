<?php

class App {

    protected $controller = 'default';
    protected $action = 'indexAction';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (file_exists('../app/controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . 'Controller.php';

        $resultController = $this->controller . 'Controller';
        $this->controller = new $resultController;

        if (isset($url[1])) {
            $this->action = $url[1] . 'Action';
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func([$this->controller, $this->action], $this->params);

    }

    protected function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL ));
        }
    }

}