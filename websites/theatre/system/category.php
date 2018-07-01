<?php 
/**
* 
*/
class CategorySeats
{ 
  public $name;
  public $price;

  protected $id;
  protected $seats;
  protected $seatsFields = array();
  protected $elementClasses = ['checkbox' => 'seatBox', 'row' => 'seatRow', 'singleRow' => 'singleSeatRow', 'container' => 'seatContainer', 'rowNumLabel' => 'rowNumber', 'NA' => 'disabled'];
  protected $inputNames = ['enable' => 'orderedSeats[]', 'disable' => 'NA[]'];

  function __construct($id, $lists = ['category' => [], 'seats' => [], 'orders' => [], 'orderStatuses' => []], $elementClasses = '', $db_data = '') {
    
    $this->id = $id;

    //создание и данных о таблицах по-умолчанию
    $categoryList = ['listName' => 'category', 'id' => 'category_id', 'name' => 'category_name', 'price' => 'price'];
    $seatsList = ['listName' => 'seat', 'id' => 'seat_id', 'row' => 'seat_row', 'number' => 'seat_number'];
    $ordersList = ['listName' => 'tickets'];
    $orderStatusesList = ['listName' => 'order_status', 'id' => 'order_status_id', 'availability' => 'order_status_availability', 'NAvalue' => 'NA'];

    //Внесение изменений в данных о таблицах, если какие-либо тз них были указаны в аргументах при создании объекта
    if (!empty($lists['category'] && is_array($lists['category']))) {
      if (!empty($lists['category']['listName'])) { $categoryList['listName'] = $lists['category']['listName']; }
      if (!empty($lists['category']['id'])) { $categoryList['id'] = $lists['category']['id']; }
      if (!empty($lists['category']['name'])) { $categoryList['name'] = $lists['category']['name']; }
      if (!empty($lists['category']['price'])) { $categoryList['price'] = $lists['category']['price']; }
    }
    if (!empty($lists['seats'] && is_array($lists['seats']))) {
      if (!empty($lists['seats']['listName'])) { $seatsList['listName'] = $lists['seats']['listName']; }
      if (!empty($lists['seats']['id'])) { $seatsList['id'] = $lists['seats']['id']; }
      if (!empty($lists['seats']['row'])) { $seatsList['row'] = $lists['seats']['row']; }
      if (!empty($lists['seats']['number'])) { $seatsList['number'] = $lists['seats']['number']; }
    }
    $this->seatsFields['id'] = $seatsList['id'];
    $this->seatsFields['row'] = $seatsList['row'];
    $this->seatsFields['number'] = $seatsList['number'];
    if (!empty($lists['orders'] && is_array($lists['orders']))) {
      if (!empty($lists['orders']['listName'])) { $ordersList['listName'] = $lists['orders']['listName']; }
    }
    if (!empty($lists['orderStatuses'] && is_array($lists['orderStatuses']))) {
      if (!empty($lists['orderStatuses']['listName'])) { $orderStatusesList['listName'] = $lists['orderStatuses']['listName']; }
      if (!empty($lists['orderStatuses']['id'])) { $orderStatusesList['id'] = $lists['orderStatuses']['id']; }
      if (!empty($lists['orderStatuses']['availability'])) { $orderStatusesList['availability'] = $lists['orderStatuses']['availability']; }
      if (!empty($lists['orderStatuses']['NAvalue'])) { $orderStatusesList['NAvalue'] = $lists['orderStatuses']['NAvalue']; }
    }

    //Создание подключения к БД на основе данных по умолчанию, либо значений из аргумента $db_data
    if (is_array($db_data) && count($db_data) == '4') {
      $db = mysqli_connect($db_data['0'], $db_data['1'], $db_data['2'], $db_data['3']);
    } else {
      $db = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    }

    //Заполнение значений полей $name, $price объекта на основе значения $id и БД\
    $temp = mysqli_fetch_assoc(mysqli_query($db, "SELECT ".$categoryList['name'].", ".$categoryList['price']." FROM ".$categoryList['listName']." WHERE ".$categoryList['id']."=".$this->id.""));
    $this->name = $temp[$categoryList['name']];
    $this->price = $temp[$categoryList['price']];
    unset($temp);

    //Получение ключей статусов заказа при которых приобретение билета невозможно
    $q = mysqli_query($db, "SELECT ".$orderStatusesList['id']." FROM ".$orderStatusesList['listName']." WHERE ".$orderStatusesList['availability']."='".$orderStatusesList['NAvalue']."'");
    while ($r[] = mysqli_fetch_assoc($q)) { $temp = $r; }
    $NAvalue = "";
    foreach ($temp as $val) { $NAvalue .= "".$orderStatusesList['id']."='".$val[$orderStatusesList['id']]."' OR "; }
    $NAvalue = substr($NAvalue, 0, strlen($NAvalue) - 4);
    unset($q, $r, $temp);

    //Получение списка мест категории
    $q = mysqli_query($db, "SELECT ".$seatsList['id'].", ".$seatsList['row'].", ".$seatsList['number']." FROM ".$seatsList['listName']." WHERE ".$categoryList['id']."=".$this->id."");
    while ($r[] = mysqli_fetch_assoc($q)) { $this->seats = $r; }
    unset($q, $r);
    foreach ($this->seats as $i => $seat) {
      $f = mysqli_fetch_assoc(mysqli_query($db, "SELECT ".$seatsList['id']." FROM ".$ordersList['listName']." WHERE ".$seatsList['id']."='".$seat[$seatsList['id']]."' AND (".$NAvalue.")"));
      if (!empty($f)) { $this->seats[$i]['NA'] = true; }
    }
  }

  function __toString() {
    $r = '<div class="' . $this->elementClasses['container'] . '">';
    if ($this->seats['0'][$this->seatsFields['row']] == $this->seats[count($this->seats) - 1][$this->seatsFields['row']]) {
      foreach ($this->seats as $seat) {
        $r .= '<label class="seat">'.$seat[$this->seatsFields['number']].'<input type="checkbox" class="'.$this->elementClasses['checkbox'].'" value="'.$seat[$this->seatsFields['id']].'"';
        if ($seat['NA']) { $r .= ' name="'.$this->inputNames['disable'].'" checked disabled'; } 
                    else { $r .= ' name="'.$this->inputNames['enable'].'"'; }                  
        $r .= '></label>';
      }
    } else {  
      $row = null;
      foreach ($this->seats as $key => $seat) {
        if ($row != $seat[$this->seatsFields['row']]) {
          $row = $seat[$this->seatsFields['row']];
          $r .= '<div class="'.$this->elementClasses['row'].'"><span class="'.$this->elementClasses['rowNumLabel'].'">Ряд: '.$row.'</span>';
        }
        if ($seat['NA']) { 
          $r .= '<label class="'.$this->elementClasses['NA'].' seat">'.$seat[$this->seatsFields['number']].'<input type="checkbox" class="'.$this->elementClasses['checkbox'].'" name="'.$this->inputNames['disable'].'" checked disabled  value="'.$seat[$this->seatsFields['id']].'"'; 
        } else { 
          $r .= '<label class="seat">'.$seat[$this->seatsFields['number']].'<input type="checkbox" class="'.$this->elementClasses['checkbox'].'" name="'.$this->inputNames['enable'].'"  value="'.$seat[$this->seatsFields['id']].'"'; 
        }                  
        $r .= '></label>';
        if ($row != $this->seats[(int)$key + 1][$this->seatsFields['row']]) { $r .= '</div>'; }
      }
    }
    $r .= '</div>';
    return $r;
  }
}
?>