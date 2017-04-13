<?php
/**
 * This file is part of the subcosm.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Subcosm\Conjurer;


use Subcosm\Hive\DeclarationAwareInterface;
use Subcosm\Hive\HiveInterface;

interface ConjurerApplicationContainerInterface
    extends
        ConjurerServiceContainerInterface,
        HiveInterface,
        DeclarationAwareInterface
{
    /**
     * assigns one or more aliases to the provided interface. The aliased interface must not be known to the
     * container hierarchy.
     *
     * @param string $interface
     * @param \string[] ...$alias
     * @return ConjurerApplicationContainerInterface
     */
    public function alias(string $interface, string ... $alias): ConjurerApplicationContainerInterface;

    /**
     * assigns one or more aliases ot the provided interface when the scope settings are met. The aliased interface
     * must not be known to the container hierarchy.
     *
     * @param string $interface
     * @param array $scope
     * @param \string[] ...$alias
     * @return ConjurerApplicationContainerInterface
     */
    public function aliasOfScope(string $interface, array $scope, string ... $alias): ConjurerApplicationContainerInterface;

    /**
     * Checks whether the provided entity is known or not.
     *
     * @param string $entity
     * @param array $scope
     * @return bool
     */
    public function has($entity, array $scope = []);

    /**
     * sets the value of the provided entity.
     *
     * @param string $entity
     * @param $value
     * @param array $scope
     * @return mixed
     */
    public function set(string $entity, $value, array $scope = []): void;

    /**
     * ensures the provided entity path, creates not existing nodes when $createIfNotExists is set to true.
     *
     * @param string $entity
     * @param bool $createIfNotExists
     * @param array $scope
     * @return null|HiveInterface
     */
    public function node(string $entity, bool $createIfNotExists = false, array $scope = []): ? HiveInterface;

    /**
     * declares the validation for the provided entity when the scope settings are met.
     *
     * @param string $entity
     * @param callable $callback
     * @param array $scope
     * @return void
     */
    public function entity(string $entity, callable $callback, array $scope = []): void;

    /**
     * declares the validation for all entities, when no specific validation was set.
     *
     * @param callable $callback
     * @param array $scope
     */
    public function defaultEntity(callable $callback, array $scope = []): void;
}