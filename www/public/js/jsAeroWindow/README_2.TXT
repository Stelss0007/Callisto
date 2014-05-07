Основные функциональные возможности:

    * Использование кнопок: Свернуть, Развернуть и Закрыть
    * Особая функция: анимация в виде глянцевидных блестяшек при перемещении окна;
    * Поддержка двойного клика по окну (анимированное развёртывание окна);
    * Бесконечно раздвижное окно;
    * Визуальная подсветка активного окна;
    * Анимированное изменение размера окна;
    * Перемещение окна с помощью мыши;
    * Управление наложениями окон друг на друга (Z-order management);
    * Множество других настроек.


Имеется возможность задать следующие параметры:

    * Заголовок окна;
    * Начальная позиция окна в координатах X и Y (предусмотрена возможность центрирования);
    * Стандартный размер Окна;
    * Минимальный размер окна;
    * Состояние открытого окна (свернутое, максимальный размер, нормальное);
    * Настройка анимации окна;
    * Генерация окон по событиям мыши и вызовам функций Javascript.


Примеры:
Простое описания окна AeroWindow:
$ ('#YourContainerDiv').AeroWindow((WindowTitle: 'My first very cool Aero Window for Web',));

Особые свойства окна могут быть легко заданы:
$ ('# YourContainerDiv').AeroWindow((WindowTitle:'My first very cool Aero Window for Web', WindowPositionTop: 'center', WindowPositionLeft: 'center', WindowWidth: 400, WindowHeight: 100, Window Animation: 'easeOutCubic' WindowResizable: true, WindowDraggable: true WindowMinimize: true, WindowMaximize : false, WindowClosable: true));

Проверена совместимость со следующими браузерами: Internet Explorer 6, Internet Explorer 7, Internet Explorer 8, Mozilla Firefox 3, Google Chrome 4, Apple Safari 4, Opera 10.
Текущая версия 2.0, базирующуюся на jQuery v1.4.2.