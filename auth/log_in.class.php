<?php
class LoginUser {
    private $file_name = "users_info.json";
    private $uid;
    private $pwd;
    private $stored_users_info;
    public $success;
    public $error;

    public function __construct($uid, $pwd) {
        $this -> stored_users_info = json_decode(file_get_contents($this -> file_name), True);
        $this -> uid = $uid;
        $this -> pwd = $pwd;

        $this -> log_in();
    }

    private function log_in() {
        foreach ($this -> stored_users_info as $curr_user_info) {
            if ($this -> uid == $curr_user_info['uid']) {
                if (password_verify($this -> pwd, $curr_user_info['pwd'])) {
                    $_SESSION['user'] = $this -> uid;
                    header("location: hangman.php");
                    exit();
                }
            }
        }
        return $this -> error = "Wrong username or password. Please try again.";
    }
}
