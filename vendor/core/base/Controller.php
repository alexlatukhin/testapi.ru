<?php


namespace vendor\core\base;


abstract class Controller
{
    public $route = [];

    public $layout;

    public $view;

    public $vars = [];

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    /**
     *
     */
    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    /**
     * @param $vars
     */
    public function set($vars)
    {
        $this->vars = $vars;
    }
}