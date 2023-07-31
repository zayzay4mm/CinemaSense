<?php
function alert($text,$icon) {
echo "
<script>
swal({
   text: '$text',
   icon: '$icon',
});
</script>";
}
function alert_redirect($text,$icon,$link) {
echo "
<script>
swal({
   text: '$text',
   icon: '$icon',
   }).then(function(){
    window.location = '$link';
});
</script>";
}
function alert_confirm_redirect($text,$icon,$link) {
echo "
swal({
  text: '$text',
  icon: 'warning',
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
     window.location.href = '$link';
  }
})";
}
?>