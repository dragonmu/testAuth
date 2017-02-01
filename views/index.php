<?php
/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 21:34
 */
?>
<div>
    <? if (classes_factory_user::a()->getAuthed()->isExists()) { ?>
        <div>
            <font size="16" color="green">Вы авторизованы
                как: <?= classes_factory_user::a()->getAuthed()->login ?></font>
        </div>
    <? } ?>
    Формы для отправки тестовых запросов
    <form method="post">
        <label>Форма регистрации</label>
        <div>
            <label>Логин</label>
            <input type="text" name="data[login]"/>
        </div>
        <div>
            <label>Пароль</label>
            <input type="text" name="data[password]"/>
        </div>
        <div>
            <label>Имя</label>
            <input type="text" name="data[firstname]"/>
        </div>
        <button onclick="postAjax('/user/add/', document.forms[0], showResult);return false">Отправить</button>
    </form>

    <form method="post">
        <label>Форма авторизации (После авторизации надо обновить страницу)</label>
        <div>
            <label>Логин</label>
            <input type="text" name="data[login]"/>
        </div>
        <div>
            <label>Пароль</label>
            <input type="text" name="data[password]"/>
        </div>
        <button onclick="postAjax('/user/auth/', document.forms[1], showResult);return false">Отправить</button>
    </form>
    Результат
    <div id="result">

    </div>
</div>
