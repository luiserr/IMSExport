<?php

namespace IMSExport\Application\IMS\Services\Question;

class Factory
{
    public static function getDriver(string $type, $data)
    {
        switch ($type) {
            case QuestionTypes::_boolean:
                return new Boolean($data);
        }
        return null;
    }
}