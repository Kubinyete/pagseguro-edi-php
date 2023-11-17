<?php

namespace Kubinyete\Edi\PagSeguro\Util;

abstract class ClassUtil
{
    public static function basename(string $class): string
    {
        return basename(str_replace('\\', '/', $class));
    }
}
