<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>   
<script>
        window.parent.$('#loading').hide();
        </script>
        <style>
    .error{
        font-weight:bold;
        color:red;
         font-size: 50%;
    }
    .success{
        font-weight:bold;
        color:green;
        font-size: 50%;
        padding:5px;
        border:1px solid grey;
        border-radius:2px;
    }
 
    </style>
<div id="fnamebox" style="display:none;">></div>
<?php  
    $filename = array();$i=-1;
    $file_strip = array();
    $upload_path=array();
   $max_filesize = 2097152; // Максимальный размер файла в БАЙТАХ.
     $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.pdf','.PDF'); // Это будут виды файлов, которые пройдут валидацию.
     foreach($_FILES['userfile']['name'] as $f){
       $i++;
     $filename[$i] = date('d-m-y_h-i-s')."_".iconv('utf-8','windows-1251',$f); // Получаем название файла (включая его расширение).
         $ext = substr($filename[$i], strpos($filename[$i],'.'), strlen($filename[$i])-1); // Получаем расширение имени файла.
     $file_strip[$i] = str_replace(" ","_",$filename[$i]); //Замещаем пробелы в названии файла
     $upload_path[$i] = '../upload/'; //Устанавливаем путь выгрузки  
     if (($ext=='.pdf' )|| ($ext=='.PDF')) {$upload_path[$i] = '../upload_pdf/';}
     // Проверяем, разрешен ли вид файла, если нет - DIE и информируем пользователя.
    if(!in_array($ext,$allowed_filetypes)) {
            die('<div class="error"> Некоторые файлы имеют недопустимый тип.<br> Разрешены только файлы изображений и pdf-документы.</div>');
    }
     }
     
   // Теперь проверяем размер файла, если он слишком большой, то DIE и информируем пользователя.
      foreach($_FILES['userfile']['tmp_name'] as $f){
   if(filesize($f) > $max_filesize) {
      die('<div class="error"> Загружаемый файл слишком большой.</div>');
    
    
     }
      }
   // Проверяем, можно ли выгрузить в определенный путь, если нет, то DIE и информируем пользователя.
 
     // Перемещаем файл, если он прошел все проверки.
            $i=-1;
                foreach($_FILES['userfile']['tmp_name'] as $f){
                    $i++;
                
     if(move_uploaded_file($f,$upload_path[$i] . $file_strip[$i])) {
      echo '<div class="success">'.iconv('windows-1251','utf-8',$file_strip[$i]) .' Файл успешно загружен. </div>'; // Получилось.
      echo '<script type="text/javascript">$("#fnamebox").append("|'.iconv('windows-1251','utf-8',$file_strip[$i]).'"); </script>';
      resize($file_strip[$i]);
    } else {
      echo '<div class="error">'. $file_strip[$i] .' Файл не загружен. Попробуйте позже.</div>'; // Не получилось <img src="http://webformyself.com/wp-includes/images/smilies/icon_sad.gif" alt=":(" class="wp-smiley"> .
 }
                }
                
                
        function resize($f){
           $ext = substr($f, strpos($f,'.'), strlen($f)-1);    
           $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.bmp','.BMP');
       if(in_array($ext,$allowed_filetypes)) {
         
         $ff='../upload/'.$f;
         require_once 'ac_image_class.php';
         $img = new acResizeImage($ff);
         list($w,$h) = getimagesize($ff);
         if ($w>800)
          $img->resize(800, 800);
          $img->save('../upload/', $f, 'jpg', true, 100);
          
           $imgt = new acResizeImage($ff);
           $imgt->thumbnail(32, 32, 1);
           $imgt->save('../upload/', $f.'_thumb', 'jpg', true, 100);
          unlink($ff);
          
    }
           
           
           }
?>
