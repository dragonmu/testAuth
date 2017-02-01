<?php
/**
 * User: Тандит Виктор
 * Date: 01.02.2017
 * Time: 21:35
 */
?>
<html>
<head>
    <meta charset="utf-8"/>
    <script>
        //Скрипт взял из примера в интернете
        function createXMLHttp() {
            if (typeof XMLHttpRequest != "undefined") { // для браузеров аля Mozilla
                return new XMLHttpRequest();
            } else if (window.ActiveXObject) { // для Internet Explorer (all versions)
                var aVersions = [
                    "MSXML2.XMLHttp.5.0",
                    "MSXML2.XMLHttp.4.0",
                    "MSXML2.XMLHttp.3.0",
                    "MSXML2.XMLHttp",
                    "Microsoft.XMLHttp"
                ];
                for (var i = 0; i < aVersions.length; i++) {
                    try {
                        var oXmlHttp = new ActiveXObject(aVersions[i]);
                        return oXmlHttp;
                    } catch (oError) {
                    }
                }
                throw new Error("Невозможно создать объект XMLHttp.");
            }
        }
        // фукнция Автоматической упаковки формы любой сложности
        function getRequestBody(oForm) {
            var aParams = new Array();
            for (var i = 0; i < oForm.elements.length; i++) {
                var sParam = encodeURIComponent(oForm.elements[i].name);
                sParam += "=";
                sParam += encodeURIComponent(oForm.elements[i].value);
                aParams.push(sParam);
            }
            return aParams.join("&");
        }
        // функция Ajax POST
        function postAjax(url, oForm, callback) {
            // создаем Объект
            var oXmlHttp = createXMLHttp();
            // получение данных с формы
            var sBody = getRequestBody(oForm);
            // подготовка, объявление заголовков
            oXmlHttp.open("POST", url, true);
            oXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // описание функции, которая будет вызвана, когда придет ответ от сервера
            oXmlHttp.onreadystatechange = function () {
                if (oXmlHttp.readyState == 4) {
                    if (oXmlHttp.status == 200) {
                        callback(oXmlHttp.responseText);
                    } else {
                        callback('error' + oXmlHttp.statusText);
                    }
                }
            };
            // отправка запроса, sBody - строка данных с формы
            oXmlHttp.send(sBody);
        }


        function showResult(d) {
            var obj = JSON.parse(d)
            d = d + '<br/><div>Данные в читаемом формате</div>';
            for (var key in obj) {
                d = d + '<div>' + key + ':' + obj[key] + '</div>';
            }
            document.getElementById('result').innerHTML = d;
        }
    </script>
</head>
<body>

