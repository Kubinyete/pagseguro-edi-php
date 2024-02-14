<?php

namespace Kubinyete\Edi\PagSeguro\Model\Pagination;

use DateTimeInterface;
use Kubinyete\Edi\PagSeguro\Model\Model;
use Kubinyete\Edi\PagSeguro\Model\Schema\SchemaBuilder;

class Page extends Model
{
    protected function schema(SchemaBuilder $schema)
    {
        $schema->any("detalhes")->array();
        $schema->has("pagination", Pagination::class);
    }

    public function getDetails(): array
    {
        return $this->get('detalhes');
    }

    public function getPagination(): Pagination
    {
        return $this->get('pagination');
    }
}
