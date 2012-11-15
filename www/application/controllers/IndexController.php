<?php



class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
   
    }

    public function indexAction()
    {
   if (Zend_Auth::getInstance()->hasIdentity()) {
     //Авторицация есть, делаем что хотим
       $login = $_SESSION['login'];
      $org_mdl = new Model_Orgs();
      $us_mdl = new Model_Users();
       $post_mdl = new Model_Posts();
      $rowset = $us_mdl->fetchAll("username='".$login."'");
      foreach($rowset as $row){
          $_SESSION['fio'] = $row->real_name;
        $_SESSION['id']= $row->id;
        $me = $row->id;
         $post = $row->post;
      $rowset = $org_mdl->fetchAll('id='.$row->org);
       foreach($rowset as $row){
           $orgname = $row->name; 
       }
      }
       $this->view->orgname = $orgname;
       $_SESSION['orgname']=$orgname;
      $rowset = $post_mdl->fetchAll("id='".$post."'");
      foreach($rowset as $row){
         $_SESSION['post']= $row->name;
      }
       $this->view->postname = $post;
         
       $postsset = $post_mdl->fetchAll();
       $plist = array();
       foreach ($postsset as $p){
          // $chs->$us_mdl->fetchAll("post=".$p->id);
            $plist[] = "<a href='/card/new?v=".$p->id."'>".$p->name." </a>";
          // foreach($chs as $s){
         //     $plist[] = "<a href='/card/new?v=".$s->id."'>".$s->name." </a>";  
       //    }
          
       }
       $this->view->plist = $plist;
       
        $inlist = array();
       $mcc = new Model_Cons();
      
       $newc = 0;
         $this->view->newcons = $newc;
       $ccset = $mcc->fetchAll("adr=".$me,'read');
       foreach ($ccset as $c){
           $b[1]='';
           $b[2]='';
           if ($c->read==0){
               $newc++;
               $b[1]='<b>';
           $b[2]='</b>';  
           }
           $uu = $us_mdl->fetchAll("id=".$c->init);
           foreach($uu as $u){
                  list($a,$aa)= explode(" ",$c->date);
                  $nm = ((($c->id)));
           $inlist[] = "<a href='/card/watch?v=".$c->id."'>#".($b[1]).$nm." ".$u->real_name." (".$a.")".($b[2])." </a>"; 
           }
       }
       
        $this->view->inlist = $inlist;
       $this->view->newcons = $newc;
      
      $sendlist = array();
   $ccset = $mcc->fetchAll("init=".$me,'date');    
     
       foreach($ccset as $cc){
            $b[0]='';
       $b[1]='';
           if($cc->read==0){$b[0]="<b>";$b[1]="</b>";}
           if($cc->read==2){$b[0]="<img src='/img/mail.png' width=20 />";}
           $uu = $us_mdl->fetchAll("id=".$cc->adr);
           foreach($uu as $u){
              list($a,$aa)= explode(" ",$cc->date);
           $sendlist[] = "<a href='/card/watchmy?v=".$cc->id."'>".$b[0].$cc->id.") ".$u->real_name." (".$a.")".$b[1]." </a>"; 
           }
       }
       $this->view->sendlist = $sendlist;
       
       
       
    }else  { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
    }
 
public function authAction(){
  


    }
    
}

