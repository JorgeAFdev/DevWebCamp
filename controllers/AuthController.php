<?php
namespace Controllers;

use Model\User;
use MVC\Router;
use Classes\Email;

class AuthController {
    public static function sign_in(Router $router) {
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);   
            $alerts = $user->validateLogin();

            if(empty($alerts)) {
                // Verify that the user exists
                $user = User::where('email', $user->email);

                if(!$user || !$user->confirmed) {
                    User::setAlert('error', 'no-user', 'User does not exist or is not confirmed');
                } else {
                    // User Exists
                    if(password_verify($_POST['password'], $user->password)) {
                        
                        // Log In
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['surname'] = $user->surname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['admin'] = $user->admin ?? null;

                        // Redirection
                        if($user->admin) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /complete-registration');
                        }
                    } else {
                        User::setAlert('error', 'inv_psw', 'Invalid Password');
                    }
                }
            }
        }
        $alerts = User::getAlerts();
    
        // Render the view
        $router->render('auth/signin', [
            'title' => 'Sign In',
            'alerts' => $alerts
        ]);
    }
    public static function sign_out() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
    }
    public static function sign_up(Router $router) {
        $alerts = [];
        $user = New User;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->synchronize($_POST);
            $alerts = $user->validateNewAccount();

            if(empty($alerts)) {
                $userExists = User::where('email', $user->email);

                if($userExists) {
                    User::setAlert('error', 'user_exists', 'The User is already registered');
                    $alerts = User::getAlerts();
                } else {
                    // Hash the Password
                    $user->hashPassword();

                    // Delete password 2
                    unset($user->password2);
                    // Generate Token
                    $user->createToken();

                    // Send Email
                    $email = New Email($user->name, $user->email, $user->token);
                    $email->sendConfirmation();

                    // Create new User
                    $result = $user->save();
                    if($result) {
                        header('Location: /message');
                    }
                }
            }
        }
        // Render the view
        $router->render('auth/signup', [
            'title' => 'Sign up',
            'user' => $user,
            'alerts' => $alerts
        ]);
    }
    public static function forgot_password(Router $router) {
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = New User($_POST);
            $alerts = $user->validateEmail();
            
            if(empty($alerts)) {
                // Find the user
                $user = User::where('email', $user->email);

                if($user && $user->confirmed) {
                    // Generate new Token
                    $user->createToken();
                    unset($user->password2);
                    // Update User
                    $user->save();

                    // Send Email
                    $email = New Email($user->name, $user->email, $user->token);
                    $email->sendInstructions();

                    // Show alert
                    User::setAlert('success', 'instructions', 'We have sent the instructions by email');
                } else {
                    User::setAlert('error', 'no-user','The user does not exist or is not confirmed');
                }
            }
        }
        $alerts = User::getAlerts();

        // Render the view
        $router->render('auth/forgot-password', [
            'title' => 'Forgot Password',
            'alerts' => $alerts
        ]);
    }
    public static function reset_password(Router $router) {
        $token = sanitizeHTML($_GET['token']);
        $show = true;
        if(!$token) header('Location: /');

        // identufy user by Token
        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlert('error', 'inv-token', 'Invalid Token');
            $show = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Add new password
            $user->synchronize($_POST);

            // Validate new password
            $alerts = $user->validatePassword();
            
            if(empty($alerts)) {
                // Hash the Password
                $user->hashPassword();
                unset($user->password2);

                // Delete token
                $user->token = null;

                // Save the user in the DB
                $result = $user->save();
                // redirect user
                if($result) {
                    header('Location: /signin');
                }
            }
        }
        $alerts  = User::getAlerts();
        
        // Render the view
        $router->render('auth/reset-password', [
            'title' => 'Reset Password',
            'alerts' => $alerts,
            'show' => $show
        ]);
    }    
    public static function message(Router $router) {
        $router->render('auth/message', [
            'title' => 'Account Successfully Created'
        ]);
    }
    public static function confirm(Router $router) {
        $alerts = [];
        $token = sanitizeHTML($_GET['token']);
        $user = User::where('token', $token);

        if(!$token) header('Location: /');
       
        if(empty($user)) {
            // Show error message
            User::setAlert('error', 'inv-token', 'Invalid Token, account not confirmed');
        } else {
            // Change to confirmed user
            $user->confirmed = 1;
            $user->token = null;
            unset($user->password2);

            // Save in the DB
            $user->save();
            User::setAlert('success', 'confirmed', 'Your account has been confirmed!');
        }
        // Get alerts
        $alerts = User::getAlerts();

        $router->render('auth/confirm', [
            'title' => 'Account Confirmed',
            'alerts' => $alerts
        ]);
    }
}