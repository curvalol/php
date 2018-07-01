<?php 
/**
* Класс Validate предназначен для валидации данных формы, сохранения провалидированных значений и ошибки с неверно провалидированным полем. Возвращает только одну ошибку, о первом непровалидированном значении, и все значения прошедшие валидацию.
  - конструктор принимает $sessionFieldName = 'form'(строка, применяется как имя переменной) и на основе полученной строке создает переменную в $_SESSION куда будут записаны массивы содержащие провалидированные значения;
  - деструктор - передает массивы провалидированных значений и ошибки в $_SESSION;

* метод validation:
    Базовый метод класса, используется для создания других методов с более конкретным назначением либо для валидации значений не предусмотренных другими методами
  принимает:
    - $val -- обязательный агрумент с которым передается валидируемое значение, строка
    - $c -- обязательный аргумент с которым передаются условия валидации в формате регулярного выражения либо в формате '>8<20n' - где цифра после '>' это минимальная длинна строки, цифра после '<' максимальная длинна строки, n - к написанию не обязательна, если добавлена, то валидироемое значение обязательно должно модержать цифры для прохождения валидации;
    - $f -- наименование поля в формируемом массиве валидируемых значений, куда буду помещены значения после валидации этого значения;
    - $e -- текст ошибки в случае непрохождения валидации данного значения и которое будет добавлено в массив ошибки

*метод

*/
class Validate{
  public $val = array();
  public $err = array();
  public $sessionFieldName;
  public $database;
  public $table;

  function __construct($sessionFieldName = 'form', $table = 'user', $h = '', $u ='', $p = '', $db = '') {
    $_SESSION[$sessionFieldName] = array();
    $this->sessionFieldName = $sessionFieldName;
    $this->table = $table;
    if (!empty($h) && !empty($db)) {
      $this->database = mysqli_connect($h, $u, $p, $db);
    }
  }  

  protected function getFromDB($sql) {
    if (mysqli_query($this->database, $sql)) {
      $q = mysqli_query($this->database, $sql);
      while ($r[] = mysqli_fetch_assoc($q)) { $v = $r; }
      return $v;
    } else {
      return false;
    }
  }

  protected function removeSpaces($val) {
    return str_replace(' ', '', trim($val));
  }

  public function error($e = 'Значение введено неверно!') {
    if (empty($this->err)) {
      $this->err = $e;
    }
  }

  public function validation($val, $f, $c, $e) {
    $v = $this->removeSpaces($val);
    $error = '';
    if (substr($c, 0, 1) == '/' && substr($c, strlen($c) - 1, 1) == '/') {
      if (preg_match($c, $v)) {
        $this->val[$f] = $v;
      } else {
        $this->error($e);
      }
    } else {
      $min = substr($c, strpos($c, '>') + 1, 1);
      $max = substr($c, strpos($c, '<') + 1, 2);
      $hasNum = strpos($c, 'n');
      $r = '/\w{'.$min.','.$max.'}/';
      if ($hasNum) {
        if (preg_match($r, $v) && preg_match('/\d/', $v)) {
          $this->val[$f] = $v;
        } else {
          $this->error($e);
        }
      } else {
        if (preg_match($r, $v)) {
          $this->val[$f] = $v;
        } else {
          $this->error($e);
        }
      }
    }
  }

  public function login($val, $f = 'login', $c = '>6<16', $e = 'Логин введен неверно!') {
    $this->validation($val, $f, $c, $e);
  }

  public function uniqLogin($val, $f = 'login', $c = '>6<16', $e = 'Логин введен неверно!', $uniqErr = 'Такой логин уже существует!') {
    $v = $this->removeSpaces($val);
    $sql = "SELECT ".$f." FROM ".$this->table." WHERE ".$f."='".$v."'";
    $inDB = $this->getFromDB($sql);
    if (empty($inDB)) {
      $this->login($val, $f, $c, $e);
    } else {
      $this->error($uniqErr);
    }
  }

  public function password($val, $repVal, $f = 'password', $c = '>6<16', $e = 'Пароль введен неверно!') {
    if ($val == $repVal) {
      $this->validation($val, $f, $c, $e);
    } else {
      $this->error('Повторите введенный пароль!');
    }
  }

  public function mail($val, $f = 'mail', $e = 'Электронная почта введена неверно!') {
    $v = str_replace(' ', '', trim($val));
    $r = '/\w+@\w+/';
    if (preg_match($r, $v)) {
      $this->val[$f] = $v;
    } else {
      $this->error($e);
    }
  }

  public function uniqMail($val, $f = 'mail', $e = 'Электронная почта введена неверно!', $uniqErr = 'Эта почта уже используется!') {
    $v = str_replace(' ', '', trim($val));
    $sql = "SELECT ".$f." FROM ".$this->table." WHERE ".$f."='".$v."'";
    $inDB = $this->getFromDB($sql);
    if (empty($inDB)) {
      $this->mail($val, $f, $e);
    } else {
      $this->error($uniqErr);
    }
  }

  public function phone($val, $f = 'phone', $e = 'Неверно введен номер телефона!') {
    $v = trim($val);
    $v = str_replace(['-', '(', ')', '_', ' ', '[', ']', '{', '}'], '', $v);
    $r = '/\+?[0-9]{10-12}/';
    if (preg_match($r, $v)) {
      if (strlen($v) == '12' && substr($v, 0, 1) != '+') {
        $this->val = '+' . $v;
      } else {
        $this->val = $v;
      }
    } else {
      $this->error($e);
    }
  }

  public function agree($val, $e = "Ознакомьтесь и подтвердите согласие с правилами для окончания регистрации!") {
    if ($val == 'ON') {
      $this->val = true;
    } elseif ($val == '') {
      $this->error($e);
    }
  }

  public function uniqPhone($val, $f = 'phone', $e = 'Неверно введен номер телефона!', $uniqErr = 'Такой телефон уже используется!') {    
    $v = trim($val);
    $v = str_replace(['-', '(', ')', '_', ' ', '[', ']', '{', '}'], '', $v);
  }

  public function validated() {
    if (empty($this->err)) {
      return true;
    } else {
      return false;
    }
  }

  public function authorize($login, $fieldLogin, $password, $fieldPassword, $requiredField='', $autiorizedField = 'auth') {
    if (!empty($login)) {
      if (!empty($password)) {
        $sql = "SELECT ";
        $sql .= !empty($requiredField) ? $requiredField : $fieldLogin;
        $sql .= " FROM ".$this->table." WHERE ".$fieldLogin."='".$login."' AND ".$fieldPassword."='".$password."'";
        $user = $this->getFromDB($sql);
        if (!empty($user)) {
          $_SESSION[$autiorizedField] = $user;
        } else {
          $this->error('Пароль или логин введены неверно!');
        }
      } else {
        $this->error('Пароль не введен!');
      }
    } else {
      $this->error('Логин не введен!');
    }
  }

  public function endValidation() {
    $_SESSION[$this->sessionFieldName]['val'] = $this->val;
    $_SESSION[$this->sessionFieldName]['err'] = $this->err;    
  }
}
?>