<?php

declare(strict_types=1);

namespace Flow\ETL\Adapter\Elasticsearch\EntryIdFactory;

use Flow\ETL\Adapter\Elasticsearch\IdFactory;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry;

/**
 * @psalm-immutable
 */
final class EntryIdFactory implements IdFactory
{
    public function __construct(private string $entryName)
    {
    }

    /**
     * @return array{entry_name: string}
     */
    public function __serialize() : array
    {
        return [
            'entry_name' => $this->entryName,
        ];
    }

    /**
     * @param array{entry_name: string} $data
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function __unserialize(array $data) : void
    {
        $this->entryName = $data['entry_name'];
    }

    public function create(Row $row) : Entry
    {
        return $row->get($this->entryName)->rename('id');
    }
}
