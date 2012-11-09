  
 $(document).ready(function(){
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
     $(".ln").click(function(){
         $(this).next().slideToggle(500); 
     });
     $("#anamnesis").change(function(){
        $(this).css('color','darkgreen'); 
        $(this).attr('changed','1');
        
         $(this).css('text-shadow',' 0px 0px 2px blue'); 
     
    

    
     });
      $("#anam").click(function(){
         $("#anamnesis").slideToggle(500); 
         if ($(this).attr('onme')=='1'){
             $(this).attr('onme','0');
             $(this).css('font-weight','normal');
         }else {
             $(this).attr('onme','1');
             $(this).css('font-weight','bold');
         }
     });
     $("ul li ul li a").click(function(){
       if ($(this).attr('class')=='0'){
           $(this).attr('class','1');
           $(this).css('color','green');
       }else {
            $(this).attr('class','0');
           $(this).css('color','');
       }
     });
        $('#obj').click(function(){
         $('ul#obj_ul').slideToggle(500); 
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
     $("#ready").click(function(){
       //res = "<div style='padding:5px;border:1px solid grey;'>"+$("#result textarea").val();
       res=$("#result textarea").val();
       //res += "</div><p>";
       
        i=0;
        r = '';
        $("ul#comps a.1").each(function(){
            i++;
            r+= '- '+$(this).html()+"<br>";
        });
        if (i>0) res+="</b><b>Пациент поступил с жалобами на:</b><br>"+r;
        res += "<p>"; 
        if ($("#anamnesis").attr('changed')=='1'){
            res+="<b>Анамнез:</b><br>";
            res+=$("#anamnesis").val();
            res+="<br>";
             res += "<p>"; 
        }
        
        
        
        i=0;
        r = '';
        $("ul#obj_ul a.1").each(function(){
            i++;
            r+=$(this).attr('title')+': '+$(this).html()+"<br>";
        });
         if (i>0) res+="<b>Объективно:</b> <br>"+r;
        res += "<p>"; 
        
         i=0;
        r = '';
        $("ul#neuro a.1").each(function(){
            i++;
            r+=$(this).attr('title')+': '+$(this).html()+"<br>";
        });
         if (i>0) res+="<b>Невростатус:</b> <br>"+r;
        res += "<p>"; 
        
       if($("#dop").val()!='')
        res+="<b>Дополнитеьная информация:</b> <br>"+$("#dop").val()+"<p>";
        
         var iFrameDOM = $("#fr").contents();
   //Теперь мы можем использовать find() для доступа к элементам iframe:
   //например
   s = iFrameDOM.find("#fnamebox").html();
   if (s!=undefined){
       if (s.length>0){
   res+='<hr> <br>';
   
   m = s.split('|');
   i = m.length;
   karts = '';
   for(i=1;i<=m.length-1;i++)
       if(m[i].substring(m[i].lastIndexOf('.')+1,m[i].length).toLowerCase()=='pdf'){
     karts+= "<br><a target=_blank href='/upload_pdf/"+m[i]+"'><img width='32' src='/img/pdf.ico' />"+m[i]+"</a><br>";

 }else if(m[i].substring(m[i].lastIndexOf('.')+1,m[i].length).toLowerCase()=='PDF'){
      karts+= "<br><a target=_blank href='/upload_pdf/"+m[i]+"'><img width='32' src='/img/pdf.ico' />"+m[i]+"</a><br>";
}else 
     karts+= "<br><img width='32' src='/upload/"+m[i]+"_thumb.jpg' /><a class='simg'>"+m[i]+"</a><div style='display:none;font-size:70%;'> Нажмите на картинку,чтобы скачать<br><a href='/upload/"+m[i]+".jpg'><img title='Скачать' src='/upload/"+m[i]+".jpg'/></a></div><br>";
   }
$("#kart").html(karts);

}




        $("#otchet").html(res);
        CKEDITOR.instances.otchet.setData(res);
        
       //$('#otchet').val(CKEDITOR.instances['otchet'].getData());
        $("#send").show();
        $("#send").animate({'opacity':1.0},500);
     });
     $(".simg").click(function(){
        $(this).next().slideToggle(500); 
     });
     
     $("#send").click(function(){
abc = (CKEDITOR.instances['otchet'].getData());
     String.prototype.trim=function(){return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');}; 
     $("#sending").show();
     window.location = '/card/add/?who='+$("select").text().trim()+'&from='+$("#from").val().trim()+'&karts='+$("#kart").val().trim()+'&i='+abc.trim();
   //  $.post('/plugins/cons.php', {'i':$("#otchet").val(),'who':$("select").text(),'from':$("#from").val()}, function(data){
    //      $("#sending").hide();
     //   alert(data);
     //});
     
     });
    
     
     
 })