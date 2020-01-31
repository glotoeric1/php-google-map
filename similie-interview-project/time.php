<?php 
echo '<span style="font-size: 17px; font-weight: bold; color: #fff;" id="ct" ></span>'; ?>
<script type="text/javascript"> 
    function display_ct() {
        var x = new Date()
            var x1=x.toUTCString();// changing the display to UTC string
            document.getElementById('ct').innerHTML = x1;
        tt=display_c();
 }

 </script>



