<?php
use Yasumi\Yasumi;

function isHoliday(\DateTimeInterface $currentTime, $country = 'Japan', $locale = 'ja_JP')
{
    $holidays = Yasumi::create($country, (int)$currentTime->format('Y'), $locale);
    return $holidays->isHoliday($currentTime);
}

function holidays(\DateTimeInterface $currentTime, $country = 'Japan', $locale = 'ja_JP')
{
    $holiday_name = "";

    if(isHoliday($currentTime))
    {
        $holidays = Yasumi::create($country, (int)$currentTime->format('Y'), $locale);
        
        foreach ($holidays->getHolidays() as $holiday) {
            
            if($holiday->format('Y-m-d') == $currentTime->format('Y-m-d'))
            {
                $holiday_name = "<b>" . $holiday->getName() . "</b>";
                break;
            }
        }
    }
    
    return $holiday_name;
}

function dailyHoliday($date)
{
    $class_name = "";
    $holiday_name = "";
    if(isHoliday(new \DateTime($date)))
    {
        $class_name = "holiday";
        $holiday_name = holidays(new \DateTime($date));
    }

    return ['class_name' => $class_name, 'holiday_name' => $holiday_name];
}






