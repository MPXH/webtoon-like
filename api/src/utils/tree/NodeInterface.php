<?php

namespace WebtoonLike\Api\Utils\Tree;

interface NodeInterface
{

    /**
     * Change la valeur du noeud
     *
     * @param mixed $value nouvelle valeur
     * @return void
     */
    public function setValue(mixed $value): void;

    /**
     * Retourne la valeur du noeud
     *
     * @return mixed valeur
     */
    public function getValue(): mixed;

    /**
     * Retourne la taille de l'ensemble des enfants de la node
     * Inclut les enfants des enfants...
     *
     * @return int taille
     */
    public function length(): int;

    /**
     * Retourne vrai si le noeud est root.
     * C'est à dire s'il n'a pas de parent.
     *
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * Retourne le parent direct de ce noeud
     *
     * @return NodeInterface
     */
    public function getDirectAncestor(): NodeInterface;

    /**
     * Retourne l'ensemble des parents de ce noeud
     *
     * @return NodeInterface[]
     */
    public function getAncestors(): array;

    /**
     * Retourne vrai si ce noeud est parent de <code>$node</code>
     * @param NodeInterface $node potentiel parent
     * @return bool
     */
    public function isAncestorOf(NodeInterface $node): bool;

    /**
     * Retourne vrai si le noeud est une feuille.
     * C'est à dire qu'il n'a pas d'enfants
     *
     * @return bool
     */
    public function isLeaf(): bool;

    /**
     * Ajoute un descendant directe à ce noeud et le retourne
     * Retourne <code>null</code> si le noeud existe déjà
     *
     * @param mixed $value valeur du noeud à inséré
     * @param array|null $descendants valeurs des potentiels descendants à inséré au noeud créé
     * @return NodeInterface|null
     */
    public function appendDescendant(mixed $value, ?array $descendants): ?NodeInterface;

    /**
     * Obtenir le descendant direct numéro <code>$id</code>
     * Renvoie <code>null</code> si le noeud n'existe pas
     *
     * @param int $id
     * @return NodeInterface|null
     */
    public function getDirectDescendant(int $id): ?NodeInterface;

    /**
     * Retourne l'ensemble des descendants directs
     *
     * @return NodeInterface[]
     */
    public function getDirectDescendants(): array;

    /**
     * Retourne l'ensemble des descendants
     * Comprend les descendants de descendants
     *
     * @return NodeInterface[]
     */
    public function getDescendants(): array;

    /**
     * @param NodeInterface $node
     * @return bool
     */
    public function isDescendantOf(NodeInterface $node): bool;

    /**
     * Retourne un tableau représentant l'arbre
     * Le tableau contient les valeurs de l'arbre
     *
     * @return array
     */
    public function __toArray(): array;

    /**
     * Ajoute un descendant à partir d'un tableau des parent et de celui-ci
     *
     * @param array $values
     * @return void
     */
    public function appendDescendantFromArray(array $values): void;

}