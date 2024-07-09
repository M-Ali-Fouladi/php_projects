<?php
include 'bool.php';
require_once ($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$phpdate=date("Y-m-d");
$phpdate=str_replace("-","",$phpdate);
global $wpdb; 
$myrows = $wpdb->get_results("SELECT  * FROM $wpdb->posts INNER JOIN"
                            ." $wpdb->postmeta ON wp_posts.ID = wp_postmeta.post_id"
                            ." where wp_posts.post_type='product' and"
                            ." REPLACE(SUBSTR(wp_posts.post_modified,1,10),'-','')"
                            ."<> $phpdate and"
                            ." wp_postmeta.meta_key='_scrape_original_url'"
                            ." LIMIT 10");
                   if ($wpdb->last_error) {
  echo 'You done bad! ' . $wpdb->last_error;
}     
$inc=0;
$count_null=0;
$func = new functions();
       foreach ($myrows as $item) 
        {
            $url= base64_decode($item->meta_value);
            $urlsearch=strpos($url,'digikala');
            echo $urlsearch;
            if($urlsearch != false)
            {
            if($inc == 10) 
            break;
            if($inc <= 9)
            {
         $sqldate = str_replace("-","",(substr($item->post_modified, 0,10)));
        if($phpdate != $sqldate)//-----------check price not updated already
        {
	           $price= $func->geturl($item->meta_value);
	           $price=str_replace(",","","$price");
	           if(strlen($price)<=1)
	           {
	               $price=0;
	               $count_null+=1;
	           }
              global $wpdb; 
$update_query = $wpdb->query($wpdb->prepare("UPDATE wp_posts"
                             ." INNER join wp_postmeta"
                             ." ON wp_posts.ID = wp_postmeta.post_id"
                             ." SET wp_posts.post_modified=NOW(),"
                             ." wp_posts.post_modified_gmt=NOW(),"
                             ." wp_postmeta.meta_value=$price"
                             ." WHERE wp_postmeta.post_id=".$item->post_id
                             ." and wp_postmeta.meta_key='_price'"));
                             
                           echo '-------------------'.'<br>';
                            echo 'counter =>'.$inc.'-- rows updated'."<br>";
                            echo 'post_id =>'.$item->post_id."price =>.$item->meta_value"."<br>" ;
		                    echo'null prices =>'.$count_null."<br>";
		                    echo '-------------------'.'<br>';

echo $wpdb->show_errors();
        
        }           
            }
               }
               else if($urlsearch == false)
               {
                       global $wpdb; 
$update_query_others = $wpdb->query($wpdb->prepare("UPDATE wp_posts"
                             ." INNER join wp_postmeta"
                             ." ON wp_posts.ID = wp_postmeta.post_id"
                             ." SET wp_posts.post_modified=NOW(),"
                             ." wp_posts.post_modified_gmt=NOW(),"
                             ." wp_postmeta.meta_value=0"
                             ." WHERE wp_postmeta.post_id=".$item->post_id));
                             echo $wpdb->show_errors();
                     echo '------others----------------------------'.'<br>';
                   echo $item->meta_value.'<br>';
                     echo '-------------------'.'<br>';
               }
            
    	$inc+=1;
	
        }		
?>    