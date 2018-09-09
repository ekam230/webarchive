<?php
$target=''; //ссылка на главную в вебархиве, пример http://web.archive.org/web/20150315224128/http://site.ru/

set_time_limit(0);

$domain=preg_replace("#(.*)http://#",null,$target); //выделяю домен
$domain=str_replace('/',null,$domain); //выделяю домен

$way=preg_replace("#http://$domain(.*)#",null,$target); //выделяю путь (начало ссылок в вебархиве)

#функция извлекает все ссылки на странице
function extract_all_links($target,$domain){
    if(@$file=file_get_contents($target)){
        $file=preg_replace("#\r\n#",null,$file);
        $file=preg_replace("#\n\r#",null,$file);
        $file=preg_replace("#\n#",null,$file);
        if(preg_match("#Wayback Machine doesn't have that page archived.#",$file)){
            global $crashed;
            $crashed[]=$target;
            return;
        }
        #нахожу все ссылки
        preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/",$file,$matches);
        $urls=preg_replace("#(.*)http://#","http://",$matches[1]);

        #убираю из ссылок домен
        $urls=str_replace('http://'.$domain,null,$urls);
        $urls=str_replace('http://www.'.$domain,null,$urls);
        #чищу дубли и пустышки
        $urls=array_unique($urls);
        $urls=array_filter($urls);

        #убираю абсолютные ссылки, начинающиеся с домена отличного от целевого
        foreach($urls as $url){
            if( !preg_match("#http://#",$url) && !preg_match("#https://#",$url) ){
                $url=preg_replace("#^/#", null, $url); //убараю слеш в начале относительной ссылки
                $relative_urls[]=$url; //если нет ни http ни https - складываю в массив относительных ссылок
            }
        }
        
        #чищу дубли и пустышки
        $relative_urls=array_unique($relative_urls);
        $relative_urls=array_filter($relative_urls);
        
        $relative_urls=implode("\n",$relative_urls);
        return $relative_urls;
    }else{
        global $crashed;
        $crashed[]=$target;
        return;
    }
}

#первый проход
echo "\n###\n#1#\n###\n";
$site_map1=extract_all_links($target,$domain);
$index=explode("\n",$site_map1);
echo 'ONE='.count($index)."\n";
echo "\n###\n#2#\n###\n";;
foreach($index as $second){
    $site_map2[]=extract_all_links($way.'http://'.$domain.'/'.$second,$domain);
}
$site_map2=implode("\n",$site_map2);
$site_map2=explode("\n",$site_map2);
$site_map2=array_unique($site_map2);
$site_map2=array_filter($site_map2);
$index2=$site_map2;
echo 'TWO='.count($site_map2)."\n";
$end=implode("\n",$index)."\n".implode("\n",$site_map2);
$end=explode("\n",$end);
$end=array_unique($end);
$end=array_filter($end);
file_put_contents('site-map.txt',implode("\n",$end));
if(count($crashed)!=0){
    file_put_contents('crashed-map.txt',implode("\n",$crashed));
}
echo 'CRASHED='.count($crashed)."\n";
?>