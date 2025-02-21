<?php

namespace ReactMoreTech\Support\Exceptions;

class MissingArguements extends BaseException
{
    public function setMessage()
    {
        return 'Missing arguements exception. Content fields must be complete';
    }

    public function setCode()
    {
        return 400;
    }
}
