<?php
namespace Controllers;

use Classes\Pagination;
use MVC\Router;
use Model\Speaker;
use Intervention\Image\ImageManagerStatic as Image;


class SpeakersController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /sign-in');
            return;
        }

        $current_page = $_GET['page'] ?? '';
        $current_page = filter_var($current_page, FILTER_VALIDATE_INT);

        if(!$current_page || $current_page < 1) {
            header('location: /admin/speakers?page=1');
        }

        $records_per_page = 10;
        $total = Speaker::total();
        $pagination = New Pagination($current_page, $records_per_page, $total);
        
        if($pagination->total_pages() < $current_page) {
            header('location: /admin/speakers?page=1');
        }

        $speakers = Speaker::paginate($records_per_page, $pagination->offset());

        $router->render('admin/speakers/index', [
            'title' => 'Speakers',
            'speakers' => $speakers,
            'pagination' => $pagination->pagination()
        ]);
    }

    public static function create(Router $router) {
        if(!is_admin()) {
            header('Location: /sign-in');
            return;
        }
        $alerts = [];
        $speaker = new Speaker;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read the image
            if(!empty($_FILES['image']['tmp_name'])) {
                
                $image_folder = '../public/img/speakers';

                // Create folder if it doesn't exist
                if(!is_dir($image_folder)) {
                    mkdir($image_folder, 0755, true);
                }

                $image_png = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('png', 80);
                $image_webp = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('webp', 80);
                $image_name = md5(uniqid(rand(), true));
                $_POST['image'] = $image_name;
            }
            foreach($_POST['socials'] as $key => $value){
                if($value === ''){
                    unset($_POST['socials'][$key]);
                }
            }
            $_POST['socials'] = json_encode($_POST['socials'], JSON_UNESCAPED_SLASHES);
            $speaker->synchronize($_POST);

            // Validate
            $alerts = $speaker->validate();
            
            // Save Record
            if(empty($alerts)) {

                // Save images
                $image_png->save($image_folder . '/' . $image_name . ".png");
                $image_webp->save($image_folder . '/' . $image_name . ".webp");

                // Save in the Database
                $result = $speaker->save();

                if($result) {
                    header('Location: /admin/speakers');
                }
            }
        }
        $router->render('admin/speakers/create', [
            'title' => 'Register Speaker',
            'alerts' => $alerts,
            'speaker' => $speaker,
            'socials' => json_decode($speaker->socials)
        ]);
    }

    public static function edit(Router $router) {
        if(!is_admin()) {
            header('Location: /sign-in');
            return;
        }
        $alerts = [];

        // Validate ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/speakers');
        }

        // Get Speaker to Edit
        $speaker = Speaker::find($id);

        if(!$speaker) {
            header('Location: /admin/speakers');
        }

        $speaker->current_image = $speaker->image;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read the image
            if(!empty($_FILES['image']['tmp_name'])) {
                    
                $image_folder = '../public/img/speakers';

                // Create folder if it doesn't exist
                if(!is_dir($image_folder)) {
                    mkdir($image_folder, 0755, true);
                }

                $image_png = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('png', 80);
                $image_webp = Image::make($_FILES['image']['tmp_name'])->fit(800,800)->encode('webp', 80);
                $image_name = md5(uniqid(rand(), true));
                $_POST['image'] = $image_name;
            } else {
                $_POST['image'] = $speaker->current_image;
            }

            $_POST['socials'] = json_encode($_POST['socials'], JSON_UNESCAPED_SLASHES);
            $speaker->synchronize($_POST);

            $alerts = $speaker->validate();

            if(empty($alerts)) {
                if(isset($image_name)) {
                    $image_png->save($image_folder . '/' . $image_name . ".png");
                    $image_webp->save($image_folder . '/' . $image_name . ".webp");
                }
                $result = $speaker->save();
                
                if($result) {
                    header('Location: /admin/speakers');
                }
            }
        }

        // $socials = json_decode($speaker->socials);

        $router->render('admin/speakers/edit', [
            'title' => 'Update Speaker',
            'alerts' => $alerts,
            'speaker' => $speaker,
            'socials' => json_decode($speaker->socials)
        ]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /sign-in');
                return;
            }
            $id = $_POST['id'];
            $speaker = Speaker::find($id);
            if(!isset($speaker)) {
                header('Location: /admin/speakers');
            }

            // Delete the associated image
            $image_folder = '../public/img/speakers';
            $image_png_path = $image_folder . '/' . $speaker->image . '.png';
            $image_webp_path = $image_folder . '/' . $speaker->image . '.webp';

            // Check if the images exist and delete them
            if (file_exists($image_png_path)) {
                unlink($image_png_path);
            }
            if (file_exists($image_webp_path)) {
                unlink($image_webp_path);
            }

            $result = $speaker->delete();
            if($result) {
                header('Location: /admin/speakers');
            }
        }
    }
}