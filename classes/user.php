<?php

/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 20:22
 * Класс пользователя
 */
class classes_user
{
    public $id;
    public $login;
    public $password;
    public $firstName;

    /**
     * classes_user constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->id = isset($data['user_id']) ? $data['user_id'] : 0;
        $this->login = isset($data['user_login']) ? $data['user_login'] : '';
        $this->password = isset($data['user_password']) ? $data['user_password'] : '';
        $this->firstName = isset($data['user_firstname']) ? $data['user_firstname'] : '';
    }

    /**
     * Проверка инициализации пользователя
     * @return bool
     */
    public function isExists()
    {
        return $this->id > 0;
    }
}