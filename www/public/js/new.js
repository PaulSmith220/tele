 var s;
window.onload=function(){
   //  
 setTimeout('$("#cke_top_otchet").hide();$("#load_editor").fadeOut(500);',3000);
} 
 $(document).ready(function(){
    
   $('a[act=top]').click(function(){
       
        $('a[act=top]').each(function(){
           // $(this).attr('onme','0');
             $(this).css('font-weight','normal'); 
        });
       
        a = $(this).attr('id');
       if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         } 
         
  
       
         
  
     $('ul').each(function(){
       id = $(this).attr('id');
       if (a!=id){
           $('ul#'+id).slideUp(500);
          
           
       }else{
            $('ul#'+a).slideToggle(500);
       }
     });
      
   });
  
  
  $("#byhand").click(function(){
     $("#cke_top_otchet").slideDown(500);
     $(".menu").fadeOut(500);
     $("#nohand").fadeIn(500);
     $(this).attr('disabled','1');
      $("#lab_check").fadeOut(500);
       $("#poly_check").fadeOut(500);
       $("#zap").slideUp(500);
        CKEDITOR.instances.otchet.setReadOnly(false);
  });
  $("#nohand").click(function(){
      if (confirm("Внимание!\nВсе внесенные вручную изменения будут потеряны!\nПродолжить?")){
    $("#byhand").removeAttr('disabled');
    $(this).fadeOut(500);
     $("#cke_top_otchet").slideUp(500);
       $(".menu").fadeIn(500);
           $("#lab_check").fadeIn(500);
       $("#poly_check").fadeIn(500);
       $("#zap").slideDown(500);
        CKEDITOR.instances.otchet.setReadOnly(true);
      }
      
  });
  
  
  
  
  
  
    
    /* 
     $('#comps').click(function(){

         $('ul#comps').slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         
         }
     });
  */   
     $(".ln").click(function(){
         $(this).next().slideToggle(500); 
    
        
     });
     
     $("#lab_check").click(function(){
       setTimeout('$("#ready").click()',200);
     });
     $("#poly_check").click(function(){
         setTimeout('$("#ready").click()',200);
     });
     
     $("#anamnesis").change(function(){
        $(this).css('color','darkgreen'); 
        $(this).attr('changed','1');
        CKEDITOR.instances.otchet.setReadOnly(false);
        $("#ready").click();
        clearTimeout(s);
          s = setTimeout('CKEDITOR.instances.otchet.setReadOnly(true)',2000);
         $(this).css('text-shadow',' 0px 0px 2px blue'); 
     
    

    
     });
       $("#dop.dp").change(function(){
        $(this).css('color','darkgreen'); 
        $(this).attr('changed','1');
        CKEDITOR.instances.otchet.setReadOnly(false);
        $("#ready").click();
        clearTimeout(s);
          s = setTimeout('CKEDITOR.instances.otchet.setReadOnly(true)',2000);
         $(this).css('text-shadow',' 0px 0px 2px blue'); 
     
    

    
     });
     ///////////////////////////////////////////
     
     ////////////////////////////////////////////
     
     
   
     tmove = 0;
     xm=0;
     ym=0;
     $("body").mousemove(function(e){
         if(tmove==1){
            xs = e.pageX;
            ys = e.pageY;
            $("body").css('user-select','none');
            $("#cke_otchet").offset({top:ys-ym, left:xs-xm});
         }else{
              $("body").css('user-select','');
         }
     });
     
  //CKEDITOR.instances.object_name.getData() --> тут хранится содержимое ckeditor объекта с именем object_name

ready_send = 0;

     $("#moveme").live('mousedown',function(e){
        $("#cke_otchet").css('border','2px solid red');
        xm = e.pageX - $(this).offset().left;
        ym = e.pageY - $(this).offset().top;
        tmove=1;
       
     });
     $("#cke_otchet").live('mousedown',function(){
     
     });
     $("#cke_otchet").live('mouseup',function(){
        $(this).css('border','0');
         tmove=0;
       
     });
     $("#cke_otchet").live('mouseleave',function(){
       
     });
  /*    $("#anam").click(function(){
         
         $("ul#anam").slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
*/
     $("ul li ul li a").click(function(){
       if ($(this).attr('class')=='0'){
           $(this).attr('class','1');
           $(this).css('color','green');
           $(this).css('display:inline;')
           $(this).css('background','#c0ffbb');
                 clearTimeout(s); 
       CKEDITOR.instances.otchet.setReadOnly(false);
            $("#ready").click();
          
     s=  setTimeout('CKEDITOR.instances.otchet.setReadOnly(true)',2000);
          
       }else {
            $(this).attr('class','0');
           $(this).css('color','');
           $(this).css('background','transparent');
           $("#ready").click();
       }
     });
 /*    
        $('#obj').click(function(){
         $('ul#obj').slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
      $('#neuro').click(function(){
         $('ul#neuro').slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
      $('#local').click(function(){
         $('ul#local').slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
     $('#poly').click(function(){
         $('ul#poly').slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
        $('#lech').click(function(){
         $('ul#heal').slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
  */   
     
     $("#ready").click(function(){
       //res = "<div style='padding:5px;border:1px solid grey;'>"+$("#result textarea").val();
       header = $("#result textarea").val();
       //res += "</div><p>";
       
       complaints = '';
       anamnesis = '';
       objectively = '';
       neurostate = '';
       localstate = '';
       polyorg = '';
       healing = '';
       operations = '';
       recomendations = '';
       out = '';
       atout = '';
       dopinfo = '';
        i=0;
        r = '';
        $("ul#comps a.1").each(function(){
            i++;
            r+= '- '+$(this).html()+"<br>";
        });
        if (i>0) {complaints+="</b><br><b>Пациент поступил с жалобами на:</b><br>"+r;
        }
    
       
       rr = /\n/g;
        an = $("#anamnesis").val().replace(rr,"<br>");
        if ($("#anamnesis").attr('changed')=='1'){
            anamnesis+="<br><b>Анамнез:</b><br>";
            anamnesis+='<i>'+an+'</i>';
            anamnesis+="<br>";
            anamnesis += "<br>"; 
        }
       
        
        
        i=0;
        r = '';
        $("ul#obj a.1").each(function(){
            i++;
            r+='<font color=green>'+$(this).attr('title')+':</font> '+$(this).html()+"<br>";
        });
         if (i>0) objectively+="<b>Объективно:</b> <br>"+r;
        objectively += "<br>"; 
        
         i=0;
        r = '';
        $("ul#neuro a.1").each(function(){
            i++;
            r+='<font color=blue>'+$(this).attr('title')+':</font> '+$(this).html()+"<br>";
        });
         if (i>0) neurostate+="<b>Невростатус:</b> <br>"+r;
        neurostate += "<br>"; 
        //Local
          i=0;
        r = '';
        $("ul#local a.1").each(function(){
            i++;
            r+='<font color=maroon>'+$(this).attr('title')+':</font> '+$(this).html()+"<br>";
        });
         if (i>0) localstate+="<b>Локальный статус:</b> <br>"+r;
        localstate += "<p>"; 
        //////////////////////
        //PolyOrg
         
        nn = '<table>';
        $("ul#poly a.0").each(function(){
           
          nn+='<tr><td><font color=#614f07>' + $(this).attr('title')+'</font> : </td><td>'+$(this).children('select').val()+'</td></tr>';
        });
        ball = 0;
        for (i=1;i<=6;i++){
            s = $("select."+i).val();
           b = s[0]-1;
           ball += b;
        }
       if (ball==0 || (ball>=5 && ball<=20)) sk = 'баллов';
       if (ball==1 || ball==21) sk = 'балл';
       if ((ball>=2 && ball<=4) || (ball>=22 && ball<=24)) sk = 'балла';
       pr = (ball/24)*100;
       pr_bar = '<div style="display:inline-block;overflow:hidden;margin-left:20px;width:100px;border-radius:5px;height:10px;border:1px solid grey;background:rgb(0,100,0);text-align: left;" id="pbar"><div id="pr" style="border-right:4px solid white;background:rgb(150,0,0);height:10px;width:'+pr+'%;"></div> </div>';
         polyorg+="<div><b>Полиорганная дисфункция (SOFA):<u><font color=red size=2> "+ ball +"</font> "+ sk +"</u></b> "+ pr_bar +"</div><br>"+nn+"</table>";
       
      if($("#poly_check").attr("checked")==undefined) polyorg = '';
       
        //////////////////////
        //Healing
         i=0;
        r = '';
        $("ul#heal a.1").each(function(){
            i++;
            r+='<font color=green>'+$(this).attr('title')+':</font> '+$(this).html()+"<br>";
        });
         if (i>0) objectively+="<b>Лечение:</b> <br>"+r;
        objectively += "<p>"; 
        
        
        
        
        
        
        
        //////////////////////
        rr = /\n/g;
      
       if($("#dop.dp").val()!='')
        dopinfo+="<b>Дополнитеьная информация:</b> <br>"+$("#dop.dp").val().replace(rr,"<br>")+"<p>";
        r='';
        i=0;
        res = header + complaints + anamnesis + objectively + neurostate + localstate + healing + operations + recomendations + out + atout +dopinfo+ polyorg;
     res+='<hr> <br>';   
        
         var iFrameDOM = $("#fr").contents();
   //Теперь мы можем использовать find() для доступа к элементам iframe:
   //например
   s = iFrameDOM.find("#fnamebox").html();
   if (s!=undefined){
       if (s.length>0){
   
   
   m = s.split('|');
   i = m.length;
   karts = '';
   for(i=1;i<=m.length-1;i++)
       if(m[i].substring(m[i].lastIndexOf('.')+1,m[i].length).toLowerCase()=='pdf'){
     karts+= "<br><a target=_blank href='/public/upload_pdf/"+m[i]+"'><img width='32' src='/public/img/pdf.ico' />"+m[i]+"</a><br>";

 }else if(m[i].substring(m[i].lastIndexOf('.')+1,m[i].length).toLowerCase()=='PDF'){
      karts+= "<br><a target=_blank href='/public/upload_pdf/"+m[i]+"'><img width='32' src='/public/img/pdf.ico' />"+m[i]+"</a><br>";
}else 
     karts+= "<br><img width='32' src='/public/upload/"+m[i]+"_thumb.jpg' /><a class='simg'>"+m[i]+"</a><div style='display:none;font-size:70%;'> Нажмите на картинку,чтобы скачать<br><a href='/public/upload/load.php?f="+m[i]+".jpg'><img title='Скачать' src='/public/upload/"+m[i]+".jpg'/></a></div><br>";
   }
$("#kart").html(karts);

}





        $("#otchet").html(res);
        CKEDITOR.instances.otchet.setData(res);
        
       //$('#otchet').val(CKEDITOR.instances['otchet'].getData());
        $("#send").show();
        $("#send").animate({'opacity':1.0},500);
         // CKEDITOR.instances.otchet.setReadOnly(false);
     });
     $(".simg").click(function(){
        $(this).next().slideToggle(500); 
     });
     
     $("#send").click(function(){
abc = (CKEDITOR.instances['otchet'].getData());

     String.prototype.trim=function(){return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');}; 
     $("#sending").show();
     //window.location
     bcd = abc.trim();
       rr = /\n/g;
        bcd = bcd.replace(rr,"");
   //  alert(bcd);
 //bcd ='/card/add/?who='+$("select#adresat").text().trim()+'&from='+$("#from").val().trim()+'&karts='+$("#kart").val().trim()+'&i=' + encodeURIComponent(bcd);

   //  $.post('/plugins/cons.php', {'i':$("#otchet").val(),'who':$("select").text(),'from':$("#from").val()}, function(data){
    //      $("#sending").hide();
     //   alert(data);
     //});
     kpic = '';
     ik=0;
     tek='';
     $("#flist li").each(function(){
        tek=$(this).children('a').html();
         if(tek.substring(tek.lastIndexOf('.')+1,tek.length).toLowerCase()=='pdf'){
     kpic+= "<br><a target=_blank href='/public/upload_pdf/"+tek+"'><img width='32' src='/public/img/pdf.ico' />"+tek+"</a><br>";

 }else if(tek.substring(tek.lastIndexOf('.')+1,tek.length).toLowerCase()=='PDF'){
      kpic+= "<br><a target=_blank href='/public/upload_pdf/"+tek+"'><img width='32' src='/public/img/pdf.ico' />"+tek+"</a><br>";
}else {
     kpic+= "<br><img width='32' src='/public/upload/"+tek+"_thumb.jpg' /><a class='simg'>"+tek+"</a><div style='display:none;font-size:70%;'> Нажмите на картинку,чтобы скачать<br><a href='/public/upload/load.php?f="+tek+".jpg'><img title='Скачать' src='/public/upload/"+tek+".jpg'/></a></div><br>";
}
        
        
        
     });
     
     
    $("#pform input[name=who]").val($("select#adresat").val().trim());
    $("#pform input[name=from]").val($("#from").val().trim());
    $("#pform input[name=karts]").val(kpic.trim());
    $("#pform input[name=i]").val(bcd);
     $("#pform").submit();
     
     });
    
$("#adr").click(function(){
    s = $(this).html();
 list = '';
 m = s.split('|');
 l = m.length;
 for (i=1;i<=l-1;i++){
     list+="<li><img alt='X' width=16 style='cursor:pointer;' src='/public/img/del.png'><a>"+m[i]+"</a></li>";
 }
 $("#flist").html(list);
})  ;   
$("#flist li img").live('click',function(){
  $(this).parent().remove(); 
});

 })