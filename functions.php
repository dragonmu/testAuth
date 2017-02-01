<?php
/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 20:05
 * Файл с набором основных функций
 */

/**
 * Автозагрузка классов, в данном случае имя класса это путь к нему от ROOT
 * @param $name Имя класса
 */
function __autoload($name)
{
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('_', '/', $name) . '.php')) {
        require_once str_replace('_', '/', $name) . '.php';
    }
}

/**
 * Проверка на json с хабабра
 * @param $string
 * @return bool
 */
function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}