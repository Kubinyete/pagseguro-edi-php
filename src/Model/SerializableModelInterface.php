<?php

namespace Kubinyete\Edi\PagSeguro\Model;

use JsonSerializable;

interface SerializableModelInterface extends JsonSerializable
{
    static function tryParse(array $data): ?self;
    static function parse(array $data): self;
    function jsonSerialize(): array;
}
