<?php
namespace app\controllers;

use app\models\User;
use fastphp\base\Controller;

class UserController extends Controller
{
    public function signup()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_name']) & isset($_SESSION['user_is_admin'])) {
            if ($_SESSION['user_is_admin']) {
                if ($_POST) {
                    if (isset($_POST['user']) & isset($_POST['psw']) & isset($_POST['ag-psw'])) {
                        if (preg_match("/^([0-9A-Za-z]+)$/", $_POST['user']) & preg_match("/^([0-9A-Za-z]+)$/", $_POST['psw'])) {
                            if ($_POST['psw'] == $_POST['ag-psw']) {
                                $psw = hash('sha256', $_POST['psw']);
                                (new User)->add(array(
                                    'name' => $_POST['user'],
                                    'password' => $psw,
                                ));
                                exit(header('location: /'));
                            } else {
                                $this->assign('msg', 'your password should be equal confirm password');
                            }

                        } else {
                            $this->assign('msg', 'cannot include invalid character -*/!@#$%^&*');
                        }

                    }
                }
                $this->assign('page', 'signup');
                $this->render();
            } else {
                exit(header('HTTP/1.1 403 Forbidden'));
            }
        } else {
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }

    public function signin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            exit(header('location: /'));
        }
        if ($_POST) {
            if (isset($_POST['user']) & isset($_POST['psw'])) {
                if (preg_match("/^([0-9A-Za-z]+)$/", $_POST['user']) & preg_match("/^([0-9A-Za-z]+)$/", $_POST['psw'])) {
                    $psw = hash('sha256', $_POST['psw']);
                    $userDetail = (new User)->where(["name = ?"], [$_POST['user']])->fetch();
                    if ($userDetail['name'] == $_POST['user']) {
                        if ($userDetail['password'] == $psw) {
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            $_SESSION['user_is_admin'] = $userDetail['is_admin'];
                            $_SESSION['user_id'] = $userDetail['id'];
                            $_SESSION['user_name'] = $_POST['user'];
                            exit(header('location: /'));
                        } else {
                            $this->assign('msg', 'user or password wrong');
                        }

                    } else {
                        $this->assign('msg', 'user or password wrong');
                    }

                } else {
                    $this->assign('msg', 'cannot include invalid character -*/!@#$%^&*');
                }

            }
        }
        $this->assign('page', 'signin');
        $this->render();
    }

    public function signout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        exit(header('location: /'));
    }
}
