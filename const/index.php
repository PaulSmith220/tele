<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <title>Конструктор форм</title> 
        <script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
        <script>
            $(document).ready(function(){
                
            n = 0;
            $(".s_min").live('click',function(){
                a = $(this).attr('id');
                $("#a"+a+".o_min").remove();
                $(this).remove();
            });
            
            $("#addopts").click(function(){
               a = '';
                $('.o_min').each(function(){
                    a+='<option>'+$(this).val()+'</option>';
                   
                    
                });
                $('#options select').html(a);
             
            });
            $(".add").click(function(){
                n++;
                a = $(this).attr('title');
                $('#blocks').append('<div id="tblock" class="'+n+'"><div id="bcont">'+$('#'+a).html()+'</div><button class="delme" id="'+n+'">-</button></div>');
                
            });
            $(".delme").live('click',function(){
                
       
             
                a = $(this).attr('id');
             //Разбираем,что добавить
             //    if($("#tblock."+a+" #bcont").children().attr('what')=='sel') alert($("#tblock."+a+" #bcont").children().html());
            //   if($("#tblock."+a+" #bcont").children().attr('what')=='txt') alert($("#tblock."+a+" #bcont").children().val());
                  
             $("#tblock."+a).remove();
            });
            
            
            $("#rslt").click(function(){
             
            });
        })    
            </script>
        
        
        
        
    </head>
    <style>
        body{
            margin:0;
        }
        #bcont{
            display:inline-block
        }
        #footer{
            position:fixed;
            top:100%;
            height:20px;
            margin-top: -20px;
            background:lightgrey;
            color:grey;
            width:100%;
            text-align: right;
            font-size: 60%;
             opacity:0.6;
        }    
        #footer a{
            color:grey;
            padding-right: 10px;
        }
        #cont{
            width: 800px;
            min-height: 400px;
            background:lightcyan;
            position: absolute;
            left:50%;
            margin-left:-400px;
        }
        #header{
            width:780;
          
            padding:10px;
            border-radius: 2px;
            color:white;
            background-color: #fafafa;
  background-image: -moz-linear-gradient(top, #81caf8, #309cfe);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#81caf8), to(#309cfe));
  background-image: -webkit-linear-gradient(top, #81caf8, #309cfe);
  background-image: -o-linear-gradient(top, #81caf8, #309cfe);
  background-image: linear-gradient(to bottom, #81caf8, #309cfe);
        }
        button, input[type=button]{
             text-align: center;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  vertical-align: middle;
  cursor: pointer;
  background-color: #f5f5f5;
  *background-color: #e6e6e6;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#9ad6fc), to(#309cfe));
  background-image: -webkit-linear-gradient(top, #9ad6fc, #309cfe);
  background-image: -o-linear-gradient(top, #9ad6fc, #309cfe);
  background-image: linear-gradient(to bottom, #9ad6fc, #309cfe);
  background-image: -moz-linear-gradient(top, #9ad6fc, #309cfe);
  background-repeat: repeat-x;
  border: 1px solid #9ad6fc;
  *border: 0;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-bottom-color: #a2a2a2;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
  filter: progid:dximagetransform.microsoft.gradient(enabled=false);
  *zoom: 1;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
     -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
          box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
          color:white;
        }
        button:hover, input[type=button]:hover{
            color:lightgrey;
        }
        #blocks{
            min-height: 400px;
            
            
            padding:20px;
        }
        #controls{
            position:relative;
            top:100%;
            border:1px solid lightgrey;
            border-radius: 5px;
        }
        #block{
            padding:10px;
            float:left;
        }
        #options, #opts{
            width:300px;
        }
        input[type=text]{
            background:white;
            border:1px solid grey;
            border-radius: 5px;
            padding-left:5px;
        }
        select{
             background:white;
            border:1px solid grey;
            border-radius: 5px;
            padding-left:5px;
        }
    </style>
<body>
    <div id="cont">
        <div id="header">
            Конструктор форм. <input type="button" id="rslt" value="OK"/>
        </div>
        
        <div id="blocks">
       
        </div>
        <div id="controls">
            
            <div id="block">
                Текстовое поле
                <div id="t_add">
                    
                <input type="text" what="txt" class="label" label="11"  placeholder="Подпись" onkeyup="$(this).attr('label',$(this).val());">
                </div> <input title="t_add" class="add" type="button" value="Добавить"/> 
            </div>
            <div id="block">
                Селект
                <div id="s_add">
                <input type="text" what="txt" class="label" placeholder="Подпись" onkeyup="$('#options select').attr('label',$(this).val());"><br>
                <div id="options">
                    <select what="sel">
                        
                    </select>
                    </div>
                <div id="opts">
                    
                 </div>   
                    <button title="1" onclick="a = $(this).attr('title')+1;$(this).attr('title',a); $('#opts').append('<input class=\'o_min\' id=\'a'+a+'\' type=\'text\' value=\'Опция\'><button id=\''+a+'\' class=\'s_min\'>-</button>');">+</button>
                </div> <input type="button" id="addopts" value="Вставить"> 
                <input title="options" class="add" type="button" value="Добавить" /> 
            </div>
        </div>
    </div>
     <div id="footer">
         &copy; <a href="mailto:kuznetps@gmail.com">Кузнецов П.С.</a>
        </div>
</body>

</html>