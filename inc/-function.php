<?php
function personel($sutun,$id){
  global $db;

  $e = $db->get_row("SELECT ".$sutun." FROM admin where admin_id='".$id."'");
  return $e->$sutun;

}


function ozel_yetki_sor($aranan){
    $par= explode(",", $_SESSION["extra_yetki"]);

    if(!in_array($aranan, $par)){$x=0; }else{ $x=1; }
    
    return $x;
}



function sipdurumu($id){
  global $db;
  $e = $db->get_row("SELECT name FROM siparis_durumlari where durum_id='".(int)$id."' ");
  if($e){
    echo $e->name;
  }
}
function sipdurumurenk($id){
  global $db;
  $e = $db->get_row("SELECT renk FROM siparis_durumlari where durum_id='".(int)$id."' ");
  if($e){
    return $e->renk;
  }
}



function  filler ($text){
     $gelenkod = array("<",">","location","refresh","script","frame","\\n","(",")","-"," ");
     $degis = array(" "," ","","","","","<br>","","","","");
     
     $yeni = str_replace($gelenkod,$degis,$text);
     return $yeni;
}


function g ($get) {
   return htmlspecialchars(mysql_real_escape_string($_GET[$get]));
}


function alert_yes($text){
   echo '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               '.$text.'
              </div>';
}



function update_array($tablo,$dizi,$where){
  global $db;

$d= array();

foreach ($dizi as $key => $value) {
   
     $d[]= $key."='".mysql_real_escape_string($value)."' ";
}

$e  = $db->query("UPDATE ".$tablo." SET ".implode(",", $d)." WHERE ".$where." ");
if($e){return "1";}else{ return "0";}

//print_r($d);
echo $where;

}



function insert_array($tablo,$dizi) {
          global $db;
      
          $sutunlar=array_keys($dizi);
          $degerleri=array_values($dizi);
          $sutun=implode(',',$sutunlar);
          $deger=implode('\',\'',$degerleri);
        
    
       return  $db->query('INSERT INTO '.$tablo.' ('.$sutun.') VALUES (\''.$deger.'\')') or $this->hata($tablo.' Tablosuna Dizi Aktarılırken Hata Oluştu<hr>Hatalı Cümlecik : ... ->insert_array(\''.$tablo.'\',..... ');
          
      }



function alert_no($text){
   echo '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$text.'
              </div>';
}


function tts($t){
        return mysql_real_escape_string(strip_tags($t));
}


function p ($post, $html = false) {
   if ( is_array($_POST[$post]) ){
      return array_map('mysql_real_escape_string strip_tags', $_POST[$post]);
   }else {
      if ( $html ){
         return mysql_real_escape_string(trim( $_POST[$post] ));
      }else {
         return htmlspecialchars(trim($_POST[$post]));
      }
   }
}


function cls_count($tablo,$where){
   global $db;

   

   $e = $db->get_var("SELECT count(*) FROM ".$tablo."  WHERE ".$where."  ");
   return $e;
}



function cls_row($tablo,$where){
   global $db;

   $e = $db->get_row("SELECT * FROM ".$tablo."  WHERE ".$where."  ");
   return $e;
}





function oturum_koru(){

   if(  empty($_SESSION["admin_id"]) 
      OR  empty($_SESSION["admin_name"]) 
      OR empty($_SESSION["admin_time"]) 
      OR empty($_SESSION["admin_login"])
     ){

     header("Location:signin.php");
 }

}





function log_save($siparis_id,$case){

  global $db;

  $all  = $db->get_row("SELECT * FROM siparisler where siparis_id='".$siparis_id."' ");

  $start = $all->siparis_durumu;
  $stop  =$case;


  $sql["siparis_id"]=$siparis_id;
  $sql["start_case"]=$start;
  $sql["stop_case"]=$stop;
  $sql["personel"]=$_SESSION["admin_id"];
  $sql["ip_addres"]=$_SERVER['REMOTE_ADDR'];
  $ekle= insert_array("action_log",$sql);

}



function yorum_kaydet($sipno,$yorum,$islem){
  global $db;

  $sql["siparis_id"] = $sipno;
  $sql["personel_id"] = $_SESSION["admin_id"];
  $sql["siparis_notu"] = $yorum;
  $sql["islem"] = $islem;

  if(!empty($sipno) AND  !empty($yorum)){
    $ekle = insert_array("siparis_notlari",$sql);
  }

}


?>