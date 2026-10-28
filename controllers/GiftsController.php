<?php

namespace Controllers;

use Model\Gift;
use MVC\Router;
use Model\Registration;

class GiftsController
{

    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /signin');
            return;
        }
        $router->render('admin/gifts/index', [
            'title' => 'Gifts'
        ]);
    }
}
