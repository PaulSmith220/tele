<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<link href="../css/bootstrap.css" media="screen" rel="stylesheet" type="text/css" >
<script>
        window.parent.$('#loading').hide();
        </script>
        <style>
    .error{
        font-weight:bold;
        color:red;
         font-size: 70%;
    }
    .success{
        font-weight:bold;
        color:green;
        font-size: 70%;
        padding:5px;
        border:1px solid grey;
        border-radius:2px;
    }
 
    </style>
<div id="fnamebox" style="display:none;"></div>
<?php  
    $filename = array();$i=-1;
    $file_strip = array();
    $upload_path=array();
   $max_filesize = 2097152; // Максимальный размер файла в БАЙТАХ.
     $allowed_filetypes = array('.jpg','.jpeg','.gif','.png','.PNG','.JPG','.JPEG','.GIF','.pdf','.PDF'); // Это будут виды файлов, которые пройдут валидацию.
    $f = $_FILES['userfile']['name'][0];

echo "<BR>".$f."<br>";
       $filename = date('d-m-y_h-i-s')."_". $f; // Получаем название файла (включая его расширение).
         $ext =( mb_substr($filename, strpos($filename,'.'), strlen($filename)-1)); // Получаем расширение имени файла.
     $file_strip = str_replace(" ","_",$filename); //Замещаем пробелы в названии файла
     $upload_path = '../upload/'; //Устанавливаем путь выгрузки  
     if (($ext=='.pdf' )|| ($ext=='.PDF')) {$upload_path = '../upload_pdf/';}
     // Проверяем, разрешен ли вид файла, если нет - DIE и информируем пользователя.
    if(!in_array($ext,$allowed_filetypes)) {
           echo ('<div class="error"> Некоторые файлы имеют недопустимый тип.<br> Разрешены только файлы изображений и pdf-документы.'.$ext.'</div><center><a href=123.html>Отмена</a></center>');
    
            
    }else{
        if($_FILES['userfile']['size'][0]>   $max_filesize) {
            echo '<div class="error">Размер файла превышает 2 МБ</div>';
        }else{
            
        }
        
        
        
    }