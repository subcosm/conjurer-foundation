<?php
/**
 * This file is part of the subcosm.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Subcosm\Conjurer\Container;


use Subcosm\Conjurer\ConjurerApplicationContainerInterface;
use Subcosm\Conjurer\ConjurerServiceContainerInterface;
use Subcosm\Conjurer\EnvironmentComparatorInterface;
use Subcosm\Conjurer\ReflectionCacheInterface;
use Subcosm\Conjurer\ServiceInterface;
use Subcosm\Hive\Container\DeclarativeHiveNode;
use Subcosm\Hive\HiveIdentityInterface;
use Subcosm\Observatory\ObserverQueue;

class ApplicationServiceContainer extends DeclarativeHiveNode implements ConjurerApplicationContainerInterface
{
    /**
     * @var EnvironmentComparatorInterface
     */
    protected $comparator;

    /**
     * @var ServiceInterface[]
     */
    protected $services = [];

    /**
     * @var string[]
     */
    protected $aliases = [];

    /**
     * ApplicationServiceContainer constructor.
     * @param HiveIdentityInterface|null $parent
     * @param ObserverQueue $observers
     * @param EnvironmentComparatorInterface $comparator
     */
    public function __construct(
        HiveIdentityInterface $parent = null,
        ObserverQueue $observers = null,
        EnvironmentComparatorInterface $comparator = null
    ) {
        $this->comparator = $comparator;

        parent::__construct($parent, $observers);
    }


    /**
     * assigns one or more aliases to the provided interface. The aliased interface must not be known to the
     * container hierarchy.
     *
     * @param string $interface
     * @param \string[] ...$alias
     * @return ConjurerApplicationContainerInterface
     */
    public function alias(string $interface, string ... $alias): ConjurerApplicationContainerInterface
    {
        foreach ( $this->aliases as $current ) {
            $this->set($current, function() use ($interface) {
                return $this->make($interface);
            });
        }

        return $this;
    }

    /**
     * assigns one or more aliases ot the provided interface when the scope settings are met. The aliased interface
     * must not be known to the container hierarchy.
     *
     * @param string $interface
     * @param array $scope
     * @param \string[] ...$alias
     * @return ConjurerApplicationContainerInterface
     */
    public function aliasOfScope(string $interface, array $scope, string ... $alias): ConjurerApplicationContainerInterface
    {
        if ( $this->comparator->compareTo($scope, $this) ) {
            return $this->alias($interface, ... $alias);
        }
    }

    /**
     * orchestrates a service by the provided interface. When no scope settings are provided, the scope settings
     * default to the current execution environment. When scope settings are provided, the scopeCallback must be
     * used to initialize the service scope-sensitive. This method will return null when scope settings are provided.
     *
     * Not matching scope settings prevents a service being registered to the container.
     *
     * @param string $interface
     * @param array $scope
     * @param null|callable $scopeCallback
     * @return ServiceInterface|null
     */
    public function service(string $interface, array $scope = [], callable $scopeCallback = null): ? ServiceInterface
    {
        if ( $this->comparator->compareTo($scope, $this) ) {
            # ToDo: When eyes wide open, continue here.
        }
    }

    /**
     * detects whether a interface is known by the provided in the current runtime environment.
     *
     * @param string $interface
     * @return bool
     */
    public function supports(string $interface): bool
    {
        return array_key_exists($interface, $this->services);
    }

    /**
     * creates a instance of the provided interface name, regardless if the interface is known to the container or not.
     * Optionally provided parameters will replace assigned parameters of the service or auto-negotiated parameters
     * of the service.
     *
     * @param string $interface
     * @param array $parameters
     * @return mixed
     */
    public function make(string $interface, array $parameters = [])
    {
        // TODO: Implement make() method.
    }

    /**
     * calls the provided callback. Optionally provided parameters will replace auto-negotiated parameters for the
     * provided callback.
     *
     * @param callable $callback
     * @param array $parameters
     * @return mixed
     */
    public function call(callable $callback, array $parameters = [])
    {
        // TODO: Implement call() method.
    }

    /**
     * forks a container inheriting from the current parameter.
     *
     * @return ConjurerServiceContainerInterface
     */
    public function fork(): ConjurerServiceContainerInterface
    {
        // TODO: Implement fork() method.
    }

    /**
     * returns the reflection cache object.
     *
     * @return ReflectionCacheInterface
     */
    public function getReflectionCache(): ReflectionCacheInterface
    {
        // TODO: Implement getReflectionCache() method.
    }

}