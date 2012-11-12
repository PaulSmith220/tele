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

       $this->view->menu .= "<center><a id='comps'  class='btn btn-primary'>Жалобы на</a>
           <a id='anam' class='btn btn-primary'>Анамнез</a>
           <a id='obj' class='btn btn-primary'>Объективно</a>";
       $this->view->menu .="<a id='neuro'  class='btn btn-primary'>Невростатус</a>
           <a id='local'  class='btn btn-primary'>Локальный статус</a>";
       $this->view->menu .="<a id='poly'  class='btn btn-primary'>Полиорганная Дисфункция</a>";
       $this->view->menu .="<a id='lech'  class='btn btn-primary'>Лечение</a>";
       $this->view->menu .="<a id='op'  class='btn btn-primary'>Операции</a>";
       $this->view->menu .="<a id='rek'  class='btn btn-primary'>Рекомендации</a>";
       $this->view->menu .="<a id='dis'  class='btn btn-primary'>Выписан</a>";
       $this->view->menu .="<a id='atdis'  class='btn btn-primary'>При выписке</a></center>";
     //Авторицация есть, делаем что хотим
       $post = $this->getParam("v");
     
   //  $this->view->ps = $post;
     $mpst = new Model_Users();
     $this->view->ps = array();
       $pset = $mpst->fetchAll("post='".$post."'");
       foreach($pset as $p){
          $this->view->ps[] = $p;
       }
       //Обращаемся в таблицу posts, получаем оттуда номера нужных форм
       $mps = new Model_Posts();
       $ps = $mps->fetchAll("id=".$post);
       foreach($ps as $p) $post = $p->forms;
       
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
         //Невростатус:
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
                     $this->view->content.= "<a  class='ln'><b>".$zag."</a>";
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
         /////////////////
       //Локальный статус
        $m_new = new Model_Local();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul id='local' style='display:none;'><li>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  class='ln'><b>".$zag."</a>";
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
         ///////////////////////////
      //Полиорганная дисф.
        $m_new = new Model_Polyorg();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul id='poly' style='display:none;'><li>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  class='ln'><b>".$zag."</a>";
                     $this->view->content.="<ul style='display:block;'>";
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
         ///////////////////////////
          //Лечение
        $m_new = new Model_Heal();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul id='heal' style='display:none;'><li>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  class='ln'><b>".$zag."</a>";
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
         ///////////////////////////
         
         
         
         
         
    }else  { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
    }
 
 public function addAction()
    {if (Zend_Auth::getInstance()->hasIdentity()) {
   
     
     $who =htmlspecialchars(trim($this->_getParam('who')));
     $from =htmlspecialchars(trim($this->_getParam('from')));
     $karts =(trim($this->_getParam('karts')));
$what = (trim($this->_getParam('i')));
$what = str_ireplace("SELECT", "ZZzaapp!", $what);
$what = str_ireplace("INSERT", "ZZzaapp!", $what);
$what = str_ireplace("DROP", "ZZzaapp!", $what);
$what = str_ireplace("UPDATE", "ZZzaapp!", $what);
$what = str_ireplace("DELETE", "ZZzaapp!", $what);


//ищем from
$mu = new Model_Users();
$mset = $mu->fetchAll("username='".$from."'");
if (count($mset)==0) die('Ошибка создания консультации. Отсутствует инициатор.'.$from);
foreach($mset as $u){
    $from1 = $u->id;
}
$mset = $mu->fetchAll("real_name='".$who."'");
if (count($mset)==0) die('Ошибка создания консультации. Отсутствует получатель.');
foreach($mset as $u){
    $who1 = $u->id;
}


$mc = new Model_Cons();
$data = array(
    'text'      => $what,
    'files' => $karts,
    'read' => '0',
    'init'  => $from1,
    'adr'      => $who1,
    're_com' => 'Не указан'
    
);
$mc->insert($data);





echo "Запрос отправлен специалисту";
echo " ".$who."<p>";
echo "<div style='padding:5px;border:1px solid grey;border-radius:5px;'>";
echo $what;
echo "<hr>";
echo $karts;
echo "</div>";
      } else {
          { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
      } 
 }
 
  public function watchAction()
    {if (Zend_Auth::getInstance()->hasIdentity()) {
   
      $num = htmlspecialchars($this->_getParam('v'));
      $this->view->id = $num;
    $mc = new Model_Cons();
    $um = new Model_Users();
    $data = array('read' => '1');
    $mc->update($data,"id=".$num);
    $mset = $mc->fetchAll("id=".$num);
    $this->view->content='';
if (count($mset)==0) die("Ошибка. Отсутствует запрошенная консультация");
foreach($mset as $m){
    $this->view->re_com = $m->re_com;
    $this->view->content=$m->text;
    $this->view->karts = $m->files;
    $this->view->date = $m->date;
    $this->view->to_login = $m->adr;
    //@todo: Добавить проверку - не смотрит ли он чужую консультацию
    
       $this->view->re = $m->re;
    if($m->re != -1){
        $uset = $um->fetchAll("id=".$m->re);
        foreach($uset as  $u){
            $this->view->re = $u->real_name;
        }
        
     
    }
    $from = $m->init;
}
$this->view->creator_id=$from;

$us = $um->fetchAll("id=".$from);
if (count($mset)==0) die("Ошибка. Отсутствует инициатор");
foreach($us as $u){
    $this->view->creator = $u->real_name;
    $org = $u->org;
    
    $this->view->me = $_SESSION['id'];
}
$this->view->org = $org;
$om = new Model_Orgs();
$os = $om->fetchAll("id=".$org);
foreach($os as $o){
    $this->view->orgname = $o->name;
}
$assoc = array();

$names='';
$dolj='';
$nums='';

$pm = new Model_Posts();
$ps = $pm->fetchAll();
foreach($ps as $p){
  $dolj.="|".$p->name;
    $names.=":";
    $nums.=":";
    $us = $um->fetchAll("post=".$p->id);
    foreach($us as $u){
  $names.="|".$u->real_name;
    $nums.="|".$u->id;
    }
}
$this->view->m_names = $names;
$this->view->m_dolj = $dolj;
$this->view->nums =$nums;


} else {
          { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
      } 
//$this->view->assoc =$assoc;

  }
 public function reAction(){
     if (Zend_Auth::getInstance()->hasIdentity()) {
   
     $card = htmlspecialchars($this->_getParam("c"));
     $to = htmlspecialchars($this->_getParam("v"));
     $re_com = htmlspecialchars($this->_getParam("msg"));
     $me = $_SESSION['id'];
     
     if($re_com=='')$re_com = 'Отсутствует';
     
     $re_com = preg_replace("/(\n \s{2,})/"," ",$re_com);
     $re_com = preg_replace("/&gt;!&lt;/","<br>",$re_com);
     
     $mu = new Model_Users();
     $mc = new Model_Cons();
     
   $uset = $mu->fetchAll("id=".$to);
   foreach($uset as $u) $to_name= $u->real_name;
     
  $data = array('adr' => $to);
    $mc->update($data,"id=".$card);
$data = array('re' => $me);
    $mc->update($data,"id=".$card);
$data = array('read' => '0');
    $mc->update($data,"id=".$card);
$data = array('re_com' => $re_com); 
    $mc->update($data,"id=".$card);
$this->view->content = "Консультация перенаправлена.<br> Получатель: ".$to_name;
     } else {
          { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
      } 
 }
 
 
 
 
 public function watchmyAction()
    {if (Zend_Auth::getInstance()->hasIdentity()) {
   
      $num = htmlspecialchars($this->_getParam('v'));
      $this->view->id = $num;
    $mc = new Model_Cons();
    $um = new Model_Users();
 
    $mset = $mc->fetchAll("id=".$num);
    $this->view->content='';
if (count($mset)==0) die("Ошибка. Отсутствует запрошенная консультация");
foreach($mset as $m){
    
    $this->view->content=$m->text;
    $this->view->karts = $m->files;
    $this->view->date = $m->date;
    $this->view->to_login = $m->init;
    //@todo: Добавить проверку - не смотрит ли он чужую консультацию
    
       $this->view->re = $m->re;
    if($m->re != -1){
        $uset = $um->fetchAll("id=".$m->re);
        foreach($uset as  $u){
            $this->view->re = $u->real_name;
        }
        
     
    }
    $from = $m->init;
}
$this->view->creator_id=$from;

$us = $um->fetchAll("id=".$from);
if (count($mset)==0) die("Ошибка. Отсутствует инициатор");
foreach($us as $u){
    $this->view->creator = $u->real_name;
    $org = $u->org;
    
    $this->view->me = $_SESSION['id'];
}
$this->view->org = $org;
$om = new Model_Orgs();
$os = $om->fetchAll("id=".$org);
foreach($os as $o){
    $this->view->orgname = $o->name;
}


} else {
          { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
      } 

//$this->view->assoc =$assoc;

  }
 
 
 
 
 
}

