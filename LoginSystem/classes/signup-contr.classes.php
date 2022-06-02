<?php

class SignupContr extends Signup{

    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;

    public function __construct($uid, $pwd, $pwdRepeat, $email)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }

    public function signupUser(){
        if($this->emptyInput() == false){
            //echo "Empty input!"
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        if($this->invalidUid() == false){
            //echo "Invalid username!"
            header("location: ../index.php?error=username");
            exit();
        }

        if($this->invalidEmail() == false){
            //echo "Invalid Email!"
            header("location: ../index.php?error=email");
            exit();
        }

        if($this->pwdMatch() == false){
            //echo "Password don't match!"
            header("location: ../index.php?error=passwordmatch");
            exit();
        }

        if($this->uidTakenCheck() == false){
            //echo "user ot email taken!"
            header("location: ../index.php?error=useroremailtaken");
            exit();
        }

        $this->setUser($this->uid, $this->pwd, $this->email);
    }

    private function emptyInput(){
         return (empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)) ? false : true;
    }

    private function invalidUid(){
        return (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) ? false : true ;
    }

    private function invalidEmail(){
        return (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) ? false : true ;
    }

    private function pwdMatch(){
        return ($this->pwd !== $this->pwdRepeat) ? false : true ;
    }

    private function uidTakenCheck(){
        return(!$this->checkUser($this->uid, $this->email))? false : true;
    }

}