<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function sanitizeHTML($html) : string {
    $sanitizeHTML = htmlspecialchars($html);
    return $sanitizeHTML;
}

function current_page($path) : bool {
    return str_contains(strtok($_SERVER['REQUEST_URI'], '?'), $path) ? true : false;  
}

function is_auth() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['name']) && !empty($_SESSION);
}
function is_admin() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

function aos_animation(): void {
    $efects = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $efect = array_rand($efects, 1);
    echo ' data-aos="' . $efects[$efect] . '" ';
}