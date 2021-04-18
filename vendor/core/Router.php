<?php


namespace vendor\core;


class Router
{
    public static $routes = [];

    public static $route = [];

    /**
     * @param $regexp
     * @param array $route
     */
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * @return array
     */
    public static function getRoute()
    {
        return self::$route;
    }

    /**
     * @param $url
     * @return bool
     */
    private static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route)
        {
            if (preg_match("#$pattern#i", $url, $matches))
            {
                foreach ($matches as $key => $value)
                {
                    if (is_string($key))
                    {
                        $route[$key] = $value;
                    }
                }

                if (!$route['action'])
                {
                    $route['action'] = 'index';
                }

                //Prefix for Admin part
                if (!isset($route['prefix']))
                {
                    $route['prefix'] = '';
                }else{
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                //debag($route);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $url
     */
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);

        if (self::matchRoute($url))
        {
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';

            if (class_exists($controller))
            {
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($cObj, $action))
                {
                    $cObj->$action();
                    $cObj->getView();
                }else{
                    echo "Метод <b>$controller::$action</b> не найден!";
                }
            }else{
                echo "Класс <b>$controller</b> не найден!";
            }
        }else{
            http_response_code(404);
            include '404.html';
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    private static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-' , ' ', $name)));
    }

    /**
     * @param $name
     * @return string
     */
    private static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * @param $url
     * @return string
     */
    private static function removeQueryString($url)
    {
        if ($url)
        {
            $params = explode('&', $url, 2);

            if (false === strpos($params[0], '='))
            {
                return trim($params[0], '/');
            }else{
                return '';
            }
        }
        return $url;
    }


}