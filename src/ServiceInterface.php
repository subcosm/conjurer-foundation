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


interface ServiceInterface
{
    public function withConcrete($mixed): ServiceInterface;

    public function withConcreteClass(string $class): ServiceInterface;

    public function singleton(bool $flag = true): ServiceInterface;

    public function factory(callable $callback): ServiceInterface;

    public function withParameter(string $parameter, $value): ServiceInterface;

    public function withOptionalParameters(string ... $parameters): ServiceInterface;

    public function withMethodCall(string $method, array $parameters = []): ServiceInterface;

    public function withOptionalMethodCallParameters(string $method, string ... $parameters): ServiceInterface;

    public function variadic($parameter, ... $values): VariadicParameterInterface;

    public function marshalInstance(array $parameters = [], ConjurerServiceContainerInterface $container);
}