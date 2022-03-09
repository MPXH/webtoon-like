<?php

namespace WebtoonLike\Api\Utils\Tree;

use JetBrains\PhpStorm\Pure;

class Node implements NodeInterface
{

    /**
     * @param NodeInterface|null $directAncestor
     * @param NodeInterface[] $directDescendants
     */
    public function __construct(
        private ?NodeInterface $directAncestor,
        private array          $directDescendants = []
    ) {}

    /**
     * @inheritDoc
     */
    public function getDescendants(): array
    {
        $arr = [];
        foreach ($this->directDescendants as $node) {
            $arr = array_merge_recursive($arr, [$node, ...$node->getDescendants()]);
        }
        return $arr;
    }

    /**
     * @inheritDoc
     */
    public function length(): int
    {
        $l = 1;
        foreach ($this->directDescendants as $node) {
            $l += $node->length();
        }
        return $l;
    }

    /**
     * @inheritDoc
     */
    public function isRoot(): bool
    {
        return $this->directAncestor === null;
    }

    /**
     * @inheritDoc
     */
    public function getDirectAncestor(): NodeInterface
    {
        return $this->directAncestor;
    }

    #[Pure] public function hasDescendants(): bool {
        return sizeof($this->getDirectDescendants()) > 0;
    }

    /**
     * @inheritDoc
     */
    public function isAncestorOf(NodeInterface $node): bool
    {
        return in_array($node, $this->getDescendants());
    }

    /**
     * @inheritDoc
     */
    public function isLeaf(): bool
    {
        return sizeof($this->directDescendants) === 0;
    }

    /**
     * @inheritDoc
     */
    public function appendDescendant(?array $descendants, mixed $data): ?NodeInterface
    {
        $node = new Node($this, $descendants);
        $this->directDescendants[] = $node;
        return $node;
    }

    /**
     * @inheritDoc
     */
    public function getDirectDescendants(): array
    {
        return $this->directDescendants;
    }

    /**
     * @inheritDoc
     */
    public function isDescendantOf(NodeInterface $node): bool
    {
        return in_array($node, $this->getAncestors());
    }

    /**
     * @inheritDoc
     */
    public function getAncestors(): array
    {
        return [...$this->directAncestor->getAncestors(), $this];
    }

    /**
     * @inheritDoc
     */
    public function getDirectDescendant(int $id): ?NodeInterface
    {
        if (isset($this->directDescendants[$id])) {
            return $this->directDescendants[$id];
        }
        return null;
    }
}