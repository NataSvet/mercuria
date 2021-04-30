<?php
//При не заданных конкретно данных сделала такой запрос, в таблицы добавила первичные ключи и внешний ключ на вторую таблицу. 
$connection = new PDO('mysql:host=localhost;
dbname=database_pr_media;charset=utf8', 'root', 'root');
$statement = $connection->prepare('select  distinct  t1.config_id as group_id, t2.ip, t2.name_browser,t2.name_os, (select t1.url_with_in
from table1 as t1
 where group_id=t1.config_id
  order by  t1.datetime desc
  limit 1
) as url_desc_time, (select t1.url_on
from table1 as t1 
 where group_id=t1.config_id
  order by  t1.datetime asc
  limit 1
) as last_url_on, (select count(distinct t1.url_with_in)
from table1 as t1
 where group_id=t1.config_id
) as count_url_distinct,(select timestampdiff (minute, min(t1.datetime), max(t1.datetime)) as date
from table1 as t1
 where group_id=t1.config_id
) as time_period
from table1 as t1
inner join   table2 as t2 on t1.config_id=t2.id');
$statement->execute();
echo '<table><tr><th>id</th><th>IP-адрес</th><th>Браузер</th><th>ОС</th><th>URL с которого зашел первый раз</th><th>URL на который зашел
 последний раз</th><th>Количество просмотренных уникальных URL-адресов</th><th>Время прошедшее с первого до последнего входа(минуты)</th></tr>';
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    echo('<tr><td>' . $row['group_id'] . '</td><td>' . $row['ip'] . '</td><td>' . $row['name_browser'] . '</td><td>' . $row['name_os'] . '</td><td>' . $row['url_desc_time'] . '</td><td>' . $row['last_url_on'] . '</td><td>' . $row['count_url_distinct'] . '</td><td>' . $row['time_period'] . '</td></tr>');
}
