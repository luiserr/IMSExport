<?php

namespace IMSExport\Application\IMS\Services\Question;

class Factory
{
    public static function getDriver($type, $data, $self)
    {
        switch ($type) {
            case QuestionTypes::_boolean:
            case QuestionTypes::_unique:
            	return new MultipleChoise($data, $self);
            case QuestionTypes::_multiple:
            	return new MultipleResponse($data, $self);
            case QuestionTypes::_spaces:
            case QuestionTypes::_columns:
            	return new Fib($data, $self);
            case QuestionTypes::_opened:
            case QuestionTypes::_file:
            case QuestionTypes::_brief:
            case QuestionTypes::_zone:
                return new Essay($data, $self);

        }
        return null;
    }
}