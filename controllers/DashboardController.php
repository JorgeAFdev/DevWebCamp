<?php

namespace Controllers;

use Model\Event;
use Model\Gift;
use Model\Registration;
use Model\User;
use MVC\Router;

class DashboardController
{

    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /signin');
            return;
        }

        // Get latest records
        $registered = Registration::get(5);
        $registeredData = [];
        foreach ($registered as $record) {
            $user = User::find($record->user_id);
            $registeredData[] = [
                'record' => $record,
                'user' => $user
            ];
        }

        // Calculate Income
        $online = Registration::total('package_id', 2);
        $in_person = Registration::total('package_id', 1);

        $income = ($online * 28.68) + ($in_person * 76.98);

        // // Get total Users
        // $total_users = User::total();

        // // Get total Events
        // $total_events = Event::total();

        // Get Events with + & - spots available
        $less_spots = Event::orderLimit('spots', 'ASC', 5);
        $more_spots = Event::orderLimit('spots', 'DESC', 5);

        $router->render('admin/dashboard/index', [
            'title' => 'Administration Panel',
            'registered' => $registeredData,
            'income' => $income,
            // 'total_users' => $total_users,
            // 'total_events' => $total_events,
            'less_spots' => $less_spots,
            'more_spots' => $more_spots
        ]);
    }
}
