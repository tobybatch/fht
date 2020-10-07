<?php
declare(strict_types=1);

namespace App\Twig;

use App\Repository\WeaponRepository;
use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{

  /**
   * @var WeaponRepository
   */
  private WeaponRepository $weaponRepository;

  public function __construct(WeaponRepository $weaponRepository)
  {
    $this->weaponRepository = $weaponRepository;
  }

  public function getFilters()
  {
    return [
      new TwigFilter('playedTime', [$this, 'playedTime']),
      new TwigFilter('weaponName', [$this, 'weaponName']),
    ];
  }

  public function weaponName(string $code)
  {

  }

  /**
   * @param $time
   * @return string
   * @throws Exception
   */
  public function playedTime($time)
  {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    // extract days
    $days = floor($time / $secondsInADay);

    // extract hours
    $hourSeconds = $time % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    // $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    // $seconds = ceil($remainingSeconds);

    $time_str = "";
    if ($days > 0) {
      $time_str = $time_str . (string)$days . "D ";
    }
    $time_str = $time_str . (string)$hours . "H ";
    $time_str = $time_str . (string)$minutes . "M";

    return $time_str;
  }
}
