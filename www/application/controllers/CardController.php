<?php


function getRealIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

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

       $this->view->menu .= "<center><a id='comps' itis='menu' act='top' onme='0'  class='btn btn-primary'>Жалобы на</a>
           <a id='anam' act='top' onme='0' itis='menu' class='btn btn-primary'>Анамнез</a>
           <a id='obj' act='top' onme='0' itis='menu' class='btn btn-primary'>Объективно</a>";
       $this->view->menu .="<a id='neuro' itis='menu' act='top' onme='0'  class='btn btn-primary'>Невростатус</a>
           <a id='local' act='top' onme='0' itis='menu'  class='btn btn-primary'>Локальный статус</a>";
       $this->view->menu .="<a id='poly' itis='menu' act='top' onme='0'  class='btn btn-primary'>Полиорганная Дисфункция</a>";
       $this->view->menu .="<a id='lech' itis='menu' act='top' onme='0'  class='btn btn-primary'>Лечение</a>";
       $this->view->menu .="<a id='operations' itis='menu' act='top' onme='0'  class='btn btn-primary'>Операции</a>";
       $this->view->menu .="<a id='recomendations' itis='menu' act='top' onme='0'  class='btn btn-primary'>Рекомендации</a>";
       $this->view->menu .="<a id='discharge' itis='menu' act='top' onme='0'  class='btn btn-primary'>Выписан</a>";
    //   $this->view->menu .="<a id='atdis' itis='menu' act='top' onme='0'  class='btn btn-primary'>При выписке</a>";
       $this->view->menu .="<a id='dop' itis='menu' act='top' onme='0'  class='btn btn-primary'>Дополнительно</a></center>";
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
        $this->view->content .= "<ul itis='menu' id='comps' class='top' style='display:none;'>";
       $mcpt = new Model_Comp();
       foreach($forms as $f){
            $this->view->content .= "<li itis='menu'>";
           $cset = $mcpt->fetchAll("id=".$f);
           foreach($cset as $c){
             
              
                $this->view->content .= "<a itis='menu' class='ln'><b itis='menu'>".$c->name. "</b></a>";
              $this->view->content .= "<ul itis='menu' style='display:none;'>";
              $items = explode("&",$c->items);
              foreach($items as $it){
                      $this->view->content .= "<li itis='menu'>";
                   $this->view->content .= "<a itis='menu'  class='0' title='".$c->contents."'>".$it."</a>";
                    $this->view->content .= "</li>";
              }
             
                $this->view->content .= "</ul>";
           }
          $this->view->content .= "</li>";
           
       }
     $this->view->content .= "</ul>";
       //Далее выводи анамнез
       
         $this->view->content .= "<ul itis='menu' style='display:none' id='anam'><li><textarea itis='menu'  id='anamnesis' placeholder='Анамнез в свободной форме'>
