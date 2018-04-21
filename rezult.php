<?php

function
require_once("mysql_login.php");
$mysqli = new mysqli($hm, $us, $pw, $db);
if ($mysqli->connect_error) {
  exit ($mysqli->connect_error);
}
$mysqli->query("SET NAMES 'utf8'");

//$mysqli->query ("INSERT INTO `Users` (`login`, `email`, `password`, `first_name`, `last_name`, `gender`, `birth_date `) VALUES ('login 3','login2@email',MD5('1234'),'User 2 First Name','User 2 Last Name','male','2018-04-18')");

if (isset($_POST)) {

  foreach ($_POST as $key => $value) { //убрал спецсимволы из входящих данных
    $recived_data[$key] = $mysqli->real_escape_string(trim($_POST[$key]));
    echo "\$recived_data[$key] = {$recived_data[$key]}<br>"; //результат работы
  }

  if ($recived_data['form_name'] == 'register') {
    $query = "SELECT login FROM `Users` WHERE login = '{$recived_data['login']}'";
    $DB_res = $mysqli->query($query); // это можно как то сократить?
    $DB_res_Arr = $DB_res->fetch_assoc();
    $reg_err_arr = NULL;
    if ($DB_res_Arr['login'] == $recived_data['login']) {
      $reg_err_arr['login'] = TRUE;
    }
    if ($recived_data['password'] != $recived_data['confirm_password']) {
      $reg_err_arr['password'] = TRUE;
    }
    if (!$reg_err_arr) {
        $query = "INSERT INTO `Users` (
          `login`,
          `email`,
          `password`,
          `first_name`,
          `last_name`,
          `gender`,
          `birth_date`
        ) VALUES (
          '{$recived_data['login']}',
          '{$recived_data['email']}',
          MD5('{$recived_data['password']}'),
          '{$recived_data['first_name']}',
          '{$recived_data['last_name']}',
          '{$recived_data['gender']}',
          '{$recived_data['birth_date']}'
        )";
        $data = $mysqli->query($query);
        if (!$data) {
          echo $mysqli->error;
        }
    } else {
      echo $reg_err_arr['login'].' -- login <br>';
      echo $reg_err_arr['password'].'-- password <br>';
      echo 'есть ошибки';
    }




  /*  $reg_err_arr = NULL;
    if (!empty($recived_data['login'])) {
        if (empty($recived_data['first_name'])) {
          $reg_err_arr['first_name'] = $reg_err_arr['first_name'] . 'введите свое имя<br>';
        }
        if (empty($recived_data['last_name'])) {
          $reg_err_arr['last_name'] = $reg_err_arr['last_name'] . 'введите свою фамилию<br>';
        }
        if (empty($recived_data['gender'])) {
          echo '<br>gender -- '.$recived_data['gender'];
        }
        if (empty($recived_data['birth_date'])) {
          echo '<br>BOD -- '.$recived_data['birth_date'];
        }
        /*ПАРОЛЬ
        1. сравнить пароль и внести его в БД под мд5 (прочитать про мд5)
        2. добавить переключатель показать пароль
        3. применить кодировку пароля в БД

        if (empty($recived_data['password'])) {
          echo '<br>password -- '.$recived_data['password'];
        }
        */

    }


  } elseif ($_POST['form_name'] == 'sign in') {
    /* 1. найти в БД Логин и проверить пароль
      2. если пароль верен вівести ОК
      3. если пароль не верен форма ошибки с формулировкой неверен пароль или логин

    */
  }

$mysqli->close();
function zodiak_sign($birth_date)
?>
