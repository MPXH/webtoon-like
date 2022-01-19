<?php
namespace WebtoonLike\Api\Utils\Tree;

use JetBrains\PhpStorm\Internal\TentativeType;
use JetBrains\PhpStorm\Pure;

class Node implements NodeInterface, \Iterator
{

    private int $iteratorNext = 0;

    /**
     * @param mixed $value
     * @param NodeInterface|null $directAncestor
     * @param NodeInterface[]|null $directDescendants
     */
    public function __construct(
        private mixed $value,
        private ?NodeInterface $directAncestor,
        private array $directDescendants = []
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

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function length(): int
    {
        $l = 1;
        foreach ($this->directDescendants as $node) {
            $l += $node->length();
        }
        return $l;
    }

    public function isRoot(): bool
    {
        return $this->directAncestor === null;
    }

    public function getDirectAncestor(): NodeInterface
    {
        return $this->directAncestor;
    }

    public function getAncestors(): array
    {
        return [...$this->directAncestor->getAncestors(), $this];
    }

    public function isAncestorOf(NodeInterface $node): bool
    {
        return in_array($node, $this->getDescendants());
    }

    public function isLeaf(): bool
    {
        return sizeof($this->directDescendants) === 0;
    }

    public function appendDescendant(mixed $value, ?array $descendants): NodeInterface
    {
        $node = new Node($value, $this, $descendants);
        $this->directDescendants[] = array_merge_recursive($this->directDescendants, $descendants);
        return $node;
    }

    public function getDirectDescendants(): array
    {
        return $this->directDescendants;
    }

    public function isDescendantOf(NodeInterface $node): bool
    {
        return in_array($node, $this->getAncestors());
    }

    public function getDescendants(): array
    {
        $arr = [];
        foreach ($this->directDescendants as $node) {
            $arr = array_merge_recursive($arr, [$node, ...$node->getDescendants()]);
        }
        return $arr;
    }

    public function __toArray(): array
    {
        return [$this->value => $this->directDescendants];
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return '';
    }

    public function getDirectDescendant(int $id): ?NodeInterface
    {
        if (isset($this->directDescendants[$id])) {
            return $this->directDescendants[$id];
        }
        return null;
    }
}