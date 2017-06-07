<?php


class Login implements SplSubject
{

    public $name = 'Test';
    private $observers;

    public function getName(){
       return $this->name;
    }

    public function attach (SplObserver $observer){
        $this->observers[] = $observer;
    }

    public function detach (SplObserver $observer){
        foreach ($this->observers as $key => $obs){
            if($obs === $observer){
                unset($this->observers[$key]);
            }
        }
    }

    public function notify (){
        foreach ($this->observers as $observer){
            $observer->update($this);
        }
    }

    public function check(){
        //if ok. login to site
        //...
        //...

        //and action for observers
        $this->notify();
    }
}

abstract class LoginObserver implements SplObserver
{

    private $login;
    public function __construct(Login $login)
    {
        $this->login = $login;
        $this->login->attach($this);
    }

    public function update(SplSubject $subject)
    {
        if($subject === $this->login){
            $this->doUpdate($subject);
        }

    }
}

class Log extends LoginObserver
{
    public function doUpdate(SplSubject $subject)
    {
        var_dump('add log: '.$subject->getName());
    }
}

class SendCryptoFile extends LoginObserver
{
    public function doUpdate(SplSubject $subject)
    {
        var_dump('generateCryptoFile for: '.$subject->getName());
    }
}

$login = new Login();
new Log($login);
new SendCryptoFile($login);

$login->check();



