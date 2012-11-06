<?php
class AuthController extends Zend_Controller_Action
{
 private $log_m;
  public function init() {
      $staticSalt = $this->getFrontController()->getParam('bootstrap')
    ->getOption('salt');
Zend_Registry::set('staticSalt', $staticSalt);
     
  }

  public function indexAction()
  {
      $this->_redirect("/auth/login/");
  }
  public function logoutAction()
{
    // уничтожаем информацию об авторизации пользователя
      
         $log_m = new Model_Log();
          $data = array(
     'text' => 'Вышел пользователь '.$_SESSION['login'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        );

      $log_m->insert($data);
       Zend_Auth::getInstance()->clearIdentity();
    unset($_SESSION['login']);
    unset($_SESSION['post']);
    unset($_SESSION['fio']);
  
    // и отправляем его на главную
    $this->_helper->redirector('index', 'index');
}

    public function loginAction()
  {
        $loginForm = new Application_Form_Login();
          if (count($_POST) && $loginForm->isValid($_POST)) 
        { 
            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'users',
                'username',
                'password'
                
            ); 
            //идентификатор пользователя
            $adapter->setIdentity( htmlspecialchars($loginForm->getValue('username')));
            //параметр для проверки через функцию из Zend_Registry::get('authQuery')
            $adapter->setCredential(md5( htmlspecialchars($loginForm->getValue('password'))));
             
            $auth = Zend_Auth::getInstance();
            if ($auth->authenticate($adapter)->isValid()) //успешная авторизация
            {
                
                session_start();
                $_SESSION['login'] =  htmlspecialchars($loginForm->getValue('username'));
                
                  $log_m = new Model_Log();
          $data = array(
     'text' => 'Авторизовался пользователь '.$_SESSION['login'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        );

      $log_m->insert($data);
                
                $this->_helper->FlashMessenger('Добро пожаловать!');
                $this->_redirect('/');
                return;
            } 
            else {
                  $log_m = new Model_Log();
          $data = array(
     'text' => 'Неудачная попытка авторизации. Переданный логин: '. htmlspecialchars($loginForm->getValue('username'))." , пароль: ".  htmlspecialchars($loginForm->getValue('password')),
            'ip' => $_SERVER['REMOTE_ADDR'],
        );

      $log_m->insert($data);
                $this->_helper->FlashMessenger('Ошибка при авторизации: 
                    Неправильное сочетание логина и пароля!');}
        }   

        $this->view->form = $loginForm;
        
        $this->view->message = $this->getHelper('FlashMessenger')
                ->getCurrentMessages();//подставляем в отображение сообщения из помошника
                    
    
  }


}
?>
