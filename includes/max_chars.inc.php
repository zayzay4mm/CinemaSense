<?php 
function maxTitleChars($title,$chars) {
  $len = strlen($title);
  if ($len > $chars) {
     $title = substr($title,0,$chars);
     return $title.'....';
  } else {
     return $title;
  }
}
function maxContentChars($content,$chars) {
  $len = strlen($content);
  if ($len > $chars) {
     $content = substr($content,0,$chars);
     return $content.'....';
  } else {
     return $content;
  }
}
?>