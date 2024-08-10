<?php

namespace App\Helper;

class Validate {
    public static function register() {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public static function login() {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
