<?php

/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 20:32
 */
class classes_jsonRouter
{
    /**
     * Список запросов на которые роутер может подготовить ответ
     * У меня были сомнения по поводу проверки url, но вроде программисты говорили
     * что запросы идут на адресса и апи REST структура
     * @var array
     */
    private $_routes = array(
        '/user/auth/' => array(
            'checkData' => array('login', 'password')
        , 'controller' => 'controllers_user'
        , 'action' => 'auth'),
        '/user/add/' => array(
            'checkData' => array('login', 'password', 'firstname')
        , 'controller' => 'controllers_user'
        , 'action' => 'create')
    );

    /**
     * Функция формирует ответ в формате json
     * @param $requestData данные из запроса
     */
    public function response($requestData)
    {
        //Пытаемся найти запрашиваемый адресс
        if (isset($this->_routes[$_SERVER['DOCUMENT_URI']])) {
            $route = $this->_routes[$_SERVER['DOCUMENT_URI']];
            //Проверяем полученные данные
            if ($this->checkData($requestData, $route['checkData'])) {
                //Создаем контроллер
                $controller = new $route['controller'];
                //Выполняем функцию и возвращаем результат
                $this->responseJson($controller->{$route['action']}($requestData));
            } else {
                $this->responseJson(array("success" => "error", "data" => array("errorText" => 'Не достаточно данных')));
            }
        }
        //Тут как удобнее, можно и просто 404 код ответа вернуть
        $this->responseJson(array("success" => "error", "data" => array("errorText" => '404')));
    }

    /**
     * Проверяет на наличие ключей в массиве/ наличие необходимых данных
     * Если все ключи присутствуют возвращает true
     * @param $dataForCheck данные которые мы проверяем
     * @param $checkData список необходимых ключей
     * @return bool
     */
    public function checkData($dataForCheck, $checkData)
    {
        foreach ($checkData as $checkKey) {
            if (!isset($dataForCheck[$checkKey])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Функция выводи json и заканчивает выполнение скрипта
     * @param $responseArray
     */
    public function responseJson($responseArray)
    {
        echo json_encode($responseArray);
        die();
    }
}