<?php

namespace WebtoonLike\Api\Core\Dispatcher;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Transforme un middleware PSR7 (callable) en PSR15 (implémentation de \Psr\Http\Server\MiddlewareInterface)
 */
class CallableMiddleware implements \Psr\Http\Server\MiddlewareInterface
{

    /** @var callable le middleware PSR7 */
    private $callable;

    /**
     * Crée un middleware PSR15
     * @param callable $callable le middleware PSR7
     */
    public function __construct(callable $callable) {
        $this->callable = $callable;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return call_user_func($this->callable, $request, $handler);
    }
}