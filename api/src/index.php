<?php
namespace WebtoonLike\Api;

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use WebtoonLike\Api\Core\MiddlewareManagement\Dispatcher;
use function Http\Response\send;

// TODO @gabey, @yacine, @hamza in ./api/composer.json: Ajouter mails / vérifier noms

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$dispatcher = new Dispatcher();

// $dispatcher->pushMiddleware();

send($dispatcher->handle(ServerRequest::fromGlobals()));