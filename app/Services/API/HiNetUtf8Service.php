<?php
namespace App\Services\API;


class HiNetUtf8Service{

   var $usenet_handle;    /* socket handle*/
   var $ret_code;
   var $ret_msg;
   var $send_msisdn="";
   var $send_msg_len=266; /* Socket ¶Ç°e SendMsg ªºªø«×¬°266 */
   var $ret_msg_len=244;  /* Socket ±µ¦¬ RetMsg ªºªø«×¬°244 */
   var $send_set_len=100;
   var $send_content_len=160;
   
   function sms2(){  }

   /* ¨ç¦¡»¡©ú¡G«Ø¥ß³s½u»P»{ÃÒ
    * $server_ip:¦øªA¾¹IP, $server_port:¦øªA¾¹Port, $TimeOut:³s½utimeout®É¶¡
    * $user_acc:±b¸¹, $user_pwd:±K½X
    * return -1¡Gºô¸ô³s½u¥¢±Ñ, 0¡G³s½u»P»{ÃÒ¦¨¥\, 1:³s½u¦¨¥\¡A»{ÃÒ¥¢±Ñ
    */
   function create_conn($server_ip, $server_port, $TimeOut, $user_acc, $user_pwd){
      $msg_type=0;      /* 0:ÀË¬d±b¸¹±K½X 1:¶Ç°eÂ²°T 2:¬d¸ß¶Ç°eµ²ªG */

      $this->usenet_handle = fsockopen($server_ip, $server_port, $errno, $errstr, $TimeOut);
      if(!$this->usenet_handle) {
          $this->ret_code=-1;
          $this->ret_msg="Connection failed!";
          return $this->ret_code;
      }
      /* ±b¸¹±K½XÀË¬d */
      $msg_set=$user_acc . "\0" . $user_pwd . "\0";
      $in_temp = pack("C",$msg_type) . pack("C",1) . pack("C",1) . pack("C",0) . pack("C",strlen($msg_set)) . pack("C",0) . $msg_set;
      
      /*---±N¥¼º¡$send_msg_lenªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_msg_len - strlen($in_temp);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      
      $in = $in_temp . $zero_buf;
      $out = '';
      $write = fwrite ($this->usenet_handle, $in);
      $out = fread ($this->usenet_handle, $this->ret_msg_len);
      /* ¨ú¥Xret_code */
      $ret_C = substr($out, 0, 1);           /* ¨ú¥X ret_code */
      $ret_code_array = unpack("C", $ret_C); /* ±N$ret_C Âà¦¨unsigned char , unpack ·|return array*/
      $ret_code_value = each ($ret_code_array);    /* array[1]¬°ret_codeªº­È */
      /* ¨ú¥Xret_content*/
      $ret_CL = substr($out, 3, 1);          /* ¨ú¥X ret_content_len */
      $ret_cl_array = unpack("C", $ret_CL);  /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_content_len = each ($ret_cl_array); /* array[1]¬°ret_content_lenªº­È */
      $ret_content = substr($out, 84, $ret_content_len[1]); /* ¨ú±o¦^¶Çªº¤º®e*/

      $this->ret_code=$ret_code_value[1];  /* array[1]¬°ret_codeªº­È */
      $this->ret_msg=$ret_content;
      return $this->ret_code;
   }   

   /* ¨ç¦¡»¡©ú¡G¶Ç°e¤å¦rÂ²°T
    * $tel:±µ¦¬ªù¸¹, Â²°T¤º®e
    * return ret_code
    */
   function send_text( $mobile_number, $message){       
        if(substr($mobile_number, 0, 1)== "+" ){
          $msg_type=15; /* ¶Ç°e°ê»ÚÂ²°T */
      }else{
          $msg_type=1; /* ¶Ç°e°ê¤ºÂ²°T */
      }
          
      $send_type="01"; /* 01 : §Y®É¶Ç°e*/
      $msg_set_str=$mobile_number . "\0" . $send_type . "\0";

      /*---±N¥¼º¡$msg_setªø«×ªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_set_len - strlen($msg_set_str);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      $msg_set = $msg_set_str . $zero_buf;
   
      /*---±N¥¼º¡$msg_contentªø«×ªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_content_len - strlen($message);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      $msg_content = $message . $zero_buf;
         
      $in = pack("C",$msg_type) . pack("C",4) . pack("C",1) . pack("C",0) . pack("C",strlen($msg_set_str)) . pack("C",strlen($message)) . $msg_set . $msg_content;
      
      $write = fwrite ($this->usenet_handle, $in);
      $out = fread ($this->usenet_handle, $this->ret_msg_len);
      $ret_C = substr($out, 0, 1); /* ¨ú¥X ret_code */
      $ret_code_array = unpack("C", $ret_C); /* ±N$ret_C Âà¦¨unsigned char , unpack ·|return array*/
      $ret_code_value = each ($ret_code_array); /* array[1]¬°ret_codeªº­È */
   
      $ret_CL = substr($out, 3, 1); /* ¨ú¥X ret_content_len */
      $ret_cl_array = unpack("C", $ret_CL); /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_content_len = each ($ret_cl_array); /* array[1]¬°ret_content_lenªº­È */
      $ret_content = substr($out, 84, $ret_content_len[1]); /* ¨ú±o¦^¶Çªº¤º®e*/
      
      $this->ret_code=$ret_code_value[1];  /* array[1]¬°ret_codeªº­È */
      $this->ret_msg=$ret_content;
      return $this->ret_code;
   }


