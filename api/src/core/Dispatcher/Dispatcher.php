<?php

namespace WebtoonLike\Api\Core\Dispatcher;

use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;
use WebtoonLike\Api\Core\Router\AbstractRoute;
use WebtoonLike\Api\Core\Router\Method;
use WebtoonLike\Api\Core\Router\Router;

/**
 * Cette classe permet de gérer les middlewares traitant une requête.
 * Elle sert aussi d'interface au Router.
 */
class Dispatcher implements RequestHandlerInterface {

    /** @var SplQueue File des middlewares */
    private SplQueue $middlewares;

    /** @var Router Instance du router */
    private Router $router;

    /**
     * Retourne une nouvelle instance du Dispatcher.
     */
    public function __construct() {
        $this->middlewares = new SplQueue();
        $this->router = Router::getRouter();
        $this->middlewares->enqueue($this->router);
    }

    /**
     * Gères les requêtes et retourne la réponse
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->getNextHandler()->handle($request);
    }

    /**
     * Obtient le prochain gestionnaire de requête qui englobe la prochaine requête à traité dans la file
     * @return RequestHandlerInterface
     */
    protected function getNextHandler(): RequestHandlerInterface
    {
        return new NextHandler(function ($request) {
            if ($this->middlewares->isEmpty()) {
                // throw new Exception('The queue was exhausted, with no response returned');
                $this->pushMiddleware(function ($request) { return new Response(); });
            }
            $middleware = $this->middlewares->dequeue();
            $response = $middleware->process($request, $this->getNextHandler());
            if (!$response instanceof ResponseInterface) {
                throw new Exception(sprintf('Unexpected middleware result: %s', gettype($response)));
            }

            return $response;
        });
    }

    /**
     * Ajoute un middleware à la file
     * Le middleware à ajouter doit respecter soit le PSR7, soit le PSR15
     *
     * @param MiddlewareInterface|callable $middleware Le middleware à ajouter
     * @return void
     */
    public function pushMiddleware(MiddlewareInterface|callable $middleware): void
    {
        if (is_callable($middleware)) {
            $middleware = new CallableMiddleware($middleware);
        }
        $this->middlewares->enqueue($middleware);
    }

    /**
     * Ajoute une route au routeur
     *
     * @param string $path Le chemin de la route
     * @param Method $method La méthode HTTP
     * @param string $dynamicPattern Le paterne pour les routes dynamiques
     * @param MiddlewareInterface $handler Celui qui gère la requête
     * @return void
     */
    public function pushRoute(string $path, Method $method, string $dynamicPattern, MiddlewareInterface $handler): void {
        $this->router->register($path, $method, $dynamicPattern, $handler);
    }
}