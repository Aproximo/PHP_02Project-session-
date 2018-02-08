<?php
include('./Parser.php');
include('./DB.php');



$develop = new Parser("https://habrahabr.ru/flows/develop/");//1
$dev = $develop->getItem();
set_to_db($dev, 1);

$admin = new Parser("https://habrahabr.ru/flows/admin/"); //3
$adm = $admin->getItem();
set_to_db($adm, 3);

$design = new Parser("https://habrahabr.ru/flows/design/");//4
$des = $design->getItem();
set_to_db($des, 4);

$managment = new Parser("https://habrahabr.ru/flows/management/");//7
$man = $managment->getItem();
set_to_db($man, 7);

$marketing = new Parser("https://habrahabr.ru/flows/marketing/");//8
$mark = $marketing->getItem();
set_to_db($mark, 8);






function set_to_db ($array, $id){
    $DB = new DB;
   
    foreach ($array as $value) {  
   
        $select = $DB->select($value['article_id']);
        if ($select){
            $newtext = hash('md5', $value['full_text']);
            $oldtext = hash ('md5', $select['full_text']);

            $newt = hash('md5', $value['title']);
            $oldt = hash ('md5', $select['title']);
          
                if ($newtext != $oldtext || $newt != $oldt){
                    $DB->update($value);                    
                }

        } else {

            $DB->insert($value, $id);
        }
    }
}