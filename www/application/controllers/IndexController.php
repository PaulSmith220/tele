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
           $plist[] = "<a href='/card/new?v=".$p->forms."'>".$p->name." </a>";
       }
       $this->view->plist = $plist;
       
    }else  { if(isset($_SESSION['login'])) unset($_SESSION['login']);
        $this->_helper->redirector('login', 'auth');}
    }
 
public function authAction(){
  


    }
    
}

