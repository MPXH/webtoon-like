<?php

namespace WebtoonLike\Api\Core\Router;

use Method;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WebtoonLike\Api\Utils\RegexUtils;

class Router implements MiddlewareInterface {

    /** @var RouteNode Racine de l'arbre */
    private RouteNode $routes;

    /** @var Router l'instance du routeur */
    private static Router $router;

    private function __construct()
    {
        $this->routes = new RouteNode('', null, null, null, []);
        self::$router = $this;
    }

    /**
     * Obtenir l'instance du routeur
     */
    public static function getRouter(): Router
    {
        if (isset(self::$router)) {
            return self::$router;
        }
        self::$router = new Router();
        return self::$router;
    }

    /**
     * Traite la requête et utilise la route appropriée
     * En cas de route inexistante, retourne une page 404
     *
     * @param ServerRequestInterface $request La requête
     * @param RequestHandlerInterface $handler Le gestionnaire de requête
     * @return ResponseInterface La réponse associée à la requête
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $uri = RegexUtils::clearUrl($request->getUri()->getPath());
            $method = $this->getMethod($request->getMethod());
            return $this->route($uri, $method, $request, $handler);
        } catch (\Exception $e) {
            $response = $handler->handle($request);
            $response->withStatus(404, 'Not Found');
            return $response;
        }
    }

    /**
     * Enregistre une nouvelle route
     *
     * @param string $path Chemin absolu de la route
     * @param Method $method Méthode HTTP
     * @param string $dynamicPattern Si la route est dynamique, quel est la regex validant le pattern
     * @return void
     */
    public function register(string $path, Method $method, string $dynamicPattern): void {
        // TODO: Verify if the paths are unique
        $this->routes->appendRoute($path, $method, $dynamicPattern);
    }

    /**
     * Effectue le routage
     * 
     * @param string $uri Le chemin
     * @param Method $method La méthode (GET, POST, PUT, DELETE, OPTIONS)
     * @throws \Exception En cas de route non trouvé
     */
    private function route(string $uri, Method $method, ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $res = $this->routes->resolveTree(mb_split('/', $uri), $method, $request, $handler);
        if ($res) return $res;

        throw new \Exception('404: Not Found');
    }

    /**
     * Renvoie l'ensemble des données fourni par POST à partir de la requête
     *
     * @param $request
     * @return array
     */
    public static function getPostParams($request): array {
        // TODO: To implement.
        return [];
    }

    /**
     * Retourne l'ensemble des paramètres fournis par GET à partir de la requête
     * @param $request
     * @return array
     */
    public static function getQueryParams($request): array {
        // TODO: To implement;
        return [];
    }

    private function getMethod(string $method): Method
    {
        return match ($method) {
            'GET' => Method::GET,
            'POST' => Method::POST,
            'PUT' => Method::PUT,
            'DELETE' => Method::DELETE,
            'OPTIONS' => Method::OPTIONS,
        };
    }
}