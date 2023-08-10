<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIEvents;
use Controllers\APIGifts;
use Controllers\APISpeakers;
use Controllers\AuthController;
use Controllers\GiftsController;
use Controllers\PagesController;
use Controllers\EventsController;
use Controllers\SpeakersController;
use Controllers\DashboardController;
use Controllers\RegisteredController;
use Controllers\RegistrationController;

$router = new Router();

// Sign In/Out
$router->get('/signin', [AuthController::class, 'sign_in']);
$router->post('/signin', [AuthController::class, 'sign_in']);
$router->post('/signout', [AuthController::class, 'sign_out']);

// Sign Up
$router->get('/signup', [AuthController::class, 'sign_up']);
$router->post('/signup', [AuthController::class, 'sign_up']);

// Forgot password form
$router->get('/forgot-password', [AuthController::class, 'forgot_password']);
$router->post('/forgot-password', [AuthController::class, 'forgot_password']);

// New Password
$router->get('/reset-password', [AuthController::class, 'reset_password']);
$router->post('/reset-password', [AuthController::class, 'reset_password']);

// Account confirmation
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirm', [AuthController::class, 'confirm']);

// Administration area
$router->get('/admin/dashboard', [DashboardController::class, 'index']);
$router->get('/admin/registered', [RegisteredController::class, 'index']);
$router->get('/admin/gifts', [GiftsController::class, 'index']);

// Speaker
$router->get('/admin/speakers', [SpeakersController::class, 'index']);
$router->get('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->post('/admin/speakers/create', [SpeakersController::class, 'create']);
$router->get('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/edit', [SpeakersController::class, 'edit']);
$router->post('/admin/speakers/delete', [SpeakersController::class, 'delete']);

// Events
$router->get('/admin/events', [EventsController::class, 'index']);
$router->get('/admin/events/create', [EventsController::class, 'create']);
$router->post('/admin/events/create', [EventsController::class, 'create']);
$router->get('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/edit', [EventsController::class, 'edit']);
$router->post('/admin/events/delete', [EventsController::class, 'delete']);

//API
$router->get('/api/events-schedule', [APIEvents::class, 'index']);
$router->get('/api/speakers', [APISpeakers::class, 'index']);
$router->get('/api/speaker', [APISpeakers::class, 'speaker']);
$router->get('/api/gifts', [APIGifts::class, 'index']);

// User Registration
$router->get('/complete-registration', [RegistrationController::class, 'create']);
$router->post('/complete-registration/free', [RegistrationController::class, 'free']);
$router->post('/complete-registration/pay', [RegistrationController::class, 'pay']);
$router->get('/complete-registration/conferences', [RegistrationController::class, 'conferences']);
$router->post('/complete-registration/conferences', [RegistrationController::class, 'conferences']);

// Virtual Ticket
$router->get('/ticket', [RegistrationController::class, 'ticket']);

// Public Area
$router->get('/', [PagesController::class, 'index']);
$router->get('/about', [PagesController::class, 'about']);
$router->get('/packages', [PagesController::class, 'packages']);
$router->get('/workshops-conferences', [PagesController::class, 'conferences']);
$router->get('/404', [PagesController::class, 'error']);

$router->checkRoutes();