   /* ¨ç¦¡»¡©ú¡G¶Ç°eWapPushÂ²°T
    * $tel:±µ¦¬ªù¸¹, Â²°T¤º®e
    * return ret_code
    */
   function send_wappush( $mobile_number, $wap_title, $wap_url){
      $msg_type=13; /* ¶Ç°eÂ²°T */
      $send_type="01"; /* 01:SI*/
      $msg_set_str=$mobile_number . "\0" . $send_type . "\0";

      /*---±N¥¼º¡$msg_setªø«×ªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_set_len - strlen($msg_set_str);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      $msg_set = $msg_set_str . $zero_buf;
   
      /*---±N¥¼º¡$msg_contentªø«×ªº¸ê®Æ¶ñ\0¸Éº¡ */
      $msg_content_tmp = $wap_url . "\0" . $wap_title . "\0";
      $len_p = $this->send_content_len - strlen($msg_content_tmp);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      $msg_content = $msg_content_tmp . $zero_buf;
   
      $in = pack("C",$msg_type) . pack("C",4) . pack("C",1) . pack("C",0) . pack("C",strlen($msg_set_str)) . pack("C",strlen($msg_content_tmp)) . $msg_set . $msg_content;
      
      $write = fwrite ($this->usenet_handle, $in);
      $out = fread ($this->usenet_handle, $this->ret_msg_len);
      $ret_C = substr($out, 0, 1); /* ¨ú¥X ret_code */
      $ret_code_array = unpack("C", $ret_C); /* ±N$ret_C Âà¦¨unsigned char , unpack ·|return array*/
      $ret_code_value = each ($ret_code_array); /* array[1]¬°ret_codeªº­È */
   
      $ret_CL = substr($out, 3, 1); /* ¨ú¥X ret_content_len */
      $ret_cl_array = unpack("C", $ret_CL); /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_content_len = each ($ret_cl_array); /* array[1]¬°ret_content_lenªº­È */
      $ret_content = substr($out, 84, $ret_content_len[1]); /* ¨ú±o¦^¶Çªº¤º®e*/
      
      $this->ret_code=$ret_code_value[1];  /* array[1]¬°ret_codeªº­È */
      $this->ret_msg=$ret_content;
      return $this->ret_code;
   }

   /* ¨ç¦¡»¡©ú¡G¬d¸ßtextµo°Tµ²ªG
    * $messageid:°T®§ID
    * return ret_code
    */
   function query_text( $messageid){
      $msg_type=2; /* ¬d¸ßtext¶Ç°eµ²ªG */
      $msg_set=$messageid;
      $in_temp = pack("C",$msg_type) . pack("C",1) . pack("C",1) . pack("C",0) . pack("C",strlen($msg_set)) . pack("C",0) . $msg_set;
      
      /*---±N¥¼º¡$send_msg_lenªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_msg_len - strlen($in_temp);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      
      $in = $in_temp . $zero_buf;
      $out = '';
      $write = fwrite ($this->usenet_handle, $in);
      $out = fread ($this->usenet_handle, $this->ret_msg_len);
      $ret_C = substr($out, 0, 1); /* ¨ú¥X ret_code */
      $ret_code_array = unpack("C", $ret_C); /* ±N$ret_C Âà¦¨unsigned char , unpack ·|return array*/
      $ret_code_value = each ($ret_code_array); /* array[1]¬°ret_codeªº­È */
   
      $ret_CL = substr($out, 3, 1); /* ¨ú¥X ret_content_len */
      $ret_cl_array = unpack("C", $ret_CL); /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_content_len = each ($ret_cl_array); /* array[1]¬°ret_content_lenªº­È */
      $ret_content = substr($out, 84, $ret_content_len[1]); /* ¨ú±o¦^¶Çªº¤º®e*/
      
      $this->ret_code=$ret_code_value[1];  /* array[1]¬°ret_codeªº­È */
      $this->ret_msg=$ret_content;
      return $this->ret_code;
   }


