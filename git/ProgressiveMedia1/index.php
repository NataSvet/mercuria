<!DOCTYPE html>
<html dir="ltr" lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Тестовое задание</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body class="body">
<main>
    <div class="container">

<?php

    if (preg_match("/^(?:\d[-.?!)(,: ]?)+$/", $_POST['set1']) && preg_match("/^(?:\d[-.?!)(,: ]?)+$/", $_POST['set2'])) {
        $set1 = preg_split("/[\s-.?!)(,:]+/", $_POST['set1']);
        $set2 = preg_split("/[\s-.?!)(,:]+/", $_POST['set2']);
        echo ("Количество элементов подмножества set1 = ".count($set1) ."</br>");
        echo ("Количество элементов подмножества set2 = ".count($set2)."</br>");
        //////////////2
        if($_POST['sort']=="По возрастанию"){
            $sortSet1=$set1;
            sort($sortSet1);
            print_mass($sortSet1,"Сортировка  ".$_POST['sort']);
            $sortSet2=$set2;
            sort($sortSet2);
            print_mass($sortSet2,"Сортировка  ".$_POST['sort']);

        }else{
            $sortSet1=$set1;
            rsort($sortSet1);
            print_mass($sortSet1,"Сортировка  ".$_POST['sort']);
            $sortSet2=$set2;
            rsort($sortSet2);
            print_mass($sortSet2,"Сортировка  ".$_POST['sort']);
        }
        /////////////3
        echo "Минимум set1 = ". min($set1)."</br>";
        echo "Минимум set2 = ". min($set2)."</br>";
        echo "Максимум set1 = ". max($set1)."</br>";
        echo "Максимум set2 = ". max($set2)."</br>";
        ///////////4
        $arrayСonvergences = array_intersect($set1, $set2);
        print_mass($arrayСonvergences,"Пересечение множеств");
        //////////5
        $arrayMinus = array_diff($set1, $set2);
        print_mass($arrayMinus,"Разница множеств");
        /////////6
        rsort($sortSet1);
        print_mass($sortSet1,"В обратном порядке set1 = ");
        ////////7
        echo "Произведение set2 = ".array_product($set2)."</br>";
        ////////8
         shuffle($set1);
        print_mass($set1,"Значения множества set1 перемешанные в случайном порядке = ");
    }

    function print_mass($mass,$description){
        $string="";
        foreach ($mass as  $val) {
            $string.=" ".$val;
        }
        $string.="</br>";
        echo ($description." ".$string);
    }

?>
<form   method="Post" name="form" class="form">
    <p class="alert">Введите числа, разделите их пробелами или знаками препинания</p>
    <label class="label">Первое множество</label>
    <input class="input" name="set1" value="" required >
    <label class="label">Второе множество</label>
    <input class="input" name="set2" value="" required >
    <select class="select" name="sort">
        <option>По возрастанию</option>
        <option>По убыванию</option>
    </select>
<button class="button"  name= "button" type="submit">Отправить</button>
 </form>
    </div>
</main>
</body>
</html>
