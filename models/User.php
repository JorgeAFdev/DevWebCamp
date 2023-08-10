<?php
namespace Model;

class User extends ActiveRecord {
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name','surname', 'email', 'password', 'confirmed', 'token', 'admin'];

    public $id;
    public $name;
    public $surname;
    public $email;
    public $password;
    public $password2;
    public $confirmed;
    public $token;
    public $admin;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = 0;
        
    }

    // Validation messages for account creation
    public function validateNewAccount() : array {
        if(!$this->name) {
            self::$alerts['error']['name'] = 'Your Name is required';
        }
        if(!$this->surname) {
            self::$alerts['error']['surname'] = 'Your surname is required';
        }
        if(!$this->email || filter_var($this->email, FILTER_VALIDATE_EMAIL ) === false) {
            self::$alerts['error']['email'] = 'Your Email is required';
        }
        if(!$this->password) {
            self::$alerts['error']['password'] = 'The password cannot be empty';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error']['password_length'] = 'Your Password must contain at least 6 characters';
        }
        if($this->password !== $this->password2) {
            self::$alerts['error']['different_psw'] = 'The passwords are different';
        }
        return self::$alerts;
    }

    // Validate User Login
    public function validateLogin() : array {
        if(!$this->email || filter_var($this->email, FILTER_VALIDATE_EMAIL ) === false) {
            self::$alerts['error']['email'] = 'Your Email is required';
        }
        if(!$this->password) {
            self::$alerts['error']['password'] = 'Your password is required';
        }
        return self::$alerts;
    }

    // Validate Email
    public function validateEmail() : array {
        if(!$this->email || filter_var($this->email, FILTER_VALIDATE_EMAIL ) === false) {
            self::$alerts['error']['email'] = 'Your Email is required';
        }
        return self::$alerts;
    }

    // Validate Password
    public function validatePassword() : array {
        if(!$this->password) {
            self::$alerts['error']['password'] = 'The password cannot be empty';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error']['password_length'] = 'Your Password must contain at least 6 characters';
        }
        return self::$alerts;
    }

    // hash password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generate Token
    public function createToken() : void {
        $this->token = md5(uniqid());
    }

    public function checkPasswordAndVerification($password) {
        $result = password_verify($password, $this->password);

        if(!$result || !$this->confirmed) {
            self::$alerts['error'][] = 'Invalid password or account not confirmed';
        } else {
            return true;
        }
    }
}