<?php

namespace Core\QueryBuilder;

final class Insert
{

    /**
     * @var string
     */
    private string $table;

    /**
     * @var array
     */
    private array $value;


    /**
     * @param string $table
     * @param array $value
     */
    public function __construct(string $table, array $value)
    {
        $this->table = $table;
        $this->value = $value;

    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'INSERT INTO ' . $this->table . ' (' . \implode(', ', $this->value) . ') VALUES (:' . \implode(', :', $this->value) . ')';

    }


}
