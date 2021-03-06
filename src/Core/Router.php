<?php
declare(strict_types=1);

namespace App\Core;

use App\Core\Exception\AuthorizationException;
use App\Core\Exception\NotFoundException;
use App\Controller\DefaultController;

/**
 * Class Router
 * @package App\Core
 */
class Router
{
    private array $routes;

    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    public function get(string $path, string $controller, string $action,
                        array $parameters = [], string $name = "",
                        string $role = 'ROLE_ANONYMOUS'): void
    {

        $this->routes["GET"][$path] = ["controller" => $controller,
            "action" => $action, "parameters" => $parameters,
            "name" => $name, "role"=>$role];
    }


    public function post(string $path, string $controller, string $action,
                        array $parameters = [], string $name = "",
                        string $role = 'ROLE_ANONYMOUS'): void
    {

        $this->routes["POST"][$path] = ["controller" => $controller,
            "action" => $action, "parameters" => $parameters,
            "name" => $name, "role"=>$role];
    }


    public function route(string $url, string $method): string
    {
        // ruta sol·licitada per l'usuari
        // /movies/17/show
        $requestedUrl = $url;

        foreach ($this->routes[$method] as $route => $data) {
            // movies/\d+/show
            $regexRoute = $this->getRegexRoute($route, $data);
            if (preg_match("@^$regexRoute$@", $requestedUrl)) {
                $role = $data['role'];
                    if (!Security::isUserGranted($role))
                        throw new AuthorizationException('You do not have access permissions');


                //$class = "\\App\\Controller\\" . $data["controller"];
                //$class = $data["controller"];

                $class = "\\App\\Controller\\" . $data["controller"];

                $instance = new $class;
                $action = $data["action"];
                $parameters = $this->extractParameters($requestedUrl, $route);
                return call_user_func_array([$instance, $action], $parameters);
            }

        }
        //route és la ruta de la taula de rutes.
        // /movies/:id/show
        throw new NotFoundException("The path doesn't exist");
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     * @throws NotFoundException
     */
    public function getUrl(string $name, array $parameters = []): string
    {
        foreach (["GET", "POST"] as $method) {
            foreach ($this->routes[$method] as $route => $data) {
                if (key_exists("name", $data))
                    // si la ruta té el nom indicat, la generem
                    if ($data["name"] === $name) {
                        $url = $route;
                        $query = [];
                        foreach ($parameters as $name => $value) {
                            // si és un paràmetre de la ruta el substituïm
                            // si no el passarem pel query string
                            if (strpos($route, ":$name") !== false)
                                $url = str_replace(":$name", (string)$value, $url);
                            else
                                $query[$name] = $value;
                        }

                        $querystring = "";

                        if (!empty($query))
                            $querystring = "?" . implode("&", array_map(function ($k, $v) {
                                    return "$k=$v";
                                },
                                    array_keys($query), $query));
                        return "/" . $url . $querystring;
                    }
            }
        }

        throw new NotFoundException("Route name ($name) doens't exists");

    }

    /**
     * @param string $route
     * @param array $data
     * @return string
     */
    private function getRegexRoute(string $route, array $data): string
    {
        // "movies/:id/show"=>["parameters"=>["id"=>"number"];
        if (!empty($data["parameters"])) {
            foreach ($data["parameters"] as $name => $type) {
                $route = str_replace(":$name", "\d+", $route);
            }
        }
        return $route;
    }

    private function extractParameters(string $requestedUrl, $route): array
    {
        $parameters = [];
        // movies/17/show
        // 0 - movies
        // 1 - 17
        // 2 - show
        $urlParts = explode("/", $requestedUrl);

        // movies/:id/show
        // 0 - movies
        // 1 - :id
        // 2 - show
        $routeParts = explode("/", $route);

        foreach ($routeParts as $key => $routePart) {
            if (strpos($routePart, ":") !== false) {
                $parameters[trim($routePart, ":")] = (int)$urlParts[$key];
            }
        }
        return $parameters;
    }

    /**
     * @param string $url
     */

    public function redirect(string $url)
    {
        header("Location: /$url");
        exit();
    }

    /**
     * @param string $url
     */

    public function redirectByName(string $name, array $params=[])
    {
        /*$path = "";
        foreach (["GET", "POST"] as $method) {
            foreach ($this->routes[$method] as $route => $data) {
                if ($name === $data["name"]) {
                    $path = $route;
                }
            }
        }
        if (strlen($path) !== 0)*/
        $url = $this->getUrl($name, $params);
        //$this->redirect($url);
        // TODO: Resolve why the slash isn't necessary
        header("Location: $url");
        exit();
    }
}