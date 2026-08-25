<?php

namespace Controllers;

use Model\Gift;
use Model\Registration;

class APIGifts
{
    public static function index()
    {
        if (!is_admin()) {
            echo json_encode([]);
            return;
        }
        $gifts = Gift::all();
        $formattedGifts = [];
        
        foreach ($gifts as $gift) {
            $formattedGifts[] = [
                'id' => $gift->id,
                'name' => $gift->name,
                'total' => Registration::totalArray(['gift_id' => $gift->id, 'package_id' => "1"]),
            ];
        }

        echo json_encode($formattedGifts);
        return;
    }
}
