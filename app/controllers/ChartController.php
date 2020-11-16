<?php
namespace app\controllers;

use fastphp\base\Controller;
use app\models\Chart;

class ChartController extends Controller
{
    public function edit(){
        if($_POST){
            if(isset($_POST['id']) & isset($_POST['title']) & isset($_POST['series_name']) & isset($_POST['series_unit'])){
                (new Chart)->where(['id = :id'],[':id' => $_POST['id']])->update($_POST);
                 header("location:".$_SERVER['HTTP_REFERER']);
            }else {
                exit(header('HTTP/1.1 403 Forbidden'));
            }
        }else {
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }
}