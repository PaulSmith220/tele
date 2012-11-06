<?php
require_once 'Ru.php';
class Application_Form_Login extends Application_Form_Ru
{

    public function init()
    {
        $this->setMethod('post');
        //поле для ввода логина
        $this->addElement(
            'text', 'username', array(
                'label' => 'Логин:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
        //поле для ввода пароля
        $this->addElement('password', 'password', array(
            'label' => 'Пароль:',
            'required' => true,
            ));
        //кнопка 'submit'
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Войти',
            'class' => 'btn btn-primary'
            ));
        
        //устанавливаем Action формы
        $this->setAction(Zend_Navigation_Page_Mvc::factory(array(
            'action'     => 'login',
            'controller' => 'auth'
        ))->getHref());
        //защита от Сross Site Request Forgery
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}