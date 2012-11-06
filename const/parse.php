<?php
const TEXT = 1;
const SELECT = 2;


$sep = '^';
$sep_sel = '|';


$f = '1^1^2';
$l = 'Причина^Комментарий^Тип';
$c = '321^123^Тип1|Тип2|Тип3';

$fields = explode($sep,$f);
$labels = explode($sep,$l);
$contents = explode($sep,$c);

$num =0;

foreach($fields as $f){
    
   $num++;    
  }
  for ($i=0;$i<=$num;$i++){
    //Разбор типа поля
   
      if ($fields[$i]==TEXT){
        echo $labels[$i]."<br><input type='text' value='".$contents[$i]."'><p>";
      } 
      else
          if ($fields[$i]==SELECT){
          echo $labels[$i]."<br><select>";
          $opt = explode($sep_sel,$contents[$i]);
          foreach($opt as $o){
              echo "<option>".$o."</option>";
          }
          
          echo "</select>";
          }
  
  }




?>
