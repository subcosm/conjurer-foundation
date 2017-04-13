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


interface ReflectionCacheInterface
{
    /**
     * reflects the parameters of a callable.
     *
     * @param callable $callback
     * @return array
     */
    public function reflectCallable(callable $callback): array;

    /**
     * reflects the parameters of the provided class
     *
     * @param string $class
     * @return array
     */
    public function reflectClassConstructor(string $class): array;

    /**
     * reflects the parameters of the provided class method.
     *
     * @param string $class
     * @param string $method
     * @return array
     */
    public function reflectClassMethod(string $class, string $method): array;
}