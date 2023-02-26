<?php

namespace ReactMoreTech\Support\Exceptions;

use DateTimeInterface;
use RuntimeException;

class Exception extends RuntimeException implements ExceptionInterface
{
    public static function startDateCannotBeAfterEndDate(DateTimeInterface $startDate, DateTimeInterface $endDate): static
    {
        return new static("Start date `{$startDate->format('Y-m-d')}` cannot be after end date `{$endDate->format('Y-m-d')}`.");
    }
}
