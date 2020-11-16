<div id='666'>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script>
// var global_lastCount = 0;
var global_count = [0,0,0,0,0,0,0,0];
var global_chart = [null,null,null,null,null,null,null,null];
var isUpdating = {'left':false, 'right':false};
window.onload = function () {
  let allChart = document.getElementsByName('chart');
  for (let index = 0; index < allChart.length; index++) {
    const target = allChart[index];
    let seriesName = target.getAttribute("data-seriesname");
    let seriesUnit = target.getAttribute("data-seriesunit");
    let chartId = target.getAttribute("data-chartid");
    let results = target . getAttribute("data-results");
    let chartUrlCount = '/data/count?id='+chartId;
    let chartUrlData = '/data/stream?id='+chartId;
    let chart = newChart(target . getAttribute("id"), chartId, seriesName, seriesUnit);
    global_chart[index] = {'chart':chart, 'urlCount':chartUrlCount, 'urlData':chartUrlData};
    chart . showLoading('Init...');
  }
  isUpdating = true;
  initLazyChart(0, 2, 8);
  initLazyChart(1, 2, 8);
  setInterval(function () {
    if(!isUpdating){
      isUpdating = true;
      initLazyChart(0, 1, 8);
    }
  },5000);
}

function initLazyChart(start, jump, callSelfCount) {
  let index = start;
  const element = global_chart[index];
  $.ajax({
    async: true,
    type : "GET",
    url : element['urlCount'],
    dataType : 'json',
    success : function(json_count) {
      const count = json_count;
      if(count>global_count[index]){
        let results = json_count-global_count[index];
        let chart = element['chart'];
        chart . showLoading('Loading data from server...');
        $.ajax({
          async: true,
          type : "GET",
          url : element['urlData']+'&start='+ global_count[index] +'&results='+results,
          dataType : 'json',
          success : function(json_data) {
            const data = json_data;
            if(global_count[index] == 0){
              chart.series[0].setData(data);
            }else{
              for (let index = 0; index < data.length; index++) {
                  const newPoint = data[index];
                  chart.series[0].addPoint(newPoint, index == data.length-1, false);
              }
            }
            global_count[index] = count;
            chart.hideLoading();
            index+=jump;
            if(index<callSelfCount) initLazyChart(index, jump, callSelfCount);
            else isUpdating = false;
          }
        });
      }
      else if(count<global_count[index]){
        let results = json_count-global_count[index];
        let chart = element['chart'];
        chart . showLoading('Loading data from server...');
        $.ajax({
          async: true,
          type : "GET",
          url : element['urlData']+'&start='+ global_count[index] +'&results='+results,
          dataType : 'json',
          success : function(json_data) {
            const data = json_data;
            chart.series[0].setData(data);
            global_count[index] = count;
            chart.hideLoading();
            index+=jump;
            if(index<callSelfCount) initLazyChart(index, jump, callSelfCount);
            else isUpdating = false;
          }
        });
      }
      else{
        index+=jump;
        if(index<callSelfCount) initLazyChart(index, jump, callSelfCount);
        else isUpdating = false;
      }
    }
  });
}

function newChart(parameter_targetId, parameter_chartId, parameter_seriesName, parameter_seriesUnit) {
  return Highcharts.stockChart(parameter_targetId,{
    time: {
      useUTC: false
    },
    rangeSelector: {
      buttons: [{
        count: 1,
        type: 'minute',
        text: '1min'
      }, {
        count: 15,
        type: 'minute',
        text: '15min'
      }, {
        count: 1,
        type: 'hour',
        text: '1h'
      }, {
        count: 12,
        type: 'hour',
        text: '12h'
      }, {
        count: 1,
        type: 'day',
        text: '1d'
      }, {
        type: 'all',
        text: 'All'
      }],
      inputEnabled: false,
      selected: 5
    },
    exporting: {
      enabled: false
    },
    credits: {
        text: 'Lab-E422',
        href: '',
        style: {
            color: '#999999'
        }
    },
    series: [{
      data: null,
      name: parameter_seriesName
    }],
    plotOptions: {
      series: {
        // general options for all series
        turboThreshold:100000000,
        tooltip: {
          valueDecimals: 2,
          valueSuffix: parameter_seriesUnit
        },
        lineWidth: 0,
        marker: {
          enabled: true,
          radius: 2
        },
        states: {
          hover: {
            lineWidthPlus: 0
          }
        },
      },
      area: {
          // shared options for all area series
      }
    },
  });
}

