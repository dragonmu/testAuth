<?php
/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 19:47
 * Роутер, файл с которого начинается загрузка апи
 * раскидывает запросы
 * При желании можно сделать класс который обрабатывает запросы
 * и использует интерфейс роутеров (в случае если роутеров будет 2+)
 */
//Общие функции
require 'functions.php';
//Открываем сессию
session_start();
//Для тестирования
if (!empty($_POST['data']) && is_array($_POST['data'])) {
    $requestData = $_POST['data'];
    $jsonRouter = new classes_jsonRouter();
    $jsonRouter->response($requestData);
    //Если json получен
} else if (!empty($_POST['data']) && isJson($_POST['data'])) {
    $requestData = json_decode($_POST['data']);
    $jsonRouter = new classes_jsonRouter();
    $jsonRouter->response($requestData);
} else {
    //Обычный режим
    $htmlRouter = new classes_htmlRouter();
    $htmlRouter->response();
}