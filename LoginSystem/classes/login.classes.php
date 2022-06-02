<?php

class Login extends Dbh {

    protected function getUser($uid, $pwd){
        $stmt = $this->connect()->prepare('SELECT users_pwd FROM users WHERE users_uid = ? OR users_email = ?;');

        if(!$stmt->execute(array($uid, $pwd))){
            $stmt = null;
            header("location : ../index.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0){
            $stmt = null;
            header("location : ../index.php?error=stmtfailed");
            exit();
        }

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $chechPwd = password_verify($pwd, $pwdHashed[0]["users_pwd"]);

        if($chechPwd == false){
            $stmt = null;
            header("location : ../index.php?error=stmtfailed");
            exit();
        }elseif($chechPwd == true){
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_uid = ? OR users_email = ? AND users_pwd = ?;');

            if(!$stmt->execute(array($uid, $uid, $pwd))){
                $stmt = null;
                header("location : ../index.php?error=stmtfailed");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["userid"] = $user[0]["users_id"];
            $_SESSION["useruid"] = $user[0]["users_uid"];

            $stmt = null;
        }

        
    }






    protected function checkUser($uid, $email){
        $stmt = $this->connect()->prepare('SELECT users_uid FROM users WHERE users_uid = ? OR users_email = ?;');
        if(!$stmt->execute(array($uid, $email))){
            $stmt = null;
            header("location : ../index.php?error=stmtfailed");
            exit();
        }


        return ($stmt->rowCount() > 0) ? false : true;
        
    }
}