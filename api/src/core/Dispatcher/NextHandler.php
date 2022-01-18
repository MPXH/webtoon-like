<?php

namespace WebtoonLike\Api\Core\MiddlewareManagement;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Sert de handler temporaire pour le traitement des middlewares
 */
class NextHandler implements RequestHandlerInterface {

    /**
     * @param callable $callback Middleware
     */
    public function __construct(
        protected $callback
    ) {}

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func($this->callback, $request);
    }
}