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


interface ConjurerServiceContainerInterface
{
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
    public function service(string $interface, array $scope = [], callable $scopeCallback = null): ? ServiceInterface;

    /**
     * detects whether a interface is known by the provided in the current runtime environment.
     *
     * @param string $interface
     * @return bool
     */
    public function supports(string $interface): bool;

    /**
     * creates a instance of the provided interface name, regardless if the interface is known to the container or not.
     * Optionally provided parameters will replace assigned parameters of the service or auto-negotiated parameters
     * of the service.
     *
     * @param string $interface
     * @param array $parameters
     * @return mixed
     */
    public function make(string $interface, array $parameters = []);

    /**
     * calls the provided callback. Optionally provided parameters will replace auto-negotiated parameters for the
     * provided callback.
     *
     * @param callable $callback
     * @param array $parameters
     * @return mixed
     */
    public function call(callable $callback, array $parameters = []);

    /**
     * forks a container inheriting from the current parameter.
     *
     * @return ConjurerServiceContainerInterface
     */
    public function fork(): ConjurerServiceContainerInterface;

    /**
     * returns the reflection cache object.
     *
     * @return ReflectionCacheInterface
     */
    public function getReflectionCache(): ReflectionCacheInterface;
}
