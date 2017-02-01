<?php

/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 20:07
 * Контролер отвечает за обработку запросов касающихся пользователей
 */
class controllers_user
{
    /**
     * Функция создания нового пользователя
     * @param $data
     * @return array
     */
    public function create($data)
    {
        //Тут проверяем данные, как удобнее можно регулярками, можно filter_var
        //я писать валидацию не стал
        //Еще пароль хранится не в открытом виде, а ввиде некого хеша (md5('asfasdfasdf'+md5($data['password']))), как удобнее
        $checkUserLogin = classes_factory_user::a()->getByLogin($data['login']);
        if (!$checkUserLogin->isExists()) {
            $newUser = classes_factory_user::a()->insert($data);
            if ($newUser->isExists()) {
                return array('status' => 'success', 'userId' => $newUser->id);
            }
        } else {
            return array('status' => 'error', 'errorText' => 'Пользователь с таким login уже существует');
        }
        return array('status' => 'error', 'errorText' => 'Ошибка с бд');
    }

    /**
     * Функция авторизации пользователя
     * @param $data
     * @return array
     */
    public function auth($data)
    {
        $checkUserAuth = classes_factory_user::a()->getByLogin($data['login']);
        //Сравниваем хеши паролей
        if ($checkUserAuth->isExists() && $checkUserAuth->password === $data['password']) {
            //Я оба варианта сделал в 1 месте, они особо и не отличаются по смыслу

            //Проставляем куку
            setcookie("id", $checkUserAuth->id, time() + 60 * 60 * 24 * 30, '/');
            //Стоит напомнить что мы кладем в куку не сам пароль а HASH пароля
            setcookie("hash", $checkUserAuth->password, time() + 60 * 60 * 24 * 30, '/');
            //Такая же авторизации как и по кукам, но по сессии
            $_SESSION['id'] = $checkUserAuth->id;
            $_SESSION['hash'] = $checkUserAuth->password;
            return array('status' => 'success', 'userId' => $checkUserAuth->id);
        }
        return array('status' => 'error', 'errorText' => 'Не правильный пароль');
    }
}