<?php

namespace Controllers;

use Model\Day;
use Model\Time;
use MVC\Router;
use Model\Event;
use Model\Speaker;
use Model\Category;

class PagesController
{
    public static function index(Router $router)
    {

        $events = Event::order('time_id', 'ASC');

        $formatted_events = [];
        foreach ($events as $event) {
            $category = Category::find($event->category_id);
            $day = Day::find($event->day_id);
            $time = Time::find($event->time_id);
            $speaker = Speaker::find($event->speaker_id);

            $formatted_event = [
                'event' => $event,
                'category' => $category,
                'day' => $day,
                'time' => $time,
                'speaker' => $speaker
            ];

            if ($day->id === '1' && $category->id === '1') {
                $formatted_events['conferences_f'][] = $formatted_event;
            }

            if ($day->id === '2' && $category->id === '1') {
                $formatted_events['conferences_s'][] = $formatted_event;
            }

            if ($day->id === '1' && $category->id === '2') {
                $formatted_events['workshops_f'][] = $formatted_event;
            }

            if ($day->id === '2' && $category->id === '2') {
                $formatted_events['workshops_s'][] = $formatted_event;
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

    public static function about(Router $router)
    {

        $router->render('pages/about', [
            'title' => 'About DevWebCamp'
        ]);
    }

    public static function packages(Router $router)
    {

        $router->render('pages/packages', [
            'title' => 'Packages DevWebCamp'
        ]);
    }

    public static function conferences(Router $router)
    {

        $events = Event::order('time_id', 'ASC');

        $formatted_events = [];
        foreach ($events as $event) {
            $category = Category::find($event->category_id);
            $day = Day::find($event->day_id);
            $time = Time::find($event->time_id);
            $speaker = Speaker::find($event->speaker_id);

            $formatted_event = [
                'event' => $event,
                'category' => $category,
                'day' => $day,
                'time' => $time,
                'speaker' => $speaker
            ];

            if ($day->id === '1' && $category->id === '1') {
                $formatted_events['conferences_f'][] = $formatted_event;
            }

            if ($day->id === '2' && $category->id === '1') {
                $formatted_events['conferences_s'][] = $formatted_event;
            }

            if ($day->id === '1' && $category->id === '2') {
                $formatted_events['workshops_f'][] = $formatted_event;
            }

            if ($day->id === '2' && $category->id === '2') {
                $formatted_events['workshops_s'][] = $formatted_event;
            }
        }

        // Get all speakers
        $speakers = Speaker::all();

        $router->render('pages/conferences', [
            'title' => 'Conferences & Workshops',
            'events' => $formatted_events,
            'speakers' => $speakers
        ]);
    }

    public static function details(Router $router)
    {

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /');
        }

        $event = Event::find($id);
        $speaker = Speaker::find($id);

        if (!$event) {
            header('Location: /');
            return;
        }

        $formatted_event = [];

        $category = Category::find($event->category_id);
        $day = Day::find($event->day_id);
        $time = Time::find($event->time_id);
        $speaker = Speaker::find($event->speaker_id);

        $formatted_event = [
            'event' => $event,
            'category' => $category,
            'day' => $day,
            'time' => $time,
            'speaker' => $speaker
        ];

        $router->render('pages/details', [
            'title' => $event->name,
            'event' => $formatted_event,
            'speaker' => $speaker
        ]);
    }

    public static function error(Router $router)
    {

        $router->render('pages/error', [
            'title' => 'Error 404 - Page Not Found'
        ]);
    }
}
