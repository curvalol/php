<?php

/**
 * Класс Deliver для рассчета дня доставки с учетом 1-2 дней на доставку в зависимости от времени регистрации до или после 20ч., выходных Сб,Вс и праздников из массива в совйстве $celebrates
 *   ожидаемое время доставки рассчитывает рпи создании экземпляра класса;
 *   вывод сообщения с текстом о приблизительном времени доставки можно сделать просто преобразуя объект в строку
 */
class Deliver
{
    public $date;
    protected $deliverTime;
    protected $weekDays = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
    protected $monthes = ['Неправильный номер месяца', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июнь', 'августа', 'сентября', 'октября', 'ноября', 'декабря',];
    public $celebrates = ['01-01', '01-02', '01-02', '08-21', '08-22'];

    function __construct($date = '')
    {
        if (empty($date)) {
            $this->date = time();
        } else {
            $this->date = strtotime($date);
        }
        if (date('H', $this->date) < 20) {
            $deliverPeriod = 86400;
        } else {
            $deliverPeriod = 172800;
        }
        $this->deliverTime = $this->date + $deliverPeriod;
        while (date('N', $deliver) > 5 || in_array(date('m', $deliver) . '-' . date('d', $deliver), $this->celebrates)) {
            $this->deliverTime += 86400;
        };
    }

    function __toString()
    {
        $day = date('j', $this->deliverTime);
        $month_name = $this->monthes[Date('n', $this->deliverTime)];
        $year = date('Y', $this->deliverTime);
        $weekday = $this->weekDays[date('w', $this->deliverTime)];

        return 'Приблизительная дата доставки Вашей посылки: ' . $day . ' ' . $month_name . ' ' . $year . '-го года, ' . $weekday . '.';
    }
}

?>