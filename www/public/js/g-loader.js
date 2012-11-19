//Created by Kuznetsov Pavel Sergeevich (PSmith - kuznetps@gmail.com) (C)2012

function makeUpload(){ //Добавляет в указанный див iframe,выбирающий файлы
    myframe = "<iframe style='display:none;' class='myload' src='/public/frames/iframe.html'></iframe>";
    $("body").append(myframe);
    $('body').append(' <input style="display:none;" onclick="fchange(this.value)" type="text" id="status"/>');
}
function makeVisual(cont){ // Добавляет в область кнопку добавления файла и список файлов
   makeUpload()
      $("#"+cont).attr('id','files');
      $('#load_ul').append('<div id="r" style="display:none;">12</div><ul id="filelist"></ul>');
}
function makeStartUpload(cont){ //Делает выбранный элемент "кнопкой" запуска загрузки
    $("#"+cont).attr('id','startLoad');
}

function fchange(fname){ // Проверяет,не пустое ли имя нового файла и добавляет его в список
    if(fname.trim()!=''){
          $(".lbtn").fadeOut(500);
    
    $('ul#filelist').append('<li style="display:block;width:200px;word-wrap:break-word;cursor:pointer" title="'+file_col+'" id="flist_item"><div style="display:inline-block;" id="minus"></div><a>'+fname+'</a> <img  style="display:none;" src="/public/load.gif"/></li>');
 letitload(file_col);
 file_col++;
  }else {
       $(".lbtn").fadeIn(500);
  }
}
var flist = new Array()
var file_num = 1;
var file_col = 0;
function letitload(num){ //Пробегает по списку файлов, показывает загрузчик,вызывает загрузку для каждого
  //  flist = array();


     a = ( $("#filelist #flist_item[title="+num+"]").children('a').html());
   b = $("#filelist #flist_item[title="+num+"]");
     //  alert(flist[flist.length-1]);
      b.children('img').show();
      loadfile(a,b);
 
  
}


function  loadfile(fname,obj){ // Собственно, загрузка файлов
    // в наш скрытый фрэйм подставляем имя файла, самбитим форму, ждем пока не выведется сообщение о загрузке
    frame = $(".myload");
  
   function setfname(){
       frame.contents().find('#pushme').val(fname);
      
        frame.contents().find('#num').val(obj.attr('title'));
   }
   function fsubmit(){
       frame.contents().find('#loadf').submit();
      
   }
 setfname();
 fsubmit();

//$('body').append("<iframe class='myload' src='frames/iframe.html'></iframe>");
 
}



function loadnext(){
 $(".lbtn").fadeIn(500);
   if( $('#r').html() == '1'){

$('#filelist #flist_item[title='+$("#r").attr('title')+'] a').css('color','green');
$('#filelist #flist_item[title='+$("#r").attr('title')+']').children('img').hide(500);
$('#filelist #flist_item[title='+$("#r").attr('title')+']').attr('no','0');

$('#filelist #flist_item[title='+$("#r").attr('title')+']').attr('fname',$("#r").attr('fname'));
//$('#filelist #flist_item[title='+$("#r").attr('title')+']').remove();
   f = flist[file_num];
} else{
 $('#filelist #flist_item[title='+$("#r").attr('title')+'] a').css('color','red');
$('#filelist #flist_item[title='+$("#r").attr('title')+']').children('img').hide(500);   
$('#filelist #flist_item[title='+$("#r").attr('title')+']').attr('title',$('#r').html());

}

   
   
   //Загружаем
   
 // $('body').append("<iframe class='myload' src='frames/iframe.html'></iframe>");
}




























$(document).ready(function(){
   makeVisual('load_button');
   
   $("#startLoad").live('click',function(){
       letitload();
   })
   
   $('#files').live('click',function(){
       $('.myload').contents().find('#pushme').click();
     
   });
   $("#filelist #flist_item").live('click',function(){
        $(".myload").attr('src','/public/frames/iframe.html');
       if ($(this).children('img').is(':visible')){
      $(this).remove(); 
     
       }
     
   });
   
   
   $("#r").live('click',function(){
      loadnext();
   });
   $("#minus").live('click',function(){
      $(this).parent().remove();
   
   });
   
});