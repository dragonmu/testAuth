<?php

/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 20:13
 * Класс работает с базой и создает классы пользователей
 * Обычная фабрика или маппер (может быть расширен до фабрики, путем добавления интерфейса
 * пользователя и нескольких разных классов пользователей)
 */
class classes_factory_user
{
    static $_instance = null;
    private $_authedUser = null;

    /**
     * сингл тон
     * @return classes_factory_user
     */
    static function a()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new classes_factory_user();
        }
        return self::$_instance;
    }

    /**
     * Возвращает авторизованного пользователя
     * @return classes_user
     */
    public function getAuthed()
    {
        if (is_null($this->_authedUser)) {
            //Ищем авторизацию в куках
            if (!empty($_COOKIE['id']) && !empty($_COOKIE['hash']) && is_int((int)$_COOKIE['id'])) {
                $checkUser = $this->getById((int)$_COOKIE['id']);
                if ($_COOKIE['hash'] == $checkUser->password) {
                    $this->_authedUser = $checkUser;
                }
            }
            //Ищем авторизацию в сессии
            if (!empty($_SESSION['id']) && !empty($_SESSION['hash']) && is_int((int)$_SESSION['id'])) {
                $checkUser = $this->getById((int)$_SESSION['id']);
                if ($_SESSION['hash'] == $checkUser->password) {
                    $this->_authedUser = $checkUser;
                }
            }
        }
        //Если пользователь все еще пустой, то он не авторизован
        if (is_null($this->_authedUser)) {
            $this->_authedUser = $this->getClass();
        }
        return $this->_authedUser;
    }

    /**
     * Получение пользователю по логину
     * @param $login
     * @return classes_user
     */
    public function getByLogin($login)
    {
        $row = classes_sql::a()->getRow('SELECT * FROM `user` WHERE `user_login`=?s'
            , $login);
        return $this->getClass($row);
    }

    /**
     * Возвращает пользователя по id
     * @param $id
     * @return classes_user
     */
    public function getById($id)
    {
        $row = classes_sql::a()->getRow('SELECT * FROM `user` WHERE `user_id`=?i'
            , $id);
        return $this->getClass($row);
    }

    /**
     * Создает пользователя и возращает созданного пользователя
     * @param $data
     * @return classes_user
     */
    public function insert($data)
    {
        $result = classes_sql::a()->query('INSERT INTO `user` (`user_login`,`user_password`,`user_firstname`) VALUES (?s,?s,?s)'
            , $data['login']
            , $data['password']
            , $data['firstname']);
        if ($result) {
            return $this->getById(classes_sql::a()->insertId());
        }
        return $this->getClass();
    }

    public function getClass($row = array())
    {
        return new classes_user($row);
    }
}