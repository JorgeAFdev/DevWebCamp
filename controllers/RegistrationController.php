<?php

namespace Controllers;

use Model\Day;
use Model\Time;
use Model\User;
use MVC\Router;
use Model\Event;
use Model\Package;
use Model\Speaker;
use Model\Category;
use Model\EventsRegistrations;
use Model\Gift;
use Model\Registration;

class RegistrationController
{

    public static function create(Router $router)
    {
        if (!is_auth()) {
            header('Location: /');
            return;
        }

        // Verify if user is registered
        $registration = Registration::where('user_id', $_SESSION['id']);

        if (isset($registration) && ((int) $registration->package_id === 3 || (int) $registration->package_id === 2)) {
            header('Location: /ticket?id=' . urlencode($registration->token));
            return;
        }

        if (isset($registration) && (int) $registration->package_id === 1) {
            header('Location: /complete-registration/conferences');
            return;
        }

        $router->render('registration/create', [
            'title' => 'Complete Registration'
        ]);
    }

    public static function free()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /signin');
                return;
            }

            // Any existing registration, paid or free, blocks a second one;
            // /complete-registration sends the user to their ticket or conference picker
            $registration = Registration::where('user_id', $_SESSION['id']);
            if (isset($registration)) {
                header('Location: /complete-registration');
                return;
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            // Create registration
            $data = [
                'package_id' => 3,
                'pay_id' => '',
                'token' => $token,
                'user_id' => $_SESSION['id']
            ];

            $registration = new Registration($data);
            $result = $registration->save();

            if ($result) {
                header('Location: /ticket?id=' . urlencode($registration->token));
                return;
            }
        }
    }

    public static function ticket(Router $router)
    {

        // Validate URL
        $id = $_GET['id'];

        if (!$id || strlen($id) !== 8) {
            header('Location: /');
            return;
        }

        // Buscar en la DB
        $registration = Registration::where('token', $id);
        if (!$registration) {
            header('Location: /');
            return;
        }

        // Fill in the reference tables
        $user = User::find($registration->user_id);
        $package = Package::find($registration->package_id);

        $registrationData = [
            'registration' => $registration,
            'user' => $user,
            'package' => $package,
        ];

        $router->render('registration/ticket', [
            'title' => 'Attendance at DevWebCamp',
            'registration' => $registrationData
        ]);
    }

    public static function pay()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_auth()) {
                header('Location: /signin');
                return;
            }

            // Only paid packages (1 in-person, 2 online) go through this endpoint
            $package_id = filter_var($_POST['package_id'] ?? '', FILTER_VALIDATE_INT);
            $pay_id = trim($_POST['pay_id'] ?? '');

            if (!in_array($package_id, [1, 2], true) || $pay_id === '') {
                echo json_encode(['result' => false]);
                return;
            }

            // One registration per user, and one registration per payment
            if (Registration::where('user_id', $_SESSION['id']) || Registration::where('pay_id', $pay_id)) {
                echo json_encode(['result' => false]);
                return;
            }

            // Build the record field by field: copying $_POST let the client set id (overwriting
            // another user's registration through update()), user_id, token or gift_id
            $data = [
                'package_id' => $package_id,
                'pay_id' => $pay_id,
                'token' => substr(md5(uniqid(rand(), true)), 0, 8),
                'user_id' => $_SESSION['id']
            ];

            try {
                $registration = new Registration($data);
                $result = $registration->save();
                echo json_encode($result);
            } catch (\Throwable $th) {
                echo json_encode([
                    'result' => false
                ]);
            }
        }
    }

    public static function conferences(Router $router)
    {
        if (!is_auth()) {
            header('Location: /signin');
            return;
        }

        // Validate user has in-person plan
        $user_id = $_SESSION['id'];
        $registration = Registration::where('user_id', $user_id);

        if (isset($registration) && (int) $registration->package_id === 2) {
            header('Location: /ticket?id=' . urlencode($registration->token));
            return;
        }

        if ((int) $registration->package_id !== 1) {
            header('Location: /ticket?id=' . urlencode($registration->token));
            return;
        }

        // Redirect to virtual ticket in case registration is finished
        if ((int) $registration->gift_id !== 1) {
            header('Location: /ticket?id=' . urlencode($registration->token));
            return;
        }

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

            if ((int) $event->day_id === 1 && (int) $event->category_id === 1) {
                $formatted_events['conferences_f'][] = $formatted_event;
            }

            if ((int) $event->day_id === 2 && (int) $event->category_id === 1) {
                $formatted_events['conferences_s'][] = $formatted_event;
            }

            if ((int) $event->day_id === 1 && (int) $event->category_id === 2) {
                $formatted_events['workshops_f'][] = $formatted_event;
            }

            if ((int) $event->day_id === 2 && (int) $event->category_id === 2) {
                $formatted_events['workshops_s'][] = $formatted_event;
            }
        }

        $gifts = Gift::all('ASC');

        // Creating the registration with $_POST from the API
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_auth()) {
                header('Location: /signin');
                return;
            }

            $events = explode(',', $_POST['events_id']);
            if (empty($events)) {
                echo json_encode(['result' => false]);
                return;
            }

            // Get user registration
            $registration = Registration::where('user_id', $_SESSION['id']);
            if (!isset($registration) || (int) $registration->package_id !== 1) {
                echo json_encode(['result' => false]);
                return;
            }

            $events_array = [];
            // Validate the availability of the selected events
            foreach ($events as $event_id) {
                $event = Event::find($event_id);
                // Check that the event exists
                if (!isset($event) || (int) $event->spots === 0) {
                    echo json_encode(['result' => false]);
                    return;
                }
                $events_array[] = $event;
            }

            foreach ($events_array as $event) {
                $event->spots -= 1;
                $event->save();

                // Store registration
                $data = [
                    'event_id' => (int) $event->id,
                    'registration_id' => (int) $registration->id
                ];

                $user_registration = new EventsRegistrations($data);
                $user_registration->save();
            }

            // Store Gift
            $registration->synchronize(['gift_id' => $_POST['gift_id']]);
            $result = $registration->save();

            if ($result) {
                echo json_encode([
                    'result' => $result,
                    'token' => $registration->token
                ]);
            } else {
                echo json_encode(['result' => false]);
            }
            return;
        }

        $router->render('registration/conferences', [
            'title' => 'Choose Workshops and Conferences',
            'events' => $formatted_events,
            'gifts' => $gifts
        ]);
    }
}
