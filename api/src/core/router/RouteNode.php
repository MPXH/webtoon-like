<?php

namespace WebtoonLike\Api\Core\Router;

use Method;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WebtoonLike\Api\Utils\Tree\Node;
use WebtoonLike\Api\Utils\Tree\NodeInterface;

class RouteNode extends Node implements MiddlewareInterface
{

    private string $path;
    private ?Method $method;
    private bool $dynamic;

    /**
     * @param string $path Le path de la route à créer
     * @param Method|null $method La méthode de la route
     * @param string|null $dynamicPattern Si le path contient un attribut dynamic (:nom), définit le pattern à appliquer
     * @param NodeInterface|null $directAncestor Le prédécesseur direct
     * @param array $directDescendants Les descendants directs
     */
    public function __construct(string $path, ?Method $method, ?string $dynamicPattern, ?NodeInterface $directAncestor, array $directDescendants = [])
    {
        parent::__construct($directAncestor, $directDescendants);
        $this->dynamic = str_contains($path, ':');
        if ($this->dynamic && !isset($dynamicPattern)) {
            throw new \Error("A pattern must be given if the path contain a dynamic part.");
        }
        $this->method = $method;
        $this->path = $path;
    }

    /**
     * To overwrite in each route with the logic
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }

    /**
     * Ajoute la route avec le chemin absolue
     *
     * Pour définir une route dynamique, utiliser la syntaxe /url/:nom
     *
     * @param string $path Le chemin absolu de la route
     * @param Method|null $method LA méthode HTTP à utiliser
     * @param string|null $pattern Le pattern si la route est dynamique
     * @return RouteNode|null
     */
    public function appendRoute(string $path, ?Method $method, ?string $pattern): ?RouteNode {
        $pathArr = mb_split('/', $path);
        if ($pathArr[0] === '') {
            array_shift($pathArr);
        }
        return $this->recursiveRouteInsertion($pathArr, $method, $pattern);
    }

    /**
     * Ajoute une route de manière recursive
     *
     * @param array $path
     * @param Method|null $method
     * @param string|null $pattern
     * @return RouteNode|null
     */
    private function recursiveRouteInsertion(array $path, ?Method $method, ?string $pattern): ?RouteNode {
        if (sizeof($path) === 1) {
            return $this->appendDescendant(null, [
                'path' => $path,
                'method' => $method,
                'dynamicPattern' => $pattern
            ]);
        }
        $current = array_shift($path);
        foreach ($this->getDescendants() as $descendant) {
            if ($descendant->getPath() === $current && $descendant->getMethod() === null) {
                return $descendant->recursiveRouteInsertion($path, $method, $pattern);
            }
        }
        $pre = $this->appendDescendant(null, [
            'path' => $current,
            'method' => null,
            'dynamicPattern' => null
        ]);
        return $pre->recursiveRouteInsertion($path, $method, $pattern);
    }

    /**
     * Ajoute un descendant direct à ce nœud et le retourne
     * Retourne null si le nœud existe déjà
     * @param array|null $descendants La liste des enfants de cette route
     * @param array-key $data Les données de la route
     * @return NodeInterface|null
     *
     * Le paramètre <code>$data</code> doit contenir :
     * - path → string
     * - method → Method
     * - dynamicPattern → string (regex pattern)
     */
    public function appendDescendant(?array $descendants, mixed $data): ?NodeInterface
    {
        $node = new RouteNode($data['path'], $data['method'], $data['dynamicPattern'], $this, $descendants);
        $this->directDescendants[] = $node;
        return $node;
    }

    /**
     * Permet de traiter une requête
     *
     * @param string[] $uri Représentation de l'Uri à traiter sous forme de tableau e.g. ['webtoons', '5']
     * @param Method $method
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface|null
     */
    public function resolveTree(
        array $uri, Method $method,
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface | null {
        if (sizeof($uri) === 0 && $method === $this->method) {
            return $this->process($request, $handler);
        }
        $curent = array_shift($uri);
        foreach ($this->getDirectDescendants() as $descendant) {
            if ($descendant->getPath() === $curent) {
                $res = $descendant->resolveTree($uri, $method, $request, $handler);
                if ($res !== null) return $res;
            }
        }
        return null;
    }
}