1. Пол:
2. Возраст: 
3. Причина обращения:</textarea></li></ul>"; 
       
      // Объективно:
         $mobj = new Model_Obj(); 
         foreach ($objs as $obj){
          $objset = $mobj->fetchAll("id='".$obj."'");         
            foreach($objset as $o){
                 $this->view->content .= "<ul itis='menu' class='top'  id='obj' style='display:none;'><li itis='menu'>";
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
                      
               $this->view->content.= "<a  itis='menu' class='ln'><b itis='menu'>".$r."</a>";
               
                //Разбиваем раздел на элементы
                $rr = array();
                $rr = explode("&",$o_razd_i[$i]);
                //Выводим содержание раздела.
                $this->view->content.="<ul itis='menu'>";
                foreach($rr as $item){
                    $this->view->content.= "<li itis='menu'>";
                    $this->view->content.="<a itis='menu'  class='0' title='".$r."'>".$item."</a>";
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
                    $this->view->content .= "<ul itis='menu' class='top'  id='neuro' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a itis='menu'  class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' style='display:none;'>";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a itis='menu'  class='0' title='".$zag."'>".$item."</a>";
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
                    $this->view->content .= "<ul itis='menu' class='top'  id='local' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  itis='menu' class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' style='display:none;'>";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a  itis='menu' class='0' title='".$zag."'>".$item."</a>";
                             $this->view->content.= "</li>";
                     }
                     $this->view->content.="</ul>";        
                 }
             }
             $this->view->content.="</li></ul>";
         }
         ///////////////////////////
         //  Рекомендации
        $m_new = new Model_rec();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul itis='menu' class='top'  id='recomendations' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  itis='menu' class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' >";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a  itis='menu' class='0' title='".$zag."'>".$item."</a>";
                             $this->view->content.= "</li>";
                     }
                     $this->view->content.="</ul>";        
                 }
             }
             $this->view->content.="</li></ul>";
         }
         ///////////////////////////
         // // Выписан
        $m_new = new Model_dis();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul itis='menu' class='top'  id='discharge' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  itis='menu' class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' >";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a  itis='menu' class='0' title='".$zag."'>".$item."</a>";
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
                    $this->view->content .= "<ul itis='menu' class='top'  id='poly' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a itis='menu' class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' style='display:block;'>";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a  itis='menu' class='0' title='".$zag."'>".$item."</a>";
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
                    $this->view->content .= "<ul itis='menu' class='top'  id='lech' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a itis='menu' class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' style='display:none;'>";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a itis='menu' class='0' title='".$zag."'>".$item."</a>";
                             $this->view->content.= "</li>";
                     }
                     $this->view->content.="</ul>";        
                 }
             }
             $this->view->content.="</li></ul>";
         }
         ///////////////////////////
         //Операции
        $m_new = new Model_Op();
         foreach($neus as $n){
             $nset = $m_new->fetchAll("id='".$n."'");
             foreach($nset as $new){
                    $this->view->content .= "<ul itis='menu' class='top'  id='operations' style='display:none;'><li itis='menu'>";
                 $n_zag = array();
                 $n_fields = array();
                 $n_zag = explode(',',$new->fields);
                 $n_fields = explode('|',$new->items);
                 $i = -1;
                 foreach ($n_zag as $zag){
                     $i++;
                     $n_fields_i = explode("&",$n_fields[$i]);
                     $this->view->content.= "<a  itis='menu' class='ln'><b itis='menu'>".$zag."</a>";
                     $this->view->content.="<ul itis='menu' style='display:none;'>";
                     foreach($n_fields_i as $item){
                             $this->view->content.= "<li itis='menu'>";
                         $this->view->content.="<a  itis='menu' class='0' title='".$zag."'>".$item."</a>";
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
$cnt=0;
$mmc = $mc->fetchAll();
foreach($mmc as $m){
   if( $m->id > $cnt)$cnt = $m->id;
}

$data = array(
    'text'      => $what,
    'files' => $karts,
    'read' => '0',
    'init'  => $from1,
    'adr'      => $who1,
    're_com' => 'Не указан'
    
);
$mc->insert($data);
////////LOG//////////////////////
  $log_m = new Model_Log();
          $data = array(
     'text' => 'Пользователь '.$from."(".$from1.") отправил карту ползователю ".$who."(".$who1.")<br>Id:".($cnt+1)."<br>Прикрепления:".$karts."<br>Логин в сессии: ".$_SESSION['login'],
            'ip' => getRealIpAddr(),
        );

      $log_m->insert($data);
/////////////////////////////////


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
     ////////LOG//////////////////////
  $log_m = new Model_Log();
  $uuu =new Model_Users();
  $uuus = $uuu->fetchAll('id='.$num);
  foreach($uuus as $ua){
      $loginuu = $ua->username;
  }
  $uuus = $uuu->fetchAll('id='.$from);
  foreach($uuus as $ua){
      $frnuu = $ua->username;
  }
          $data = array(
     'text' => 'Пользователь '.$loginuu.'('.$m->adr.") просмотрел консультацию ".$num.", полученную от ".$frnuu."(".$from.")<br>Логин в сессии: ".$_SESSION['login'],
            'ip' => getRealIpAddr(),
        );

      $log_m->insert($data);
/////////////////////////////////
    
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
  ////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////
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
  ////////LOG//////////////////////
  $log_m = new Model_Log();
  $uuu =new Model_Users();
  $uuus = $uuu->fetchAll('id='.$me);
  foreach($uuus as $ua){
      $loginuu = $ua->username;
  }

          $data = array(
     'text' => 'Пользователь '.$loginuu.'('.$me.") перенаправил консультацию ".$card." на пользователя ".$to_name."(".$to.")
<br>Комментарий:".($re_com)."         
<br>Логин в сессии: ".$_SESSION['login'],
            'ip' => getRealIpAddr(),
        );

      $log_m->insert($data);
/////////////////////////////////
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
    $this->view->re_com = $m->re_com;
    $this->view->re = $m->re;
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

