<?php

namespace ReactMoreTech\Support\Adapter\Validations;


class Validator extends BaseValidation
{
    
    public static function validateInquiryRequest($request, $fields)
    {
        self::validateContentType($request);
        self::validateContentFields($request, $fields);
    }

    public static function validateArrayRequest($request)
    {
        self::validateContentType($request);
    }

    public static function validateSingleArgument($argument, $fieldName)
    {
        
        self::validateSingleArgument($argument, $fieldName);
    }
}
