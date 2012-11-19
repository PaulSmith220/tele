  <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<?php
$num = htmlspecialchars($_POST['num']);
 $filename = date("Y_m_d_h_i")."_".($_FILES['file']['name']);
 
  $max_filesize = 2097152; // Максимальный размер файла в БАЙТАХ.
     $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.pdf','.PDF'); 
// Это будут виды файлов, которые пройдут валидацию.
    $ext =( substr($filename, strpos($filename,'.'), strlen($filename)-1)); // Получаем расширение имени файла.
       if(in_array($ext,$allowed_filetypes)){
    if($_FILES['file']['size'] <=  $max_filesize){
    
$dir = '../upload/files/';

      ;
 if (move_uploaded_file($_FILES['file']['tmp_name'],$dir.$filename )){
      $op = 1;
            resize($filename);
      } else {
       $op = "Ошибка загрузки";
      }
    
      } else {
         $op = "Размер файла превышает 2Мб"; 
         unlink($filename);
      }
       } else{
           $op = "Запрещеный формат файла"; 
           unlink($filename);
       }

       
       
       
       
       
       
       
       
       
  function resize($f){
    
            $ext = substr($f, strpos($f,'.'), strlen($f)-1);    
           $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.bmp','.BMP');
       if(in_array($ext,$allowed_filetypes)) {
      
         $ff='../upload/files/'.$f;
         require_once 'ac_image_class.php';
         $img = new acResizeImage($ff);
         list($w,$h) = getimagesize($ff);
         if ($w>800)
          $img->resize(800, 800);
          $img->save('../upload/files/', $f, 'jpg', true, 100);
          
           $imgt = new acResizeImage($ff);
           $imgt->thumbnail(32, 32, 1);
           $imgt->save('../upload/thumbs/', $f.'_thumb', 'jpg', true, 100);
          unlink($ff);
          
  
       }    
           
           }     
       
       
       
?>
  
  <script type='text/javascript' >
 
window.parent.$('#r').html('<?php echo $op ?>');
window.parent.$('#r').attr('title','<?php echo $num ?>');
window.parent.$('#r').attr('fname','<?php echo iconv('windows-1251','utf-8',$filename) ?>');
window.parent.$('#r').click();
    //   window.parent.$('.myload').remove();
    window.parent.$('.myload').attr('src','/public/frames/iframe.html');

</script> 

