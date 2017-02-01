<?php

/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 21:43
 */
class controllers_html
{

    /**
     * Функция обработки запроса на индекс сайта
     * @param $data
     * @return array
     */
    public function index($data)
    {
        return array('viewPath' => 'index');
    }
}