<?php



class CardController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
   
    }

    public function newAction()
    {
   if (Zend_Auth::getInstance()->hasIdentity()) {
       //Создаем меню
       $this->view->menu='';

       $this->view->menu .= "<a id='comps' href=# class='btn btn-primary'>Жалобы на</a><a id='anam' class='btn btn-primary'>Анамнез</a><a id='obj' class='btn btn-primary'>Объективно</a>";

       $this->view->menu .="<a id='neuro' href=# class='btn btn-primary'>Невростатус</a><a id='local' href=# class='btn btn-primary'>Локальный статус</a>";
       $this->view->menu .="<a id='obsled' href=# class='btn btn-primary'>Обследование</a>";
       $this->view->menu .="<a id='lech' href=# class='btn btn-primary'>Лечение</a>";
       $this->view->menu .="<a id='op' href=# class='btn btn-primary'>Операции</a>";
       $this->view->menu .="<center><a id='rek' href=# class='btn btn-primary'>Рекомендации</a>";
       $this->view->menu .="<a id='dis' href=# class='btn btn-primary'>Выписан</a>";
       $this->view->menu .="<a id='atdis' href=# class='btn btn-primary'>При выписке</a></center>";
     //Авторицация есть, делаем что хотим
       $post = $this->getParam("v");
       //Обращаемся в таблицу posts, получаем оттуда номера нужных форм
     
       $mforms = new Model_forms();
       $forms = array();
       $objs = array();
       $neus = array();
       $fset = $mforms->fetchAll('id='.$post);
       foreach ($fset as $f){
          $forms = explode(',',$f->complaints);
          $objs = explode(',',$f->objectively);
          $neus = explode(',',$f->neurostatus);
       }
       $this->view->content = '';
       
       //Залезаем в жалобы 
        $this->view->content .= "<ul id='comps' style='display:none;'>";
       $mcpt = new Model_Comp();
       foreach($forms as $f){
            $this->view->content .= "<li>";
           $cset = $mcpt->fetchAll("id=".$f);
           foreach($cset as $c){
             
              
                $this->view->content .= "<a  class='ln'><b>".$c->name. "</b></a>";
              $this->view->content .= "<ul style='display:none;'>";
              $items = explode("&",$c->items);
              foreach($items as $it){
                      $this->view->content .= "<li>";
                   $this->view->content .= "<a  class='0' title='".$c->contents."'>".$it."</a>";
                    $this->view->content .= "</li>";
              }
             
                $this->view->content .= "</ul>";
           }
          $this->view->content .= "</li>";
           
       }
     
       //Далее выводи анамнез
       
         $this->view->content .= "</ul><textarea style='display:none' id='anamnesis' placeholder='Анамнез в свободной форме'>
1. Пол:
2. Возраст: 
3. Причина обращения:</textarea>"; 
       
      // Объективно:
         $mobj = new Model_Obj(); 
         foreach ($objs as $obj){
          $objset = $mobj->fetchAll("id='".$obj."'");         
            foreach($objset as $o){
                 $this->view->content .= "<ul id='obj_ul' style='display:none;'><li>";
                //Разбиваем список разделов:
                $o_razd = array();
                $o_razd = explode(',',$o->fields);
                //Разбиваем список элементов на разделы
                $o_razd_i = array();
                $o_razd_i = explode('|',$o->items);
                $i=-1;
                //Выводим каждый раздел:
                    foreach($o_razd as $r){
                      $i++;  
                      
               $this->view->content.= "<a  class='ln'><b>".$r."</a>";
               
                //Разбиваем раздел на элементы
                $rr = array();
                $rr = explode("&",$o_razd_i[$i]);
                //Выводим содержание раздела.
                $this->view->content.="<ul>";
                foreach($rr as $item){
                    $this->view->content.= "<li>";
                    $this->view->content.="<a   class='0' title='".$r."'>".$item."</a>";
                    $this->view->content.="</li>";
               }
                $this->view->content.="</ul>";
                      
                    }
                
                
                $this->view->content .= "</li></ul>";
            }
          
         }
         $m_new = new Model_Neuro();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul id='neuro' style='display:none;'><li>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a href=# class='ln'><b>".$zag."</a>";
                     $this->view->content.="<ul style='display:none;'>";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li>";
                         $this->view->content.="<a   class='0' title='".$zag."'>".$item."</a>";
                             $this->view->content.= "</li>";
                     }
                     $this->view->content.="</ul>";        
                 }
             }
             $this->view->content.="</li></ul>";
         }
         
       
      
    }else  { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
    }
 

    
}

