<?php
class RegisterUser {
    private $file_name = "users_info.json";
    private $uid;
    private $raw_pwd;
    private $pwd_var;
    private $hashed_pwd;
    private $stored_users_info;
    private $new_user_info;
    public $success;
    public $error;
    public $wins;

    public function __construct($uid, $pwd, $pwd_var) {
        $this -> uid = filter_var(trim($uid), FILTER_SANITIZE_STRING);
        $this -> raw_pwd = filter_var(trim($pwd), FILTER_SANITIZE_STRING);
        $this -> pwd_var = filter_var(trim($pwd_var), FILTER_SANITIZE_STRING);
        $this -> hashed_pwd = password_hash($this -> raw_pwd, PASSWORD_DEFAULT);
        $this -> wins = 0;

        $this -> stored_users_info = json_decode(file_get_contents($this -> file_name), True);
        $this -> new_user_info = [
            "uid" => $this -> uid,
            "pwd" => $this -> hashed_pwd,
            "wins" => $this -> wins
        ];

        $this -> insert_user();
    }

    private function pwds_same() {
        if ($this -> raw_pwd == $this -> pwd_var) {
            return True;
        } else {
            $this -> error = "Passwords do not match. Please try again.";
            return False;
        }
    }

    private function uid_taken() {
        foreach ($this -> stored_users_info as $curr_user_info) {
            if ($this -> uid == $curr_user_info['uid']) {
                $this -> error = "This username has already been taken. Please choose a different one.";
                return True;
            } 
        }
        return False;
    }

    private function insert_user() {
        if (($this -> uid_taken() == False) && ($this -> pwds_same() == True)) {
            array_push($this -> stored_users_info, $this -> new_user_info);
            if (file_put_contents($this -> file_name, json_encode($this -> stored_users_info, JSON_PRETTY_PRINT))) {
                return $this -> success = "Account created successfully. Have fun!";
            } else {
                return $this -> error = "Please try again. Something went wrong.";
            }
        }
    }
}
