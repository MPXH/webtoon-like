<?php

namespace WebtoonLike\Api\Utils\Tree;

interface NodeInterface
{

    /**
     * Retourne la taille de l'ensemble des enfants de la node
     * Inclut les enfants des enfants...
     *
     * @return int taille
     */
    public function length(): int;

    /**
     * Retourne vrai si le nœud est root.
     * C'est-à-dire s'il n'a pas de parent.
     *
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * Retourne si la node possède ou non des descendants
     * @return bool
     */
    public function hasDescendants(): bool;

    /**
     * Retourne le parent direct de ce nœud
     *
     * @return NodeInterface
     */
    public function getDirectAncestor(): NodeInterface;

    /**
     * Retourne l'ensemble des parents de ce nœud
     *
     * @return NodeInterface[]
     */
    public function getAncestors(): array;

    /**
     * Retourne vrai si ce nœud est parent de <code>$node</code>
     * @param NodeInterface $node Potentiel parent
     * @return bool
     */
    public function isAncestorOf(NodeInterface $node): bool;

    /**
     * Retourne vrai si le nœud est une feuille.
     * C'est-à-dire qu'il n'a pas d'enfants
     *
     * @return bool
     */
    public function isLeaf(): bool;

    /**
     * Ajoute un descendant direct à ce nœud et le retourne
     * Retourne <code>null</code> si le nœud existe déjà
     *
     * @param array|null $descendants Valeurs des potentiels descendants à inséré au nœud créé
     * @param mixed $data
     * @return NodeInterface|null
     */
    public function appendDescendant(?array $descendants, mixed $data): ?NodeInterface;

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

}