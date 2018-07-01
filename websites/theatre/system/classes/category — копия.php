<?php 

/**
* 
*/
class CategorySeats
{
  public $category_id;
  public $category_name;
  public $catefory_price;

  protected $categoryList = ['listName' => 'category'; 'id' => 'category_id', 'name' => 'category_name', 'price' => 'price'];
  protected $seatsList = ['listName' => 'seat', 'id' => 'seat_id', 'row' => 'seat_row', 'num' => 'seat_number'];
  protected $ordersList = ['listName' => 'tickets'];
  protected $orderStatusList = ['listName' => 'order_status', 'id' => 'order_status_id', 'availability' => 'order_status_availability', 'not_available' => 'n\a'];
  private $elementClasses = ['check' => 'seatBox', 'row' => 'seatRow', 'single_row' => 'singleSeatRow', 'category_seats_container' => 'categoryContainer', 'row_num_label' => 'rowNumber'];
  private $db_data = ['h' => HOST, 'u' => USER, 'p' => PASSWORD, 'db' => DATABASE];
  private $db;


  protected $category_seats;
  
  function __construct($category_id, $categoryList = '', $seatsList = '', $ordersList = '', $orderStatusList = '', $elementClasses = '', $db_data = '') {

    //Создание подключения к БД на основе входящего аргумента(асс.массива) $row либо значений по умолчанию (констант из config.php)
    if (!empty($db_data) && is_array($db_data)) {
      if (!empty($db_data['h'])) { $this->db_data['h'] = $db_data['h']; }
      if (!empty($db_data['u'])) { $this->db_data['u'] = $db_data['u']; }
      if (!empty($db_data['p'])) { $this->db_data['p'] = $db_data['p']; }
      if (!empty($db_data['db'])) { $this->db_data['db'] = $db_data['db']; }
    }
    $this->db = mysqli_connect($this->db_data['h'], $this->db_data['u'], $this->db_data['p'], $this->db_data['db']);

      //Таблица категорий и имена полей этой таблицы
    if (!empty($categoryList) && is_array($cat_list)) {
      if (!empty($categoryList['listName'])) { $this->categoryList['listName'] = $categoryList['listName']; }
      if (!empty($categoryList['id'])) { $this->categoryList['id'] = $categoryList['id']; }
      if (!empty($categoryList['name'])) { $this->categoryList['name'] = $categoryList['name']; }
      if (!empty($categoryList['price'])) { $this->categoryList['price'] = $categoryList['price']; }
    }
 
      //Таблица мест и имена полей этой таблицы
    if (!empty($seatsList) && is_array($seatsList)) {
      if (!empty($seatsList['listName'])) { $this->seatsList['listName'] = $seatsList['listName']; }
      if (!empty($seatsList['id'])) { $this->seatsList['id'] = $seatsList['id']; }
      if (!empty($seatsList['row'])) { $this->seatsList['row'] = $seatsList['row']; }
      if (!empty($seatsList['number'])) { $this->seatsList['number'] = $seatsList['number']; }
    }

      //Таблица с заказами и имена полей этой таблицы
    if (!empty($ordersList) && is_array($ordersList)) {
      if (!empty($ordersList['listName'])) { $this->ordersList['listName'] = $ordersList['listName']; }
    }

    //Заполнение полей объекта с данными о категории
    $this->category_id = $category_id;
    $temp_arr = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM ".$this->categoryList['listName']." WHERE ".$this->categoryList['id']."='".$this->category_id."'"));
    $this->category_name = $temp_arr[$this->categoryList['name']];
    $this->category_price = $temp_arr[$this->categoryList['price']];
    unset($temp_arr);

     //Таблица с заказами и имена полей таблицы, варианты значений полей, при которых билет недоступен к покупке
    $orderList = empty($arg['orderList']) ? 'tickets' : $arg['orderList'];

     //Таблица со статусами заказа
    $orderStatusList = empty($arg['orderStatusList']) ? 'order_status' : $arg['orderStatusList'];
    $orderStatusID_field = empty($arg['orderStatusID_field']) ? 'order_status_id' : $arg['orderStatusID_field'];
    $orderStatusAv_field = empty($arg['orderStatusAvailability_field']) ? 'order_status_availability' : $arg['orderStatusAvailability_field'];
    $unavailable = empty($arg['unavailable_value']) ? 'n\a' : $arg['unavailable_value'];
    $q_s = mysqli_query($this->db, "SELECT ".$orderStatusID_field.", ".$orderStatusAv_field." FROM ".$orderStatusList."");
    while ($r[] = mysqli_fetch_assoc($q_s)) {
      $statusArr = $r;
    }
    unset($r);
    $n_aStatus = array();
    foreach ($statusArr as $status) {
      if ($status[$orderStatusAv_field] == $unavailable) {
        $n_aStatus[] = $status[$orderStatusID_field];
      }
    }
    unset($q_s);
    unset($statusArr);

    //Переменные с именами классов
    $checkClass = empty($arg['checkbox_class']) ? 'seatBox' : $arg['checkbox_class'];
    $rowClass = empty($arg['seats_row_class']) ? 'seatRow' : $arg['cseats_row_class'];
    $singleRowClass = empty($arg['seats_single_row_class']) ? 'seatRow' : $arg['seats_single_row_class'];
    $catContainerClass = empty($arg['container_category_class']) ? 'categoryContainer' : $arg['container_category_class'];
    $rowLabelClass = empty($arg['row_label_class']) ? 'rowNumber' : $arg['row_label_class'];





    //Заполнение массива мест категории
    $q_seats = mysqli_query($this->db, "SELECT ".$this->seatsList['id'].", ".$this->seatsList['row'].", ".$this->seatsList['num']." FROM ".$this->seatsList['name']." WHERE ".$this->categoryList['id']."='".$this->category_id."'");
    while ($r[] = mysqli_fetch_assoc($q_seats)) { $all_cat_seat = $r; }
    unset($r);
    $row = null;
    foreach ($all_cat_seat as $seat) {
      $sql = "SELECT ".$this->seatsList['id']." FROM ".$orderList." WHERE ".$this->seatsList['id']."='".$seat[$this->seatsList['id']]."' AND (";
      foreach ($n_aStatus as $n_aID) {
        $sql .= "".$orderStatusID_field."='".$n_aID."' OR ";
      }
      $sql = substr($sql, 0, strlen($sql) - 4);
      $sql .= ')';
      $ordered = mysqli_fetch_assoc(mysqli_query($this->db, $sql));
      $row = $row == $seat[$this->seatsList['row']] ? $row : $seat[$this->seatsList['row']];
      if (empty($ordered)) {
        $this->category_seats[$row][] = ['id' => $seat[$this->seatsList['id']], 'num' => $seat[$this->seatsList['num']], 'available' => '1'];
      } else {
        $this->category_seats[$row][] = ['id' => $seat[$this->seatsList['id']], 'num' => $seat[$this->seatsList['num']], 'available' => '0'];
      }
    }
  }

