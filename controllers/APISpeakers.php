<?php
namespace Controllers;

use Model\Speaker;

class APISpeakers {
    public static function index() {
        if (!is_admin()) {
            echo json_encode([]);
            return;
        }
        $speakers = Speaker::all();
        echo json_encode($speakers);
    }

    public static function speaker() {
        if (!is_admin()) {
            echo json_encode([]);
            return;
        }
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id || $id < 1) {
            echo json_encode([]);
            return;
        }

        $speaker = Speaker::find($id);
        echo json_encode($speaker, JSON_UNESCAPED_SLASHES);

    }
}