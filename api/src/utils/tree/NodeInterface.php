<?php

namespace WebtoonLike\Api\Utils\Tree;

interface NodeInterface
{

    public function setValue(mixed $value): void;

    public function getValue(): mixed;

    public function length(): int;

    public function isRoot(): bool;

    public function getDirectAncestor(): NodeInterface;

    public function getAncestors(): array;

    public function isAncestorOf(NodeInterface $node) : bool;

    public function isLeaf(): bool;

    public function appendDescendant(mixed $value, ?array $descendants): NodeInterface;

    public function getDirectDescendant(int $id): ?NodeInterface;

    public function getDirectDescendants(): array;

    public function getDescendants(): array;

    public function isDescendantOf(NodeInterface $node): bool;

    public function __toArray(): array;

    public function __toString(): string;

}