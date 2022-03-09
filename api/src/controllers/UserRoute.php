<?php

namespace WebtoonLike\Api\Controllers;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserRoute extends \WebtoonLike\Api\Core\Router\AbstractRoute
{
    protected readonly string $basePath;

    #[Pure] public function __construct()
    {
        parent::__construct();
        $this->basePath = 'users';
    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write('USR:GET_ALL');
        return $response;
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement getOne() method.
        $response->getBody()->write('USR:GET_ONE');
        return $response;
    }

    public function postOne(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement postOne() method.
        $response->getBody()->write('USR:POST_ONE');
        return $response;
    }

    public function postMany(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement postMany() method.
        $response->getBody()->write('USR:POST_MANY');
        return $response;
    }

    public function putOne(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement putOne() method.
        $response->getBody()->write('USR:PUT_ONE');
        return $response;
    }

    public function putMany(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement putMany() method.
        $response->getBody()->write('USR:PUT_MANY');
        return $response;
    }

    public function deleteOne(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement deleteOne() method.
        $response->getBody()->write('USR:DELETE_ONE');
        return $response;
    }

    public function deleteMany(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement deleteMany() method.
        $response->getBody()->write('USR:DELETE_MANY');
        return $response;
    }
}