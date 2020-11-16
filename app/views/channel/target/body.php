<div class="container-table-2">
<?php
    for ($i=0; $i <count($chart) ; $i++) {
        print
        "
        <div class='box-m'>
            <div class='box-header'>
                <h3>".$chart[$i]['title']."
                <a href='javascript:void(0)' target='_blank' data-id='".$chart[$i]['id']."' onclick='deleteData(this)'>
                <i class='fas fa-trash-alt right'></i></i>
                </a>
                <a
                href='javascript:void(0)'
                class='right'
                id='Btn'
                data-modal-btn='Edit".$chart[$i]['title']."Modal'
                onclick='addModal(this)'
                >
                <i class='fas fa-edit right'></i>
                </a>
                <a href='/data/stream?id=".$chart[$i]['id']."' target='_blank'><i class='fas fa-database right'></i></a>
                </h3>
            </div>
            <div class='box-body'>
                <div style='width:100%; height: 350px;'
                id='chart$i'
                name='chart'
                data-chartid='".$chart[$i]['id']."'
                data-seriesname='".$chart[$i]['series_name']."'
                data-seriesunit='".$chart[$i]['series_unit']."'
                data-results='".$chart[$i]['results']."'
                data-type='".$chart[$i]['type']."'
                >
                    <!--
                    <iframe
                    style='width:100%; height: 100%; broder:none;'
                    frameborder='0'
                    src=
                    '/chart/index?id=".$chart[$i]['id']."&series_name=".$chart[$i]['series_name']."&series_unit=".$chart[$i]['series_unit']."&results=".$chart[$i]['results']."&type=".$chart[$i]['type']."&real=false'>
                    </iframe>
                    -->
                </div>
            </div>
        </div>
        "
        ;
    }
?>
</div>

