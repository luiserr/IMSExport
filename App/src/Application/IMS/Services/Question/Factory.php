<?php

namespace IMSExport\Application\IMS\Services\Question;

class Factory
{
    public static function getDriver(string $type, $data, $self)
    {
        switch ($type) {
            case QuestionTypes::_boolean:
                return new Boolean($data, $self);
        }
        return null;
    }
}