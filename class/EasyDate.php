<?php 
/**
* Класс для работы с датами
*   свойство $today   - содержит текущее время в секундах и заполняется при создании экземпляра класса;
*   свойство $weekDay - содержит наименование текущего дня недели, заполняется на основе значения совйства $today и метода todaysWeekDay() экземпляра класса;
*   свойство $month   - содержит наименование текущего дня месяца, заполняется на основе значения совйства $today и метода todaysMonth() экземпляра класса;
*     Методы:
*   todaysMonth()   - возвращает название текущего месяца на рус.
*   tadaysWeekDay() - возвращает название текущего лня недели на рус.
*   strToTime()     - преобразует строковую дату в текущее время в секундах, принимает строковое значение формата DD MM YY/YYYY, раделители могут быть: , . ; -- . Принятое значени валидируется и проверяется на факт правильного указаная даты с учетом длинным конкретного месяца и высокостного года;
*   getFraction()   - используется в методе howLong();
*   howLong()       - принимает секунды, возвращает полное количество лет, мес, дней, часов, минут, секунд в виде массива;
*   getFullPeriiods()       - принимает секунды, возвращает полное количество лет, мес, дней, часов, минут, секунд в виде строки;
*   betweenDates()       - принимает 2 даты в формате строки либо секундах и возвращает разницу между датами в формате строки;
*/
class EasyDate{
  public $today;
  public $weekDay;
  public $month;
  protected $weekDays = ['Mon' => 'Понедельник', 'Tue' => 'Вторник', 'Wed' => 'Среда', 'Thu' => 'Четверг', 'Fri' => 'Пятница', 'Sat' => 'Суббота', 'Sun' => 'Воскресенье'];
  protected $monthes = ['Неправильный номер месяца', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь', ];

  function __construct(){
    $this->today = time();
    $this->weekDay = $this->todaysWeekDay();
    $this->month = $this->todaysMonth();
  }

  public function todaysMonth() {
    return $this->monthes[date('n')];
  }

  public function todaysWeekDay() {
    return $this->weekDays[date('D')];
  }

  public function strToTime($str) {
    if (is_string($str)) {
      $clearStr = str_replace([',', '.', ';', '--'], '-', str_replace(' ', '', trim($str)));
      if (strlen($clearStr) >= '9') {
        $date = explode('-', $clearStr);
        $day = $date['0'];
        $mon = $date['1'];
        $year = $date['2'];
        $monthLength = ['0', '31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31', '01' => '31', '02' => '28', '03' => '31', '04' => '30', '05' => '31', '06' => '30', '07' => '31', '08' => '31', '09' => '30'
        ];
        if ($year % 4 == 0) {
          $monthLength['2'] = '29'; 
          $monthLength['02'] = '29'; 
        }

        $rightYear = ($year >= 0 && $year <= 99) || (preg_match('/\d\d\d\d/', $year));
        if ($rightYear) {
          $rightMon = $mon >= 1 && $mon <= 12;
          if ($rightMon) {
            $rightDay = $day >= 1 && $day <= $monthLength[$mon];
            if (!$rightDay) {
              return 'Неправильно указан день!';
            }
          } else {
            return 'Неправильно указан месяц!';
          }
        } else {
          return 'Неправильный указан год!';
        }

        if ($rightDay && $rightMon && $rightYear) { return strtotime($year.'-'.$mon.'-'.$day); }
      }
    } else {
      return 'Неправильный тип входящего значения, оно не является строкой!';
    }
  }

  private function getFraction($n) {
    return $n - floor($n);
  }

  private function howLong($num) {
    $y = floor($num / 60 / 60 / 24 / 365.25 + 1969);
    $mon = floor(self::getFraction($num / 60 / 60 / 24 / 365.25) * 12);
    $d = round(self::getFraction($num / 60 / 60 / 24 / (365.25 / 12)) * (365.25 / 12));
    $h = floor(self::getFraction($num / 60 / 60 / 24) * 24);
    $min = floor(self::getFraction($num / 60 / 60) * 60);
    $s = floor(self::getFraction($num / 60) * 60);
    return ['лет' => $y, 'месяцев' => $mon, 'дней' => $d, 'часов' => $h, 'минут' => $min, 'секунд' => $s];
  }

  public function getFullPeriods($num) {
    $arr = self::howLong($num);
    $str = 'В этой дате содержится следующее полное количество прошедших: ';
    foreach ($arr as $name => $val) {
      $str .= $name . ' - ' . $val . ', ';
    }
    $str = substr($str, 0, strlen($str) - 3) . '.';
    return $str;
  }

  public function betweenDates($date1, $date2) {
    $date_reg = '/\b((\d\d)|\d)(\.|\,\-\_\s)((\d\d)|\d)(\.|\,\-\_\s)(\d\d|\d\d\d\d)\b/';
    $monthLength = ['0', '31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31', '01' => '31', '02' => '28', '03' => '31', '04' => '30', '05' => '31', '06' => '30', '07' => '31', '08' => '31', '09' => '30'
        ];

    if (preg_match($date_reg, $date1)) {
      $d1 = $this->strToTime($date1);
    } else {
      $d1 = $date1;
    }
    if (preg_match($date_reg, $date2)) {
      $d2 = $this->strToTime($date2);
    } else {
      $d2 = $date2;
    }
    if ($d2 - $d1 > 0) {
      $firstDate = explode('-', Date('Y-n-j', $d1));
      $secondDate = explode('-', Date('Y-n-j', $d2));
    } elseif ($d2 - $d1 < 0) {
      $firstDate = explode('-', Date('Y-n-j', $d2));
      $secondDate = explode('-', Date('Y-n-j', $d1));
    } else {
      return 'Указаны две одинаковые даты!';
    }
    $diff = array();
    $diff['y'] = $secondDate['0'] - $firstDate['0'];
    if ($secondDate['1'] < $firstDate['1']) {
      $diff['y'] = $diff['y'] - 1;
      $diff['m'] = 12 - $firstDate['1'] + $secondDate['1'];
    } else {
      $diff['m'] = $secondDate['1'] - $firstDate['1'];
    }
    if ($secondDate['2'] < $firstDate['2']) {
      $diff['m'] = $diff['m'] - 1;
      if ($diff['m'] < 0) {
        $diff['m'] = 11;
        $diff['y'] = $diff['y'] - 1;
      }
      $diff['d'] = $secondDate['2'] + $monthLength[$firstDate['1']] - $firstDate['2'];
    } else {
      $diff['d'] = $secondDate['2'] -$secondDate['2'];
    }
    return 'Интервал между датами составляет: ' . $diff['y'] . ' лет, ' . $diff['m'] . ' месяцев, ' . $diff['d'] . ' дней.';
  }
}
?>