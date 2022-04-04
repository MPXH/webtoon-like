<?php

namespace WebtoonLike\Site\controller;

class WebtoonContoller extends AbstractController
{

    public function __construct()
    {
        parent::__construct('webtoons');
    }

    public function getAll(): array {

    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name): mixed
    {
        // TODO: Implement getByName() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $params): int|false
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, array $params): bool
    {
        // TODO: Implement edit() method.
    }
}