<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 22/10/18
 * Time: 16:53
 */

namespace App\Service;


class Date
{
    public function getCurrentDayFormattedToInteger(): ?int
    {
        $date = new \DateTime('now');
        $formattedDate = $date->format('w');
        dump($formattedDate);
        return (int)$formattedDate;
    }

    public function getNextSaturday(): ?string
    {
        $numbers = self::getNumberForNextSaturday();
        $newDate = new \DateTime('now');
        $formatted = $newDate->format('d-m-Y');
        $saturday = date("d-m-Y", strtotime($formatted ." + {$numbers['number']} days"));
        return $saturday;
    }

    public function getLastSaturday(): ?string
    {
        $numbers = self::getNumberForLastSaturday();
        dump($numbers);
        die;
        $newDate = new \DateTime('now');
        $formatted = $newDate->format('d-m-Y');
        $saturday = date("d-m-Y", strtotime($formatted . " - {$numbers['number']} days"));
        return $saturday;
    }

    public function getNumberForNextSaturday(): ?array
    {
        $currentDay = self::getCurrentDayFormattedToInteger();
        switch ($currentDay) {
            case 1: $saturday = $currentDay + 5; break;
            case 2: $saturday = $currentDay + 4; break;
            case 3: $saturday = $currentDay + 3; break;
            case 4: $saturday = $currentDay + 2; break;
            case 5: $saturday = $currentDay + 1; break;
            case 6: $saturday = $currentDay; break;
            case 7: $saturday = $currentDay + 6; break;
        }
        return array(
            'saturday' => $saturday,
            'number' => $saturday - $currentDay
        );
    }

    public function getNumberForLastSaturday(): ?array
    {
        $currentDay = self::getCurrentDayFormattedToInteger();
        switch ($currentDay) {
            case 1: $saturday = $currentDay + 2; break;
            case 2: $saturday = $currentDay + 3; break;
            case 3: $saturday = $currentDay + 4; break;
            case 4: $saturday = $currentDay + 5; break;
            case 5: $saturday = $currentDay + 6; break;
            case 6: $saturday = $currentDay + 7; break;
            case 7: $saturday = $currentDay + 1; break;
        }
        return array(
            'saturday' => $saturday,
            'number' => $saturday
        );
    }
}
