<?php

namespace Core\QueryBuilder;

final class Delete
{
    private string $table;
    private array $where = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'DELETE FROM ' . $this->table . ($this->where !== [] ? ' WHERE ' . \implode(' AND ', $this->where) : '');
    }

    /**
     * @param string ...$where
     * @return $this
     */
    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->where[] = $arg;
        }
        return $this;
    }
}