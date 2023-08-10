<?php
namespace Controllers;

use Model\Day;
use Model\Time;
use MVC\Router;
use Model\Event;
use Model\Speaker;
use Model\Category;
use Classes\Pagination;

class EventsController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /sign-in');
        }
        $current_page = $_GET['page'] ?? '';
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('Location: /admin/events?page=1');
        }

        $records_per_page = 10;
        $total = Event::total();
        $pagination = new Pagination($current_page, $records_per_page, $total);

        $events = Event::paginate($records_per_page, $pagination->offset());

        foreach($events as $event) {
            $event->category = Category::find($event->category_id);
            $event->day = Day::find($event->day_id);
            $event->time = Time::find($event->time_id);
            $event->speaker = Speaker::find($event->speaker_id);
            
        }    

        $router->render('admin/events/index', [
            'title' => 'Conferences and Workshops',
            'events' => $events,
            'pagination' => $pagination->pagination()
        ]);
    }

    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /sign-in');
        }
        $alerts = [];

        $categories = Category::all('ASC');
        $days = Day::all('ASC');
        $times = Time::all('ASC');

        $event = new Event;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $event->synchronize($_POST);
            $alerts = $event->validate();

            if(empty($alerts)) {
                $result = $event->save();
                if($result) {
                    header('Location: /admin/events');
                }
            }
        }

        $router->render('admin/events/create', [
            'title' => 'Craete Event',
            'alerts' => $alerts,
            'categories' => $categories,
            'days' => $days,
            'times' => $times,
            'event' => $event
        ]);
    }

    public static function edit(Router $router) {
        if(!is_admin()) {
            header('Location: /sign-in');
        }
        $alerts = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/events');
        }

        $categories = Category::all('ASC');
        $days = Day::all('ASC');
        $times = Time::all('ASC');

        $event = Event::find($id);

        if(!$event) {
            header('Location: /admin/events');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $event->synchronize($_POST);
            $alerts = $event->validate();

            if(empty($alerts)) {
                $result = $event->save();
                if($result) {
                    header('Location: /admin/events');
                }
            }
        }

        $router->render('admin/events/edit', [
            'title' => 'Edit Event',
            'alerts' => $alerts,
            'categories' => $categories,
            'days' => $days,
            'times' => $times,
            'event' => $event
        ]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /sign-in');
            }
            $id = $_POST['id'];
            $event = Event::find($id);
            if(!isset($event)) {
                header('Location: /admin/events');
            }
        }
        $result = $event->delete();
        if($result) {
            header('Location: /admin/events');
        }
    }
}