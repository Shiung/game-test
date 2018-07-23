<?php

/**
 * Return sizes readable by humans
 */
function human_filesize($bytes, $decimals = 2)
{
  $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
  $factor = floor((strlen($bytes) - 1) / 3);

  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .
      @$size[$factor];
}

/**
 * Is the mime type an image
 */
function is_image($mimeType)
{
    $arr= ['jpg','jpeg','gif','png'];
    if(in_array($mimeType,$arr)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 檔案管理器開放選擇的檔案類型
 */
function is_selected($mimeType)
{
    $arr= ['jpg','xlsx','xls','jpeg','gif','png','zip','pdf'];
    if(in_array($mimeType,$arr)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 計算總額(有key)
 */
function sumDataAmountByKey($datas,$amount_key)
{
    $total = 0;
    foreach ($datas as  $data) {
      $total = $total + $data[$amount_key];
      
    }
    return $total;
}

/**
 * 計算總額(key為日期)
 */
function sumDataAmount($datas)
{
    $total = 0;
    foreach ($datas as $key =>  $amount) {
      $total = $total + $amount;
      
    }
    return $total;
}

/**
 * 格式化結束日期
 */
function formatEndDate($date)
{
  return date("Y-m-d", strtotime("+1 day",strtotime($date)));
}

/**
 * 計算兩個日期的天數差距
 */
function countDaysBetweenTwoDate($date_one,$date_two)
{
  $startdate=strtotime($date_one);
  $enddate=strtotime($date_two); 
  $days=round(($enddate-$startdate)/3600/24) ;
  return $days;
}

/**
 * 產生亂碼
 */
function randomkeys($length =6)
{
    $key = '';
    $pattern = "1234567890ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
    for($i=0;$i<$length;$i++){
    $key .= $pattern{rand(0,35)};
    }
    return $key;
}

/**
 * 檢查數字列表有沒有符合一定大小
 * @param $numbers,$min,$max
 */
function checkNumbersRangeValid($numbers, $min, $max)
{
    $arr = [];
    foreach ($numbers as $number) {
        if(in_array($number,$arr)){
            return false;
        }
        if($number >= $min && $number <= $max){
            array_push($arr,$number);
        }
    }
    if(count($arr) != count($numbers)){
        return false;
    } 
    return true;
}

/**
 * 取得預設起始、結束日期
 * @param day
 */
function getDefaultDateRange($day)
{
    //結束日期（今天日期）
    $end = date("Y-m-d");
    //開始日期
    $start = date("Y-m-d", strtotime("-".$day." days",strtotime($end)));
    return ['start' => $start,'end' => $end];
}

/**
 * 取得結束日期
 * @param $start_date,$type
 */
function getEndDateByType($start_date,$type)
{
  switch ($type) {

   case 'd':
    $end = date("Y-m-d", strtotime("+1 day",strtotime($start_date)));
    break;
   
   case 'w':
    $end = date("Y-m-d", strtotime("+1 week",strtotime($start_date)));
    break;

   case 'm':
    $end = date("Y-m-d", strtotime("+1 month",strtotime($start_date))); 

   case 'y':
    $end = date("Y-m-d", strtotime("+1 year",strtotime($start_date)));


   default:
    # code...
    break;
  }

  return $end;
}

//區間計算
function getPeriodDateRange($type,$subtract = 1)
{
  switch ($type) {

   case 'last_month':
    $start_date = date("Y-m-d", strtotime("first day of last month"));
    $end_date = date("Y-m")."-01";
    break;
   
   case 'this_month':
    $start_date = date("Y-m")."-01";
    $end_date = date("Y-m-d", strtotime("first day of next month"));
    break;

   case 'last_week':
    $this_week = date("W");
    $last_week = date("W", strtotime("-1 weeks"));
    $this_year = date("Y");
    if($last_week > $this_week)
     $last_year = $this_year-1;
    else
     $last_year = $this_year;

    $start_date = date("Y-m-d", strtotime($last_year."W".$last_week));
    $end_date = date("Y-m-d", strtotime($this_year."W".$this_week));
    break;

   case 'this_week':
    $this_week = date("W");
    $next_week = date("W", strtotime("+1 weeks"));
    $this_year = date("Y");
    if($next_week < $this_week)
     $next_year = $this_year+1;
    else
     $next_year = $this_year;

    $start_date = date("Y-m-d", strtotime($this_year."W".$this_week));
    $end_date = date("Y-m-d", strtotime($next_year."W".$next_week));
    break;

   case 'yesterday':
    $start_date = date("Y-m-d",strtotime("-1 days"));
    $end_date = date("Y-m-d");
    break;

   case 'today':
    $start_date = date("Y-m-d");
    $end_date = date("Y-m-d",strtotime("+1 days"));
    break;
   case 'all':
    $start_date = date("1970-01-01");
    $end_date = date("Y-m-d",strtotime("+1 days"));
    break;

   default:
    # code...
    break;
  }

  //結束日期減一天
  if($subtract == 1){
      $end =  date("Y-m-d", strtotime("-1 day",strtotime($end_date)));
  } else {
      $end =  $end_date;
  }
  
  return ['start'=>$start_date, 'end'=> $end];
}

/**
 * curl
 * @param $url,$data
 */
function curlApi($url,$data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $data['ip'] = getIpAddress();
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $data )); 
    $result = curl_exec($ch); 
    
    curl_close($ch);
    return $result;
}

/**
 * 取得ip
 */
function getIpAddress(){

  $ipaddress = '';
    if (!empty($_SERVER["HTTP_CLIENT_IP"]))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(!empty($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;

}

/**
 * 取得單一幣別最高下注額
 */
function getBetMaxAmount($amount,$number=9999999999){
  if($amount<=$number){
    return $amount;
  } else {
    return $number;
  }
  

}

/**
 * 千分位格式
 */
function thousandsFormat($amount,$return_value=''){
  if(!$amount || $amount == '' || $amount == ' '){
    return $return_value;
  } else {
    return number_format($amount);
  }
  

}