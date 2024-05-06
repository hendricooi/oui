<?php
session_start();

class Login {
    private $id;
    private $username;
    private $password;


    public function __construct($id,$username, $password ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate() {
        // Validate username and password (Here, you'll typically validate against a database)
        if ($this->username === '123' && $this->password === '123') {
            // Authentication successful, set session variable
            $_SESSION['loggedin'] = true;
            $_SESSION['ID'] = $this->id;
            $_SESSION['username'] = $this->username;
            return true;
        } else {
            // Authentication failed
            return false;
        }
    }

    
    public static function isLoggedIn() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Check if the 'loggedin' session variable is set and true
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            return true; // User is logged in
        }
    
        return false; // User is not logged in
    }

    public static function getUsername() {
        // Get username of logged in user
        return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    public static function logout() {
        // Unset all session variables

        // Destroy the session
        session_destroy();
        header("Refresh:0");
    }
}