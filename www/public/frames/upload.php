<?php  

   $max_filesize = 2097152; // Максимальный размер файла в БАЙТАХ.
     $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.bmp','.BMP','.zip','.ZIP','.rar','.RAR'); // Это будут виды файлов, которые пройдут валидацию.
     $filename = date('dmy_his')."_".$_FILES['userfile']['name']; // Получаем название файла (включая его расширение).
         $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Получаем расширение имени файла.
     $file_strip = str_replace(" ","_",$filename); //Замещаем пробелы в названии файла
     $upload_path = '../upload/'; //Устанавливаем путь выгрузки  

     // Проверяем, разрешен ли вид файла, если нет - DIE и информируем пользователя.
    if(!in_array($ext,$allowed_filetypes)) {
            die('<div class="error"> Загружаемый тип файла недопустим.</div>');
    }
   // Теперь проверяем размер файла, если он слишком большой, то DIE и информируем пользователя.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize) {
      die('<div class="error"> Загружаемы файл слишком большой.</div>');
    }
   // Проверяем, можно ли выгрузить в определенный путь, если нет, то DIE и информируем пользователя.
   if(!is_writable($upload_path)) {
      die('<div class="error"> Вы не можете загружать в папку /uploads/. Измените права на папку.</div>');
	    }
     // Перемещаем файл, если он прошел все проверки.
     if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $file_strip)) {
      echo '<div class="success"><div id="fname">'. $file_strip .'</div> Файл успешно загружен. </div>>'; // Получилось.
    } else {
      echo '<div class="error">'. $file_strip .' Файл не загружен. Попробуйте позже.</div>'; // Не получилось <img src="http://webformyself.com/wp-includes/images/smilies/icon_sad.gif" alt=":(" class="wp-smiley"> .
 }
?>
<style>
    .error{
        font-weight:bold;
        color:red;
    }
    .success{
        font-weight:bold;
        color:green;
    }
    </style>