  function __toString() {
    $returnStr = '';
    if (count($this->category_seats) == '1') {
      $returnStr .= '<div class="'.$singleRowClass.' '.$catContainerClass.'">';
      foreach ($category_seats as $singleRow) {
        foreach ($singleRow as $seat) {
          $returnStr .= '<label>'.$seat['num'].'<input type="checkbox" class="'.$checkClass.'"';
          if ($seat['available'] == '0') {
            $returnStr .= ' name="notAvailableSeats[]"checked disabled></label>';
          } else {
            $returnStr .= ' name="availableSeats[]"></label>';
          }
        }
      }
      $returnStr .= '</div>';
    } else {
      $returnStr .= '<div class="'.$catContainerClass.'">';
      foreach ($this->category_seats as $rowNumber => $row) {
        $returnStr .= '<span class="'.$rowLabelClass.'">Ряд '.$rowNumber.': </span><div class="'.$rowClass.'">';
        foreach ($row as $seat) {
          $returnStr .= '<label>'.$seat['num'].'<input type="checkbox" class="'.$checkClass.'"';
          if ($seat['available'] == '0') {
            $returnStr .= ' name="notAvailableSeats[]" checked disabled></label>';
          } else {            
            $returnStr .= ' name="availableSeats[]"></label>';
          }  
        }
        $returnStr .= '</div>';
      }
      $returnStr .= '</div>';
    }
    return $returnStr;
  }
}
?>