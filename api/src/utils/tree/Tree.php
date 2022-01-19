<?php
namespace WebtoonLike\Api\Utils\Tree;

class Tree extends Node
{

    /**
     * @param string[] $path
     * @param string $value
     * @return bool
     */
    public function insert(array $path, string $value): bool {
        // TODO
    }

    /**
     * @param mixed $value
     * @param string[] | null $path
     * @return Node
     */
    public function search(mixed $value, ?array $path = null): Node {
        // TODO
    }

    /**
     * @param string $str
     * @return array [string, Node] where the string represent the path
     */
    public static function makeNodeFromString(string $str): array {
        // TODO
    }
}