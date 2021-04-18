<?php


namespace vendor\core\base;


class View
{
    public $route = [];

    public $layout;

    public $view;

    /**
     * View constructor.
     * @param $route
     * @param $layout
     * @param $view
     */
    public function __construct($route, $layout, $view)
    {
        $this->route = $route;

        if ($layout === false)
        {
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }

        $this->view = $view;
    }

    /**
     * @param $vars
     */
    public function render($vars)
    {
        if (is_array($vars)) extract($vars);

        $file_view = APP . "/views/{$this->route['controller']}/{$this->route['action']}.php";

        ob_start();

        if (is_file($file_view))
        {

            require $file_view;

        }else{

            echo "Файл вида <b>$file_view</b> не найден!";

        }

        $content = ob_get_clean();

        if (false !== $this->layout)
        {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";

            if (is_file($file_layout))
            {

                require $file_layout;

            }else{

                echo "Файл шаблона <b>$file_layout</b> не найден!";

            }
        }
    }
}