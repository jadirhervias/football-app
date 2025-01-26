<?php

namespace Src\Shared\Domain;

abstract class AggregateRoot
{
    abstract function toPrimitives(): array;
}
