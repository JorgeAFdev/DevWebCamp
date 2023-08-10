<?php
namespace Controllers;

use Model\Event;
use Model\Gift;
use Model\Registration;
use Model\User;
use MVC\Router;

class DashboardController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /');
        }

        // Get latest records
        $registered = Registration::get(5);
        foreach($registered as $record) {
            $record->user = User::find($record->user_id);
        }

        // Calculate Income
        $online = Registration::total('package_id', 2);
        $in_person = Registration::total('package_id', 1);

        $income = ($online * 28.68) + ($in_person * 76.98);

        // Get Events with + & - spots available
        $less_spots = Event::orderLimit('spots', 'ASC', 5);
        $more_spots = Event::orderLimit('spots', 'DESC', 5);

        // Gifts
        $gifts = Gift::all();

        foreach ($gifts as $gift) {
            $gift->total = Registration::totalArray(['gift_id' => $gift->id, 'package_id' => "1"]);
        }


        $router->render('admin/dashboard/index', [
            'title' => 'Administration Panel',
            'registered' => $registered,
            'income' => $income,
            'less_spots' => $less_spots,
            'more_spots' => $more_spots,
            'gifts' => $gifts
        ]);
    }
}