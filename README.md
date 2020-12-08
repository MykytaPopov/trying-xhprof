To start project docker should be installed.

Read how to [start docker environment](docker/README.md)

As soon as environment is started visit test-ezlogz.local and follow
generated link to see profiled data.

----

### Задача

Найти оптимальный вариант получения расхождений двух наборов
данных полученных в формате JSON.

### Исходные

Проверка проводилась с использованием утилиты `xhprof`.
Сравнивались 2 объекта `JSON`: 1й 10к параметров, 2й 9750 параметров.

Для получения расхождений `JSON` объекты были приведены к массивам т.к.
в случае приведения к `stdObject` для их сравнения пришлось бы использовать
дорогую в использовании рефлексию, данный вариант даже не рассматривался.

### Результаты

Для получения расхождений в двух массивах считаю оптимальным использовать
встроенные функции PHP. Использование таких функций как `array_diff_key` и
`array_diff_assoc` показало выигрыш во времени исполнения кода примерно на
`25%` в сравнении с использованием циклов.

Однако есть оговорка, если есть какое-то специфическое условие для
нахождения расхождений, например должны быть проверены даже типы, в таком
случае более рационально будет использование циклов. Функция 
`array_diff_assoc` - не подходит так, как функция приводит значения
к `string` по этому такое сравнение нельзя считать в полной мере строгим.
Использование `array_udiff_assoc` с использованием `callback` не
рационально, время исполнения кода увеличивается в десятки раз
относительно циклов.

Таким образом в зависимости от задачи есть два подходящих способа получения
расхождений массивов:
1. встроенные функции php - быстро, но значения приводятся к строке
2. циклы - когда нужна абсолютная строгость(проверяются даже типы)