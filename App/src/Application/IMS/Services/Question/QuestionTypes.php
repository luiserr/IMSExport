<?php

namespace IMSExport\Application\IMS\Services\Question;

class QuestionTypes
{
    const _multiple = 1;
    const _opened = 4;
    const _columns = 3;
    const _spaces = 5;
    const _boolean = 6;
    const _brief = 7;
    const _zone = 8;
    const _file = 9;
    const _unique = 10;

    const multiple = 'multiple';
    const opened = 'opened';
    const columns = 'columns';
    const spaces = 'spaces';
    const boolean = 'boolean';
    const brief = 'brief';
    const zone = 'zone';
    const file = 'file';
    const unique = 'unique';

    public static function getType($type)
    {
        switch ($type) {
            case self::_opened:
                return self::opened;
            case self::_columns:
                return self::columns;
            case self::_spaces:
                return self::spaces;
            case self::_boolean:
                return self::boolean;
            case self::_brief:
                return self::brief;
            case self::_zone:
                return self::zone;
            case self::_file:
                return self::file;
            case self::_unique:
                return self::unique;
            default:
                return multiple;
        }
    }
}