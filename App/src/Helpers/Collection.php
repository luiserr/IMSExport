<?php


namespace IMSExport\Helpers;


use JetBrains\PhpStorm\Pure;

/**
 * @param array $array
 * @return Collection
 */
#[Pure] function createCollection($array): Collection
{
    if (is_array($array)) {
        return new Collection($array);
    }
    return new Collection([]);
}

namespace IMSExport\Helpers;

class Collection
{
    protected $collection;

    /**
     * Collections constructor.
     * @param array $collection
     */
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param array $array
     * @return Collection
     */
    public static function collection($array = [])
    {
        if (is_array($array)) {
            return new Collection($array);
        }
        return new Collection([]);
    }

    /**
     * @param string $key
     * @return Collection;
     */
    public function pluck($key)
    {
        $newCollection = Collections::pluck($this->collection, $key);
        return new Collection($newCollection);
    }

    /**
     * @param string|callable $key
     * @param string|null $value
     * @return Collection
     */
    public function where($key, $value = null)
    {
        if ($this->count()) {
            $result = [];
            $newCollection = Collections::where($key, $value, $this->collection);
            foreach ($newCollection as $item) {
                $result[] = $item;
            }
            return new Collection($result);
        }
        return new Collection([]);
    }

    /**
     * @param string $key
     * @param string $value
     * @return array
     */
    public function first($key = null, $value = null)
    {
        if ($key !== null && $value !== null) {
            return Collections::first($key, $value, $this->collection);
        }
        if ($this->count()) {
            $first = array_slice($this->collection, 0, 1);
            return $first ? $first[0] : [];
        }
        return [];
    }

    public function unique($key)
    {
        $newCollection = Collections::unique($this->collection, $key);
        return new Collection($newCollection);
    }

    /**
     * @param int
     * @return Collection
     */
    public function take($number = 1)
    {
        if ($this->count()) {
            $newCollection = array_slice($this->collection, 0, $number);
            return new Collection($newCollection);
        }
        return new Collection([]);
    }

    /**
     * @param array $keys
     * @return Collection
     */
    public function columns($keys)
    {
        $newCollection = Collections::columns($this->collection, $keys);
        return new Collection($newCollection);
    }

    public function count()
    {
        return count($this->collection);
    }

    /**
     * @param array $keys
     * @param int $length
     * @param bool $replace
     * @param string $fill
     * @return Collection
     */
    public function cutText($keys, $length = 8, $replace = false, $fill = '...')
    {
        $newCollection = Collections::cutText($this->collection, $keys, $length, $replace, $fill);
        return new Collection($newCollection);
    }

    /**
     * @param array $keys
     * @return Collection
     */
    public function clearText($keys)
    {
        $newCollection = Collections::clearText($this->collection, $keys);
        return new Collection($newCollection);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->collection;
    }
}