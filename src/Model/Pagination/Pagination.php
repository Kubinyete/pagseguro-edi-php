<?php

namespace Kubinyete\Edi\PagSeguro\Model\Pagination;

use DateTimeInterface;
use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;

class Pagination extends Model
{
    protected function schema(SchemaBuilder $schema)
    {
        $schema->int("elements");
        $schema->int("totalPages");
        $schema->int("page");
        $schema->int("totalElements");
    }

    public function getElements(): int
    {
        return $this->get('elements');
    }

    public function getTotalPages(): int
    {
        return $this->get('totalPages');
    }

    public function getPage(): int
    {
        return $this->get('page');
    }

    public function getTotalElements(): int
    {
        return $this->get('totalElements');
    }
}
