<?php

function getlink($title)
{
$data = '[{
"title":"هدست بلوتوث مدل A6S Mi Pods","link":"https://www.aparat.com/v/yRAxl/%D9%87%D8%AF%D8%B3%D8%AA_%D8%A8%D9%84%D9%88%D8%AA%D9%88%D8%AB_%D9%85%D8%AF%D9%84_A6S_Mi_Pod"},{
"title":"هدفون بی سیم اوی مدل Sports Earbuds T16","link":"https://www.aparat.com/v/OZsjC/%D9%87%D8%AF%D9%81%D9%88%D9%86_%D8%A8%DB%8C_%D8%B3%DB%8C%D9%85_%D8%A7%D9%88%DB%8C_%D9%85%D8%AF%D9%84_Sports_Earbuds_T16"},
{"title":"هدفون بی سیم  کی تی مدل H","link":"https://www.aparat.com/v/F593t/%D9%87%D8%AF%D9%81%D9%88%D9%86_%D8%A8%DB%8C_%D8%B3%DB%8C%D9%85_%DA%A9%DB%8C_%D8%AA%DB%8C_%D9%85%D8%AF%D9%84_H"},
{"title":" هدفون بی سیم مدل i20-TWS","link":"https://www.aparat.com/v/VUB6i/%D9%87%D8%AF%D9%81%D9%88%D9%86_%D8%A8%DB%8C_%D8%B3%DB%8C%D9%85_%D9%85%D8%AF%D9%84_i20-TWS"},
{"title":"هدفون سونی مدل MDR-EX255AP","link":"https://www.aparat.com/v/rt84V/%D9%87%D8%AF%D9%81%D9%88%D9%86_%D8%B3%D9%88%D9%86%DB%8C_%D9%85%D8%AF%D9%84_MDR-EX255AP"},
{"title":"شارژر همراه موری مدل PL30 ظرفیت ۳۰۰۰۰ میلی آمپر ساعت","link":"https://www.aparat.com/v/eQix0/%D8%B4%D8%A7%D8%B1%DA%98%D8%B1_%D9%87%D9%85%D8%B1%D8%A7%D9%87_%D9%85%D9%88%D8%B1%DB%8C_%D9%85%D8%AF%D9%84_PL30_%D8%B8%D8%B1%D9%81%DB%8C%D8%AA_%DB%B3%DB%B0%DB%B0%DB%B0%DB%B0_%D9%85%DB%8C%D9%84%DB%8C_%D8%A2%D9%85%D9%BE%D8%B1_%D8%B3%D8%A7%D8%B9%D8%AA"},
{"title":"reza","link":"test"}

]';

$character = json_decode($data,true);
$first="";
foreach($character as $item => $value)
   foreach($value as $key => $it)
   {
   $first.=$key.":".$it;
    }
    //echo $first;
    echo "\n";
    $pos=strpos($first,$title);
    $second= substr($first, $pos);
    $third=strstr($second, 'title', true);
    if($third=="")
    {
        $third=strstr($second, $title, false);
    }
    $four=strstr($third,'link:',false);
    $four= substr($four, 5);
    $id= substr($four, 25,5);
    $general='https://www.aparat.com/video/video/embed/videohash//vt/frame';
    $result=substr_replace( $general, $id, 51, 0 );
    if($id!="")
    {
    return $result;
    }
    else 
    {
        return null;
    }
    
    
}
  $str= base64_decode($_GET['title']);
  $converted=mb_convert_encoding($str, 'UTF-8', 'html');
  echo getlink($converted);

//echo $converted;


