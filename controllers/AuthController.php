<?php
require_once 'models/User.php';

class AuthController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function register($username, $password, $role) {
        $this->user->register($username, $password, $role);
    }

    public function login($username, $password) {
        return $this->user->login($username, $password);
    }
}
