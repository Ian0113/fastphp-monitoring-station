<?php
namespace app\controllers;

use fastphp\base\Controller;
use app\models\Data;
use app\models\Channel;
use app\models\Chart;

class DataController extends Controller
{
    public function count()
    {
        if (isset($_GET['id'])) {
            $dataDetail = (new Data)->count($_GET['id']);
            $data = json_encode((int)($dataDetail[0]['count(id)']));
            $this->assign('data', $data);
            $this->assign('page', 'count');
            $this->render();
        }else{
            print('0');
        }
    }

    public function stream()
    {
        date_default_timezone_set('Asia/Taipei');
        if (isset($_GET['id'])) {
            $dataDetail = (new Data)->dstream($_GET['id']);
            if(count($dataDetail)>0){
                $plotData = [];
                if(isset($_GET['start']) & isset($_GET['results'])){
                    $j=0;
                    for ($i= $_GET['start']; $i < $_GET['start']+$_GET['results']; $i++) {
                        $plotData[$j] = array(round((float)($dataDetail[$i]['UNIX_TIMESTAMP(created_at)'])*1000), (float)($dataDetail[$i]['value']));
                        $j++;
                    }
                }else{
                    for ($i= 0; $i < count($dataDetail); $i++) {
                        $plotData[$i] = array(round((float)($dataDetail[$i]['UNIX_TIMESTAMP(created_at)'])*1000), (float)($dataDetail[$i]['value']));
                    }
                }
                $data = json_encode($plotData);
                $this->assign('data', $data);
                $this->assign('page', 'stream');
                $this->render();
            }else{
                print('[]');
            }
        }
    }

    public function update()
    {
        if (isset($_GET['key'])) {
            $channelDetail = (new Channel)->where(['write_key = ?'], [$_GET['key']])->fetch();
            $chartDetail = (new Chart)->where(['channel_id = ?'], [$channelDetail['id']])->fetchAll();
            for ($i=0; $i < count($chartDetail); $i++) {
                if(isset($_GET["chart$i"]))
                {
                    (new Data)->add([
                        'chart_id' => $chartDetail[$i]['id'],
                        'value' => $_GET["chart$i"]
                    ]);
                }
            }
            echo "su";
        }else {
            echo "ae";
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }

    public function delete()
    {
        if ($_POST) {
            if(isset($_POST['id'])){
                // $dataDetail = (new Data)->where('chart_id = ?', [$_POST['id']])->fetchAll();
                (new Data)->where(['chart_id = ?'], [$_POST['id']])->delete();
                // (new Data)->where(['chart_id = ?'], [$variable[$i]['chart_id']])->delete();
                // for ($i=0; $i < count($dataDetail); $i++) {
                // }
                header('HTTP/1.1 204 No Content');
            }else {
                exit(header('HTTP/1.1 403 Forbidden'));
            }
        }else {
            exit(header('HTTP/1.1 403 Forbidden'));
        }
    }
}