function deleteData(elem) {
  chartId = elem.getAttribute("data-id");
  var ask=confirm("確定要清空?");
  if (ask==true)
  {
    $.post("/data/delete",{'id':chartId});
  }
}
</script>

<?php
for ($i=0; $i <count($chart) ; $i++) {
  print "
  <div class='modal'  id='Edit".$chart[$i]['title']."Modal' data-modal='Edit".$chart[$i]['title']."Modal'>
      <div class='box-m'>
          <div class='box-header'>
              <h3>".$chart[$i]['title']."</h3>
          </div>
          <div class='box-body'>
              <form action='/chart/edit' method='post'>
              <table class='c-container'>
                  <tbody>
                      <input name='id' type='text' required value='".$chart[$i]['id']."' style='display:none'>
                      <tr>
                          <td class='t-right'>Title:</td>
                          <td><input name='title' type='text' required autocomplete='off' value='".$chart[$i]['title']."'></td>
                      </tr>
                      <tr>
                          <td class='t-right'>Series Name:</td>
                          <td><input name='series_name' type='text' required autocomplete='off' value='".$chart[$i]['series_name']."'></td>
                      </tr>
                      <tr>
                          <td class='t-right'>Series Unit:</td>
                          <td><input name='series_unit' type='text' required autocomplete='off' value='".$chart[$i]['series_unit']."'></td>
                      </tr>
                      <tr>
                          <td align='center' colspan=2>
                              <input type='submit' value='Edit'>
                          </td>
                      </tr>
                  </tbody>
              </table>
              </form>
          </div>
      </div>
  </div>
  ";
}

print "
  <div class='modal'  id='Edit" . $channel['name'] . "Modal' data-modal='Edit" . $channel['name'] . "Modal'>
      <div class='box-m'>
          <div class='box-header'>
              <h3>" . $channel['name'] . "</h3>
          </div>
          <div class='box-body'>
              <form action='/channel/edit' method='post'>
              <table class='c-container'>
                  <tbody>
                      <input name='id' type='text' required value='" . $channel['id'] . "' style='display:none'>
                      <tr>
                          <td class='t-right'>Name:</td>
                          <td><input name='name' type='text' required autocomplete='off' value='" . $channel['name'] . "'></td>
                      </tr>
                      <tr>
                          <td class='t-right'>is_public:</td>
                          <td><input name='is_public' type='checkbox' autocomplete='off' ".($channel['is_public']==1 ? 'checked' : '')."></td>
                      </tr>
                      <tr>
                          <td align='center' colspan=2>
                              <input type='submit' value='Edit'>
                          </td>
                      </tr>
                  </tbody>
              </table>
              </form>
          </div>
      </div>
  </div>
  <div class='modal'  id='Update" . $channel['name'] . "Modal' data-modal='Update" . $channel['name'] . "Modal'>
      <div class='box-m'>
          <div class='box-header'>
              <h3>" . $channel['name'] . "</h3>
          </div>
          <div class='box-body'>
              <table class='c-container'>
                  <tbody>
                      <tr>
                          <td class='t-right'>Update:</td>
                          <td><div style='width:428px;overflow:auto;white-space: nowrap;'>".$_SERVER['HTTP_HOST']."/data/update?key=".$channel['write_key']."&chart0=</div></td>
                      </tr>
                      <tr>
                          <td class='t-right'>Read Key:</td>
                          <td>".$channel['read_key']."</td>
                      </tr>
                      <tr>
                          <td class='t-right'>Write Key:</td>
                          <td>".$channel['write_key']."</td>
                      </tr>
                  </tbody>
              </table>
              </form>
          </div>
      </div>
  </div>
  ";

