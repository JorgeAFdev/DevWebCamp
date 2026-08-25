<?php

namespace Controllers;

use Model\Event;

class APISpots
{
    public static function less()
    {
        if (!is_admin()) {
            echo json_encode([]);
            return;
        }

        $less_spots = Event::orderLimit('spots', 'ASC', 5);
        $lessSpots = [];
        foreach ($less_spots as $event) {
            $lessSpots[] = [
                'id' => $event->id,
                'name' => $event->name,
                'spots' => $event->spots
            ];
        }
        echo json_encode($lessSpots);
    }

    public static function more()
    {
        if (!is_admin()) {
            echo json_encode([]);
            return;
        }

        $more_spots = Event::orderLimit('spots', 'DESC', 5);
        $moreSpots = [];
        foreach ($more_spots as $event) {
            $moreSpots[] = [
                'id' => $event->id,
                'name' => $event->name,
                'spots' => $event->spots
            ];
        }
        echo json_encode($moreSpots);
    }
}
