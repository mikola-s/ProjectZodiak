<?php
require_once("StartSet.php");
//1. найти в Гугле инфу по знакам зодиака
//2. найти в Гугле инфу по зверям года знакам зодиака
//3. найти в Гугле инфу по гороскопам
//4. сделать так чтобы инфа по гороскопам подтягивалась к конкретному знаку.

//сделать кнопку CANCEL перенаправляющую на стартовую страницу без сохранения результата
//сделать свою ячейку дата рождения возвращение даты рождения если дата рождения правильная
//сделать проверку на валидность даты; начало отсчета 1900 год
//написать функции для вычисления года по китайскому календарю
//написать функцию на вычисления китайского нового года
//написать функцию на вычисление цвета и элемента года по китайскому календарю
//возвращение пароля в ячейку если он правильный а логин не правильный

$action_file = 'index.php';
$User_data = array(
  'form_name' => '',
  'login' => '',
  'email' => '',
  'first_name' => '',
  'last_name' => '',
  'gender' => '',
  'birth_date' => '',
  'password' => '',
  'confirm_password' => '');

if (!isset($_POST['submit'])) { //$_POST НЕ определен ------------------------
  // начальные установки
  $positionL = 'absolute'; // для предупреждения -- логин существует
  $visibilityL = 'hidden'; // для предупреждения -- логин существует
  $positionP = 'absolute'; // для предупреждения -- не совпадают пароли
  $visibilityP = 'hidden'; // для предупреждения -- не совпадают пароли
  HTML_head();
  HTML_form_reg($action_file, $positionL, $visibilityL, $positionP, $visibilityP, $User_data);
  echo "OR";
  HTML_form_sign_in($action_file, $positionL, $visibilityL, $positionP, $visibilityP, $User_data);

} else { //$_POST определен --------------------------------
  //echo "\$_POST определен<br>";
  //подключение БД
  require_once("mysql_login.php");
  $mysqli = new mysqli($hm, $us, $pw, $db);
  if ($mysqli->connect_error) {
    exit($mysqli->connect_error);
  }
  $mysqli->query("SET NAMES 'utf8'");
  //передача данных
  foreach ($User_data as $key => $value) { //убрал спецсимволы из входящих данных
      $User_data[$key] = $mysqli->real_escape_string(trim($_POST[$key]));
      //echo "\$User_data[$key] = {$User_data[$key]}<br>"; //результат работы
  }
  if ($User_data['form_name'] == 'register') {
    $query = "SELECT login FROM `Users` WHERE login = '{$User_data['login']}'";
    $DB_res = $mysqli->query($query); // это можно как то сократить?
    $DB_res_Arr = $DB_res->fetch_assoc();
    if ($DB_res_Arr['login'] == $User_data['login']) {
      $positionL = 'static'; // для предупреждения -- логин существует
      $visibilityL = 'visible';
    } else {
      $positionL = 'absolute';
      $visibilityL = 'hidden';
    }
    if ($User_data['password'] != $User_data['confirm_password']) {
      //$reg_err_arr['password'] = TRUE;
      $positionP = 'static'; // для предупреждения -- пароль и подтверждение не одинаковы
      $visibilityP = 'visible';
    } else {
      $positionP = 'absolute';
      $visibilityP = 'hidden';
    }
    if (($visibilityL != 'visible') && ($visibilityP != 'visible')) {
      $zodiak_sign = zodiak_sign($User_data['birth_date']); //знак зодиакак
      $query = "INSERT INTO `Users` (
      `login`,
      `email`,
      `password`,
      `first_name`,
      `last_name`,
      `gender`,
      `birth_date`,
      `zodiak_sign`
      ) VALUES (
      '{$User_data['login']}',
      '{$User_data['email']}',
      MD5('{$User_data['password']}'),
      '{$User_data['first_name']}',
      '{$User_data['last_name']}',
      '{$User_data['gender']}',
      '{$User_data['birth_date']}',
      '$zodiak_sign'
      )";
      $data = $mysqli->query($query);
      if (!$data) {
        exit($mysqli->error);
      }
      // форма с надписью вы успешно зарегистрировались со ссылкой на страницу с информацией
    } else {
      HTML_head();
      HTML_form_reg($action_file, $positionL, $visibilityL, $positionP, $visibilityP, $User_data);
    }
  } elseif ($_POST['form_name'] == 'sign in') {
    //1. найти в БД Логин и проверить пароль
    //2. если пароль верен вівести ОК
    //3. если пароль не верен форма ошибки с формулировкой неверен пароль или логин*/
  }
  $mysqli->close();
}

