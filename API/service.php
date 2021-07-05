<?php
// Get data
$id = isset($_GET["id"]) ? $_GET["id"] : '';
$date = isset($_GET["date"]) ? $_GET["date"] : '';
// data student
$arrContextOptions = array(
  "ssl" => array(
    "verify_peer" => false,
    "verify_peer_name" => false,
  ),
);

require_once __DIR__ . '/../pdf/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$style =
  '
<style>
.container{
    font-family: "Garuda";
}
.container .wrapper{
    font-size: 12pt;
    text-align: center;
}
h3{
  text-align: center;
  font-family: "Garuda";
  }
h4{
  font-family: "Garuda";
}
p{
  font-family: "Garuda";
}
/* วันที่ */
.date{
  position: relative;
  left: 60%;
}
#customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    font-family: "Garuda";
  }
  
  #customers td, #customers th {
    border: 1px solid #000;
    padding: 1px;
  }
  
  #customers tr:nth-child(even){background-color: #f2f2f2;}
  
  #customers tr:hover {background-color: #ddd;}
  
  #customers th {
    padding-top: 2px;
    padding-bottom: 2px;
    text-align: center;
    color: #000;
  }

</style>';
$mpdf->WriteHTML($style);

switch ($id) {
  case '1':
    $river = "ลุ่มน้ำสาละวิน";
    break;
  case '2':
    $river = "ลุ่มน้ำกกโขง";
    break;
  case '3':
    $river = "ลุ่มน้ำแม่กลอง";
    break;
}
$year = $date[0] . $date[1] . $date[2] . $date[3];
$year = $year + 543;
$m = $date[4] . $date[5];
switch ($m) {
  case '01':
    $month = "มกราคม";
    break;
  case '02':
    $month = "กุมภาพันธ์";
    break;
  case '03':
    $month = "มีนาคม";
    break;
  case '04':
    $month = "เมษายน";
    break;
  case '05':
    $month = "พฤษภาคม";
    break;
  case '06':
    $month = "มิถุนายน";
    break;
  case '07':
    $month = "กรกฎาคม";
    break;
  case '08':
    $month = "สิงหาคม";
    break;
  case '09':
    $month = "กันยายน";
    break;
  case '10':
    $month = "ตุลาคม";
    break;
  case '11':
    $month = "พฤศจิกายน";
    break;
  case '12':
    $month = "ธันวาคม";
    break;
}
$day = number_format($date[6] . $date[7]);
$format_date = $day . ' ' . $month . ' ' . $year;
$text = '
<div class = "container">
<img src = "assets/images/logo.gif" width = "120" height = "150" > <br>
    <div class="wrapper">
      โครงการพัฒนาระบบพยากรณ์และเตือนภัยทรัพยากรน้ำ<br>
      ศูนย์ป้องกันวิฤติน้ำกรมทรัพยากรน้ำ กระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม<br>
      180 ถนนพระรามที่ 6 ซอย 34 แขวงสามเสนใน เขตพญาไทย กรุงเทพมหานคร 10400<br>
      โทรศัพท์ 02-271-6000<br>
      <b>รายงานสถานการณ์น้ำ' . $river . ' ' . $format_date . '</b>
    </div>
    <b>1) สภาพภูมิอากาศ</b><br>
    ';
$mpdf->WriteHTML($text);
if ($id == 3) {
  $url = "https://tmd.go.th/xml/region_daily_forecast.php?RegionID=3";
} else {
  $url = "https://tmd.go.th/xml/region_daily_forecast.php?RegionID=1";
}
$xml = simplexml_load_file($url);

$text_1 = '
    <p>
    ' . $xml->channel->item->description . '
    </p>';
$mpdf->WriteHTML($text_1);

// date_default_timezone_set('Asia/Bangkok');
// $year_m = date("Ym");
// $day = date("d");
// $time = date("h");
// if (number_format($time) < 10) {
//   $day = number_format($day) - 1;
//   if ($day <= 0) {
//     $day = '30';
//   } else {
//     $day = '0' . $day;
//   }
//   $key = $year_m . $day . "10";
// } else {
//   $key = $year_m . '0' . $day . "10";
// }
$text_2 = '
    <img src = "assets/images/image1.jpg" width = "330" height = "260" >
    <img src = "http://www.satda.tmd.go.th/sat/' . $date . '10.jpg" width = "330" height = "260" ><br>
    <p><br>
    <b>2) สรุปสถานการณ์ฝน</b><br>
    &emsp;สรุปสถานการณ์ฝนในพื้นที่ลุ่มน้ำสาละวิน จากข้อมูลตรวจวัดปริมาณน้ำฝนของสถานีโทรมาตร โครงการพัฒนาระบบพยากรณ์และเตือนภัยทรัพยากรน้ำกรมทรัพยากรน้ำ สะสม 24 ชั่วโมง จากการประมวลผลข้อมูลภาพ NWP-WRF กรมอุตุนิยมวิทยา ดังแสดงในตาราง
    </p>
   ';
