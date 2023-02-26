<?php

namespace ReactMoreTech\Support;

use CodeIgniter\I18n\Time;
use ReactMoreTech\Support\Exceptions\Exception;
use DateTimeInterface;

class PeriodTime
{
    public DateTimeInterface $startDate;

    public DateTimeInterface $endDate;

    public function __construct(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        if ($startDate > $endDate) {
            throw Exception::startDateCannotBeAfterEndDate($startDate, $endDate);
        }

        $this->startDate = $startDate;

        $this->endDate = $endDate;
    }

    public static function create(DateTimeInterface $startDate, DateTimeInterface $endDate): self
    {
        return new static($startDate, $endDate);
    }

    public static function days(int $numberOfDays): static
    {
        $endDate = Time::today()->toDateTime();

        $startDate = Time::today()->subDays($numberOfDays)->toDateTime();

        return new static($startDate, $endDate);
    }

    public static function months(int $numberOfMonths): static
    {
        $endDate = Time::today()->toDateTime();

        $startDate = Time::today()->subMonths($numberOfMonths)->toDateTime();

        return new static($startDate, $endDate);
    }

    public static function years(int $numberOfYears): static
    {
        $endDate = Time::today()->toDateTime();

        $startDate = Time::today()->subYears($numberOfYears)->toDateTime();

        return new static($startDate, $endDate);
    }
}
