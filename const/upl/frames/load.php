  <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<?php
$num = htmlspecialchars($_POST['num']);
 $filename = date("Y_m_d_h_i")."_".iconv('utf-8','windows-1251',$_FILES['file']['name']);
 
  $max_filesize = 2097152; // Максимальный размер файла в БАЙТАХ.
     $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.pdf','.PDF'); 
// Это будут виды файлов, которые пройдут валидацию.
    $ext =( substr($filename, strpos($filename,'.'), strlen($filename)-1)); // Получаем расширение имени файла.
       if(in_array($ext,$allowed_filetypes)){
    if($_FILES['file']['size'] <=  $max_filesize){
    
$dir = 'upload/';

      ;
 if (move_uploaded_file($_FILES['file']['tmp_name'],$dir.$filename )){
      $op = 1;
      
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

?>
  
  <script type='text/javascript' >
 
window.parent.$('#r').html('<?php echo $op ?>');
window.parent.$('#r').attr('title','<?php echo $num ?>');
window.parent.$('#r').attr('fname','<?php echo $filename ?>');
window.parent.$('#r').click();
    //   window.parent.$('.myload').remove();
    window.parent.$('.myload').attr('src','frames/iframe.html');

</script> 