function HTML_head() {
  echo <<<_HEAD
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8"
        name = "description"
        content = "Знак зодиакак по дате">
        <title>Проект Zodiak</title>
        <!--<link href="/style.css" type="text/css" rel="stylesheet">-->
        <!-- не получилось поключить по -->
_HEAD;
  require('style.css'); // подключение CSS
  echo '</head><body>';
}

function HTML_form_reg($file, $posL, $visL, $posP, $visP, $Us_data) {
  echo <<<_FORM_REG
  <div class="reg_frame">
      <h1>Register</h1>
      <p> Create your account. It's free and only takes a minute </p>
      <form name="reg" action="$file" method="post" class="reg_form">
      <input name="form_name"
          type="hidden"
          value="register"
        >
        <label> Login
          <input
            name="login"
            type="text"
            placeholder="enter login"
            class="txt login"
            value="{$Us_data['login']}"
            required
          >
        </label>
        <div class="login_err err" style="position: $posL !important; visibility: $visL">
          The login is already in use
        </div><br>
        <label> Email
          <input name="email"
            type="email"
            placeholder="enter email"
            class="txt email"
            value="{$Us_data['email']}"
          >
        </label>
        <br>
        <label> First name
          <input name="first_name"
            type="text"
            placeholder="enter your first name"
            class="txt first_name"
            value="{$Us_data['first_name']}"
            required
          >
        </label>
        <br>
        <label> Last Name
          <input name="last_name"
            type="text"
            placeholder="enter your last name"
            class="txt last_name"
            value="{$Us_data['last_name']}"
          >
        </label>
        <br>
        <label> Gender
          <select name="gender"
            class="txt gender"
            value="{$Us_data['gender']}"
            required
          >
            <option selected disabled>select your gender</option>
            <option class="txt male">male</option>
            <option class="txt female">female</option>
          </select>
        </label>
        <br>
        <label> Date of Birth
          <input name="birth_date"
            type="date"
            placeholder="select birth date"
            class="txt birth date"
            required
          >
        </label>
        <br>
        <label> Password
          <input name="password"
            type="password"
            placeholder="enter password"
            class="txt password"
            value="{$Us_data['password']}"
            required
          >
        </label>
        <div class="password_err err" style="position: $posP !important; visibility: $visP">
          Enter the same password
        </div><br>
        <label> Confirm password
          <input
            name="confirm_password"
            type="password"
            placeholder="confirm password"
            class="txt confirm_password"
            value="{$Us_data['confirm_password']}"
            required
          >
        </label>
        <br>
        <input name="submit"
          type="submit"
          value="Register"
          class="txt submit"
        ><br>
      </form>
    </div>
_FORM_REG;
}

function HTML_form_sign_in($file, $posL, $visL, $posP, $visP, $Us_data) {
echo <<<_FORM_SIGN_IN
  <!-- вход для зарегистрированных -->
    <div class="sign_in_frame">
      <h1>Sign in</h1>
      <form name="sign_in" action="$file" method="post" class="sign_in">

        <label>
          <input name="form_name"
              type="hidden"
              value="sign in"
          >
        </label>
        <br>
        <label>
          <input name="login"
              type="text"
              placeholder="Enter login or email"
              class="txt login"
              required
          >
        </label>
        <br>
        <label>
          <input name="password"
            type="password"
            placeholder="Enter password"
            class="txt password"
            required
          >
        </label>
        <br>
        <input name="submit"
          type="submit"
          value="Ok"
          class="txt submit"
        >
        <br>
      </form>
    </div>
_FORM_SIGN_IN;
}

function zodiak_sign($date) {
  $day = substr($date, 5);
  //echo $day.'<br>';
  $zodiak = array(
  'start' => array(
                '01-20',
                '02-19',
                '03-21',
                '04-21',
                '05-21',
                '06-22',
                '07-23',
                '08-23',
                '09-23',
                '10-24',
                '11-23',
                '12-22',
                '01-01'),
  'end' => array(
                '02-18',
                '03-20',
                '04-20',
                '05-20',
                '06-21',
                '07-22',
                '08-22',
                '09-22',
                '10-23',
                '11-22',
                '12-21',
                '12-31',
                '01-19'),
  'sign' => array(
                'aquarius',
                'pisces',
                'aries',
                'taurus',
                'gemini',
                'cancer',
                'leo',
                'virgo',
                'libra',
                'scorpio',
                'sagittarius',
                'capricorn',
                'capricorn')
  );
  for ($i=0; $i < 13; $i++) {
    if (($day >= $zodiak['start'][$i]) && ($day <= $zodiak['end'][$i])) {
      $sign = $zodiak['sign'][$i];
      break;
    }
  }
  return $sign;
}


function china_year($date){

}

function china_newyear($date){

}

function china_year_animal($date){

}

function china_year_color_element($date){

}

?>
