взято с https://ruseo.net/parser-vebarhiva-t16092.html

Допилил парсер чтобы восстанавливать заброшенные сайты из вебархива.

Файл webarchive.php
У него в 1й строке вставляем ссылку на "копию главной в вебархиве".

И можно запускать...
Если в браузере получаете ошибку по тайм-ауту (выполняться то будет долго) запускайте через терминал.
переходим в каталог с файлом командой cd
Запускаем... На линухе командой php webarchive.php (как на винде - погуглите).

Это значит, идет сбор ссылок с главной страницы.
ONE=118

Количество ссылок на главной.

Далее скрипт проходит по всем (внутрисайтовым) ссылкам с главной.
###
#2#
###

Это значит, пошло посещение внутренних страниц... Процесс может быть до-о-олгим...

TWO=426

Это значит, что на сайте найдено 426 страниц расположенных в двух кликах от главной.


CRASHED=12

Отчет о количестве неоткрывшихся (по разным причинам) страниц.

На выхлопе получаете 2 файла:
site-map.txt со всеми страницами на сайте
crashed-map.txt со списком страниц, которые есть и не смогли быть открыты

Битые страницы можете попытаться открыть руками в браузере и посмотреть в чем отстой.

- - - -

Переходим к файлу rider.php который занимается скачиванием страниц

В 1 строке путь на все ту же главную сайта в веб-архиве.
2 строка - имя файла, из которого брать список ссылок
3 строка - как обозвать файлы: 'name' или 'number' под именами или номерами (под номерами удобнее, если вас интересуют статьи а не сайт целиком).

Файлы сохраняются в папку out (создайте её руками перед запуском).
