<?php

namespace WebtoonLike\Api\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use WebtoonLike\Api\Core\Router\AbstractRouteController;

class testRouterController extends AbstractRouteController
{

    public function getAll(): ResponseInterface
    {
        $this->response->getBody()->write(json_encode("get all"));
        return $this->response;
    }

    public function get(int $id): ResponseInterface
    {
        $this->response->getBody()->write(json_encode("get"));
        return $this->response;
    }

    public function create(RequestInterface $request): ResponseInterface
    {
        $this->response->getBody()->write(json_encode("create"));
        return $this->response;
    }

    public function update(RequestInterface $request): ResponseInterface
    {
        $this->response->getBody()->write(json_encode("update"));
        return $this->response;
    }

    public function delete(int $id): ResponseInterface
    {
        $this->response->getBody()->write(json_encode("delete"));
        return $this->response;
    }
}