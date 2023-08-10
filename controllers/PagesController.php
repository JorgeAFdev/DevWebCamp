<?php
namespace Controllers;

use Model\Day;
use Model\Time;
use MVC\Router;
use Model\Event;
use Model\Speaker;
use Model\Category;

class PagesController {
    public static function index(Router $router) {

        $events = Event::order('time_id', 'ASC');

        $formatted_events = [];
        foreach($events as $event) {
            $event->category = Category::find($event->category_id);
            $event->day = Day::find($event->day_id);
            $event->time = Time::find($event->time_id);
            $event->speaker = Speaker::find($event->speaker_id);
            

            if($event->day_id === '1' && $event->category_id === '1') {
                $formatted_events['conferences_f'][] = $event;
            }

            if($event->day_id === '2' && $event->category_id === '1') {
                $formatted_events['conferences_s'][] = $event;
            }

            if($event->day_id === '1' && $event->category_id === '2') {
                $formatted_events['workshops_f'][] = $event;
            }

            if($event->day_id === '2' && $event->category_id === '2') {
                $formatted_events['workshops_s'][] = $event;
            }
        }

        // total of each
        $speakers_total = Speaker::total();
        $conferences_total = Event::total('category_id', 1);
        $workshops_total = Event::total('category_id', 2);

        // Get all speakers
        $speakers = Speaker::all();


        $router->render('pages/index', [
            'title' => 'Summary',
            'events' => $formatted_events,
            'speakers_total' => $speakers_total,
            'conferences_total' => $conferences_total,
            'workshops_total' => $workshops_total,
            'speakers' => $speakers
        ]);
    }

    public static function about(Router $router) {

        $router->render('pages/about', [
            'title' => 'About DevWebCamp'
        ]);
    }

    public static function packages(Router $router) {

        $router->render('pages/packages', [
            'title' => 'Packages DevWebCamp'
        ]);
    }

    public static function conferences(Router $router) {

        $events = Event::order('time_id', 'ASC');

        $formatted_events = [];
        foreach($events as $event) {
            $event->category = Category::find($event->category_id);
            $event->day = Day::find($event->day_id);
            $event->time = Time::find($event->time_id);
            $event->speaker = Speaker::find($event->speaker_id);
            

            if($event->day_id === '1' && $event->category_id === '1') {
                $formatted_events['conferences_f'][] = $event;
            }

            if($event->day_id === '2' && $event->category_id === '1') {
                $formatted_events['conferences_s'][] = $event;
            }

            if($event->day_id === '1' && $event->category_id === '2') {
                $formatted_events['workshops_f'][] = $event;
            }

            if($event->day_id === '2' && $event->category_id === '2') {
                $formatted_events['workshops_s'][] = $event;
            }
        }

        $router->render('pages/conferences', [
            'title' => 'Conferences & Workshops',
            'events' => $formatted_events
        ]);
    }

    public static function error(Router $router) {

        $router->render('pages/error', [
            'title' => 'Error 404 - Page Not Found'
        ]);
    }
}