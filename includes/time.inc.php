<?php 
function timeAgo($time) {
   $time_ago = array(
      31556926 => "year",
      2629743 => "month",
      604800 => "week",
      86400 => "day",
      3600 => "hour",
      60 => "minute",
      1 => "second"
   );
   foreach ($time_ago as $key=>$val) {
      if ($key <= $time) {
         $result = $time / $key ;
         $result = round($result);
         return $result.' '.$val.($result > 1 ? "s" : "")." ago";
      }
   }
}
?>