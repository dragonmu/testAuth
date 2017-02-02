<?php

/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 21:16
 */
class classes_htmlRouter
{
    public $template = 'default';
    /**
     * Список запросов на которые роутер может подготовить ответ
     * У меня были сомнения по поводу проверки url, но вроде программисты говорили
     * что запросы идут на адресса и апи REST структура
     * @var array
     */
    private $_routes = array(
        '/' => array(
            'controller' => 'controllers_html'
        , 'action' => 'index')
    );

    /**
     * Функция формирует ответ в формате HTML
     * @param $requestData данные из запроса
     */
    public function response($requestData = array())
    {
        //Пытаемся найти запрашиваемый адресс
        if (isset($this->_routes[$_SERVER['DOCUMENT_URI']])) {
            $route = $this->_routes[$_SERVER['DOCUMENT_URI']];
            //Создаем контроллер
            $controller = new $route['controller'];
            //Выполняем функцию и возвращаем результат
            $this->responseHtml($controller->{$route['action']}($requestData));
        }
        //Тут как удобнее, можно и просто 404 код ответа вернуть
        $this->responseHtml(array("viewPath" => '404'));
    }

    /**
     * Функция выводит HTML страницу и заканчивает выполнение скрипта
     * @param $responseArray
     */
    public function responseHtml($data)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/views/template/' . $this->template . '/header.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/views/' . $data['viewPath'] . '.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/views/template/' . $this->template . '/footer.php';
        die();
    }
}
