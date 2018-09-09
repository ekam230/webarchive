<?php
$way=''; //ссылка на главную в вебархиве
$all=file('site-map.txt'); //из какого файла брать сипсок
$save='name'; //'name' или 'number' под именами или номерами

$all=preg_replace("#\r\n#",null,$all);
$all=preg_replace("#\n\r#",null,$all);
$all=preg_replace("#\n#",null,$all);

$count_gets=count($all);
echo '0/'.$count_gets."_START\n";
foreach($all as $key => $all){
   $all=preg_replace("#\n\r#",null,$all);$all=preg_replace("#\r\n#",null,$all);$all=preg_replace("#\n#",null,$all);
   if(@$get_page=file_get_contents($way.$all))
   {
      $name=preg_replace("#(.*)/#",null,$all);
      if($save=='name'){
         file_put_contents('out/'.$name,$get_page);
      }
      if($save=='number'){
         file_put_contents('out/'.$key,$get_page);
      }
      echo $key.'/'.$count_gets."_ok\n";
   }else{
      $not_get[]=$way.$all;
      echo $key.'/'.$count_gets."_fail\n";
      continue;
   }
}
file_put_contents('out/index',file_get_contents($way));
echo 'Errors='.count($not_get)."\n";
?>