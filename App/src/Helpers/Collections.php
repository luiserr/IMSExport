<?php


namespace IMSExport\Helpers;


class Collections
{
    public static function pluck($array, $key)
    {
        return array_map(function ($v) use ($key) {
            return is_object($v) ? $v->$key : $v[$key];
        }, $array);
    }

    /**
     * @param string|callable $key
     * @param string|null $value
     * @param array $array
     * @return array
     */
    public static function where($key, $value = null, $array = [])
    {
        if (is_callable($key)) {
            return array_filter($array, $key);
        }
        return array_filter($array, static function ($item) use ($key, $value) {
            return $item[$key] == $value;
        });
    }

    /**
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function unique($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public static function first($key, $value, $collection)
    {
        $newCollection = self::where($key, $value, $collection);
        if (count($newCollection)) {
            return array_shift($newCollection);
        }
        return null;
    }

    /**
     * @param array $array
     * @param int $number
     * @return array
     */
    public static function take($array, $number = 1)
    {
        return array_slice($array, 0, $number);
    }

    /**
     * @param array $collection
     * @param array $keys
     * @return array
     */
    public static function columns($collection, $keys)
    {
        $result = [];
        foreach ($collection as $item) {
            $temp = [];
            foreach ($keys as $index => $value) {
                if (is_string($index)) {
                    if (isset($item[$index])) {
                        $temp[$value] = $item[$index];
                    }
                } elseif (isset($item[$value])) {
                    $temp[$value] = $item[$value];
                } else {
                    $temp[$value] = null;
                }
            }
            $result [] = $temp;
        }
        return $result;
    }

}