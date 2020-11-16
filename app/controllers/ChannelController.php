<?php
namespace app\controllers;

use app\models\Channel;
use app\models\Chart;
use fastphp\base\Controller;

class ChannelController extends Controller
{
    public function self()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            exit(header('location: /user/signin'));
        }
        $channelList = (new Channel)->where(['user_id = ?'], [$_SESSION['user_id']])->fetchAll();
        $this->assign('data', $channelList);
        $this->assign('page', 'Channel');
        $this->render();
    }

    public function target()
    {
        // if (isset($_GET['key'])) {
        //     $channelDetail = (new Channel)->where(['read_key = ?'], [$_GET['key']])->fetch();
        //     $chartDetail = (new Chart)->where(['channel_id = ?'], [$channelDetail['id']])->fetchAll();
        //     $this->assign('chart', $chartDetail);
        //     $this->assign('channel', $channelDetail);
        //     $this->assign('page', 'target');
        //     $this->render();
        // } else
        if (isset($_GET['id'])) {
            $channelDetail = (new Channel)->where(['id = ?'], [$_GET['id']])->fetch();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if ($channelDetail['is_public']) {
                $chartDetail = (new Chart)->where(['channel_id = ?'], [$_GET['id']])->fetchAll();
                $this->assign('chart', $chartDetail);
                $this->assign('channel', $channelDetail);
                $this->assign('page', 'target');
                $this->render();
            } elseif (isset($_SESSION['user_id'])) {
                if ($channelDetail['user_id'] == $_SESSION['user_id']) {
                    $chartDetail = (new Chart)->where(['channel_id = ?'], [$_GET['id']])->fetchAll();
                    $this->assign('chart', $chartDetail);
                    $this->assign('channel', $channelDetail);
                    $this->assign('page', 'target');
                    $this->render();
                } else {
                    exit(header('HTTP/1.1 403 Forbidden'));
                }
            } else {
                exit(header('HTTP/1.1 403 Forbidden'));
            }
        } else {
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }

    public function add()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            exit(header('location: /user/signin'));
        }
        if ($_POST) {
            $addArray = [];
            $addArray += ['user_id' => $_SESSION['user_id']];
            if (isset($_POST['name'])) {
                if (preg_match("/^([0-9A-Za-z]+)$/", $_POST['name'])) {
                    $addArray += ['name' => $_POST['name']];
                } else {
                    $this->assign('msg', 'cannot include invalid character -*/!@#$%^&*');
                }
                if (isset($_POST['isPublic'])) {
                    $addArray += ['is_public' => 1];
                }
                $writeKey = hash('md5', (int)(microtime(true)*1000));
                while ((new Channel)->where(['write_key = ?'], [$writeKey])->fetch()) {
                    $writeKey = hash('md5', (int)(microtime(true)*1000));
                }
                $readKey = hash('md5', $writeKey);
                $addArray += ['write_key' => $writeKey];
                $addArray += ['read_key' => $readKey];
                (new Channel)->add($addArray);
                $channelData = (new Channel)->where(['write_key = ?'], [$writeKey])->fetch();
                for ($i = 0; $i < 8; $i++) {
                    $addArray = [];
                    $addArray += ['channel_id' => $channelData['id']];
                    $addArray += ['title' => 'chart' . $i];
                    (new Chart)->add($addArray);
                }
                exit(header('location: /channel/self'));
            } else {
                exit(header('HTTP/1.1 403 Forbidden'));
            }
        } else {
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }

    public function edit()
    {
        if($_POST){
            if(isset($_POST['id']) & isset($_POST['name'])){
                (new Channel)->where(['id = :id'],[':id' => $_POST['id']])->update($_POST);
                if(!isset($_POST['is_public'])) (new Channel)->where(['id = :id'], [':id' => $_POST['id']])->update(['is_public'=>0]);
                header("location:" . $_SERVER['HTTP_REFERER']);
            }else {
                exit(header('HTTP/1.1 403 Forbidden'));
            }
        }else {
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }
    public function all()
    {
        print('???');
    }
}
