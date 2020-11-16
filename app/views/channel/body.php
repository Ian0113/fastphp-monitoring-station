<?php
$bodyFile = "app/views/$this->_controller/$page/body.php";
if (is_file($bodyFile)) include_once $bodyFile;
else{
?>
    <div class="box">
        <div class="box-body">
            <ul class="c-container line-all">
<?php
        for ($i=0; $i < count($data); $i++) {
        print
        '
            <li class="box-list">
                <a href="/channel/target?id='.$data[$i]['id'].'" class="row">
                    <div class="container-table-4">
                        <div class="box-msg">'.$data[$i]['name'].'</div>
                        <div class="box-msg">'.$data[$i]['write_key'].'</div>
                        <div class="box-msg">'.$data[$i]['read_key'].'</div>
                        <div class="box-msg">'.$data[$i]['created_at'].'</div>
                    </div>
                </a>
            </li>
        ';
        }
?>
            </ul>
        </div>
    </div>
<?php
}
