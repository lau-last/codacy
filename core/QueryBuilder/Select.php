<?php

namespace Core\QueryBuilder;

final class Select
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
     * @var array|null
     */
    private ?array $join = [];

    /**
     * @var array|null
     */
    private ?array $where = [];

    /**
     * @var string|null
     */
    private ?string $orderBy = null;


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
        return 'SELECT ' . \implode(', ', $this->value) . ' FROM ' . $this->table
            . (!empty($this->join) ? ' INNER JOIN ' . \implode($this->join) : '')
            . ($this->where !== [] ? ' WHERE ' . \implode(' AND ', $this->where) : '')
            . ($this->orderBy !== null ? ' ORDER BY ' . $this->orderBy : '');

    }


    /**
     * @param string ...$join
     * @return $this
     */
    public function join(string ...$join): self
    {
        foreach ($join as $arg) {
            $this->join[] = $arg;
        }

        return $this;

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


    /**
     * @param string $orderBy
     * @return $this
     */
    public function orderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;

    }


}
