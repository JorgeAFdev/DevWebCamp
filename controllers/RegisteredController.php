<?php
namespace Controllers;

use MVC\Router;
use Classes\Pagination;
use Model\Package;
use Model\Registration;
use Model\User;

class RegisteredController {

    public static function index(Router $router) {
        if(!is_auth()) {
            header('Location: /signin');
            return;
        }

        $current_page = $_GET['page'] ?? '';
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('location: /admin/registered?page=1');
        }

        $records_per_page = 10;
        $total = Registration::total();
        $pagination = New Pagination($current_page, $records_per_page, $total);
        
        if($pagination->total_pages() < $current_page) {
            header('location: /admin/registered?page=1');
        }

        $registered = Registration::paginate($records_per_page, $pagination->offset());
        foreach($registered as $record) {
            $record->user = User::find($record->user_id);
            $record->package = Package::find($record->package_id);
            $record->pay = Registration::where('pay_id', $record->pay_id);
        }

        $router->render('admin/registered/index', [
            'title' => 'Registered users',
            'registered' => $registered,
            'pagination' => $pagination->pagination()
        ]);
    }
}