   /* ¨ç¦¡»¡©ú¡G¬d¸ßwappushµo°Tµ²ªG
    * $messageid:°T®§ID
    * return ret_code
    */
   function query_wappush( $messageid){
      $msg_type=14; /* ¬d¸ßwappush¶Ç°eµ²ªG */
      $msg_set=$messageid;
      $in_temp = pack("C",$msg_type) . pack("C",1) . pack("C",1) . pack("C",0) . pack("C",strlen($msg_set)) . pack("C",0) . $msg_set;
      
      /*---±N¥¼º¡$send_msg_lenªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_msg_len - strlen($in_temp);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      
      $in = $in_temp . $zero_buf;
      $out = '';
      $write = fwrite ($this->usenet_handle, $in);
      $out = fread ($this->usenet_handle, $this->ret_msg_len);
      $ret_C = substr($out, 0, 1); /* ¨ú¥X ret_code */
      $ret_code_array = unpack("C", $ret_C); /* ±N$ret_C Âà¦¨unsigned char , unpack ·|return array*/
      $ret_code_value = each ($ret_code_array); /* array[1]¬°ret_codeªº­È */
   
      $ret_CL = substr($out, 3, 1); /* ¨ú¥X ret_content_len */
      $ret_cl_array = unpack("C", $ret_CL); /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_content_len = each ($ret_cl_array); /* array[1]¬°ret_content_lenªº­È */
      $ret_content = substr($out, 84, $ret_content_len[1]); /* ¨ú±o¦^¶Çªº¤º®e*/
      
      $this->ret_code=$ret_code_value[1];  /* array[1]¬°ret_codeªº­È */
      $this->ret_msg=$ret_content;
      return $this->ret_code;
   }

   /* ¨ç¦¡»¡©ú¡G±µ¦¬¦^¶Çªº°T®§
    * return ret_code
    */
   function recv_msg(){
      $msg_type=3; /* ±µ¦¬¦^¶Çªº°T®§ */
      $msg_set="";
      $in_temp = pack("C",$msg_type) . pack("C",1) . pack("C",1) . pack("C",0) . pack("C",strlen($msg_set)) . pack("C",0) . $msg_set;
      
      /*---±N¥¼º¡$send_msg_lenªº¸ê®Æ¶ñ\0¸Éº¡ */
      $len_p = $this->send_msg_len - strlen($in_temp);
      $zero_buf='';
      for($i=0;$i<$len_p;$i++){
         $zero_buf = $zero_buf . "\0";
      }
      
      $in = $in_temp . $zero_buf;
      $out = '';
      $write = fwrite ($this->usenet_handle, $in);
      $out = fread ($this->usenet_handle, $this->ret_msg_len);
      $ret_C = substr($out, 0, 1); /* ¨ú¥X ret_code */
      $ret_code_array = unpack("C", $ret_C); /* ±N$ret_C Âà¦¨unsigned char , unpack ·|return array*/
      $ret_code_value = each ($ret_code_array); /* array[1]¬°ret_codeªº­È */

      $ret_CL = substr($out, 2, 1); /* ¨ú¥X ret_set_len */
      $ret_cl_array = unpack("C", $ret_CL); /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_set_len = each ($ret_cl_array); /* array[1]¬°ret_set_lenªº­È */
      $ret_set = substr($out, 4, $ret_set_len[1]); /* ¨ú±o¦^¶Çsetªº¤º®e*/
      $send_msisdn_array = split('\x0',$ret_set); /* ¨ú±o¶Ç¦^ªÌªº¤â¾÷ªù¸¹*/

      $ret_CL = substr($out, 3, 1); /* ¨ú¥X ret_content_len */
      $ret_cl_array = unpack("C", $ret_CL); /* ±N$ret_CL Âà¦¨unsigned char , unpack ·|return array*/
      $ret_content_len = each ($ret_cl_array); /* array[1]¬°ret_content_lenªº­È */
      $ret_content = substr($out, 84, $ret_content_len[1]); /* ¨ú±o¦^¶Çªº¤º®e*/
      
      $this->ret_code=$ret_code_value[1];  /* array[1]¬°ret_codeªº­È */
      $this->ret_msg=$ret_content;
      $this->send_msisdn=$send_msisdn_array[0]; /* array[0]¬°¦^¶ÇªÌªºªù¸¹ */
      return $this->ret_code;
   }   

   /* ¦^¶Çret_contentªº­È */
   function get_ret_msg(){
      return $this->ret_msg;
   }

   /* ¦^¶Çsend_telªº­È */
   function get_send_tel(){
      return $this->send_msisdn;
   }
  
   /* Ãö³¬³s½u */
   function close_conn(){
        if($this->usenet_handle)
         fclose ($this->usenet_handle);
   }
}