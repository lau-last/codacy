<?php

namespace Core\Entity;

abstract class Hydrate
{
    public function __construct(?array $data=[])
    {
        if (!empty($data)) {
            $this->Hydrate($data);
        }
    }

    /**
     * @param $data
     * @return void
     */
    public function Hydrate($data)
    {
        foreach ($data as $key => $value) {
            if (strstr($key, '_')){
                $key = explode('_', $key, 2);
                $key = ($key[0] . ucfirst($key[1]));
            }
            $method = 'set' . \ucfirst($key);
            if (\method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
