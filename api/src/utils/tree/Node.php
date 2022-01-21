<?php

namespace WebtoonLike\Api\Utils\Tree;

use Iterator;

class Node implements NodeInterface, Iterator
{

    private int $iteratorNext = 0;

    /**
     * @param mixed $value
     * @param NodeInterface|null $directAncestor
     * @param NodeInterface[]|null $directDescendants
     */
    public function __construct(
        private mixed          $value,
        private ?NodeInterface $directAncestor,
        private array          $directDescendants = []
    ) {}

    /**
     * @inheritDoc
     */
    public function current(): NodeInterface
    {
        return $this->getDescendants()[$this->iteratorNext];
    }

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
    public function next(): void
    {
        $this->iteratorNext++;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->iteratorNext;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return isset($this->getDescendants()[$this->iteratorNext]);
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->iteratorNext = 0;
    }

    /**
     * @inheritDoc
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
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
    public function appendDescendantFromArray(array $values): void
    {
        if ($values[0] !== $this->value && !isset($values[1])) return;
        foreach ($this->directDescendants as $descendant) {
            if ($values[1] === $descendant->getValue()) {
                $descendant->appendDescendantFromArray(array_slice($values, 1));
                return;
            }
        }
        $this->appendDescendant($values[1], array_slice($values, 1));
    }

    /**
     * @inheritDoc
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function appendDescendant(mixed $value, ?array $descendants): ?NodeInterface
    {
        foreach ($this->directDescendants as $descendant) {
            if ($descendant->getValue() === $value) return null;
        }
        $node = new Node($value, $this, $descendants);
        $this->directDescendants[] = array_merge_recursive($this->directDescendants, $descendants);
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
    public function __toArray(): array
    {
        return [$this->value => $this->directDescendants];
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