$mpdf->WriteHTML($text_2);
$table_1 = '
    <table id = "customers">
      <tr>
        <th rowspan="2">สถานีโทรมาตร</th>
        <th rowspan="2">ที่ตั้ง</th>
        <th colspan="3">ปริมาณฝนตรวจวัด<br>(มม./ วัน)</th>
        <th colspan="3">ปริมาณฝนคาดการณ์ล่วงหน้า<br>(มม./ วัน)</th>
      </tr>
      <tr>
        <th>เมื่อวาน</th>
        <th>ฝน2วัน</th>
        <th>ฝน3วัน</th>
        <th>วันนี้</th>
        <th>1วัน</th>
        <th>2วัน</th>
      </tr>';
$mpdf->WriteHTML($table_1);

$url = 'http://tele-salawin.dwr.go.th/Report/ReportForecast_Get';
$json = file_get_contents($url);
$json = json_decode($json);
$number = count($json);
for ($i = 0; $i < $number; $i++) {
  $loop_table_1 = '
      <tr>
        <td style = "text-align: center;">' . $json[$i]->STN_Name . '</td>
        <td style = "text-align: center;">' . $json[$i]->STN_Location . '</td>
        <td style = "text-align: center;">' . $json[$i]->BACK_Acc_Rain_1_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->BACK_Acc_Rain_2_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->BACK_Acc_Rain_3_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Acc_Rain_1_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Acc_Rain_2_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Acc_Rain_3_D . '</td>
      </tr>';
  $mpdf->WriteHTML($loop_table_1);
}

$end_table_1 = '
    </table>
    ';
$mpdf->WriteHTML($end_table_1);

$table_2 = '
    <p><br><br>
    <b>3) สรุประดับน้ำรายวัน</b><br>
    &emsp;สรุปสถานการณ์น้ำในพื้นที่ลุ่มน้ำสาละวิน จากข้อมูลการตรวจวัดระดับน้ำของสถานีโทรมาตรโครงการพัฒนาระบบพยากรณ์และเตือนภัยทรัพยากรน้ำ จากแบบจำลองทางคณิตศาสตร์ ดังแสดงในตาราง
    </p>


    <table id = "customers">
      <tr>
        <th rowspan="2">สถานีโทรมาตร</th>
        <th rowspan="2">ที่ตั้ง</th>
        <th rowspan="2">ระดับน้ำ<br>เตือนภัย</th>
        <th colspan="2">ระดับน้ำตรวจวัด<br>(ม.รทก)</th>
        <th colspan="4">ระดับน้ำคาดการณ์ล่วงหน้า<br>(ม.รทก)</th>
      </tr>
      <tr>
        <th>เมื่อวาน</th>
        <th>วันนี้</th>
        <th>1วัน</th>
        <th>2วัน</th>
        <th>3วัน</th>
        <th>4วัน</th>
      </tr>';
$mpdf->WriteHTML($table_2);

for ($i = 0; $i < $number; $i++) {
  $loop_table_2 = '
      <tr>
        <td style = "text-align: center;">' . $json[$i]->STN_Name . '</td>
        <td style = "text-align: center;">' . $json[$i]->STN_Location . '</td>
        <td style = "text-align: center;">' . $json[$i]->STN_Level_Critical . '</td>
        <td style = "text-align: center;">' . $json[$i]->CURR_Water_U_Level_MSL . '</td>
        <td style = "text-align: center;">' . $json[$i]->CURR_Water_D_Level_MSL . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Water_D_1_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Water_D_2_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Water_D_3_D . '</td>
        <td style = "text-align: center;">' . $json[$i]->FORC_Water_Trend . '</td>
      </tr>';
  $mpdf->WriteHTML($loop_table_2);
}

$end_table_2 = '
    </table>
</div>';
$mpdf->WriteHTML($end_table_2);
// $mpdf->AddPage();

$mpdf->Output();
