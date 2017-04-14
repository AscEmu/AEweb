<?php
    // array of filenames
    $bg = array('bg-01.jpg', 'bg-02.jpg', 'bg-03.jpg', 'bg-04.jpg');
    // generate random number size of the array
    $i = rand(0, count($bg)-1);
    // set variable equal to which random filename was chosen
    $selectedBg = "$bg[$i]";
?>
<style type="text/css"> body{ background: url(images/<?php echo $selectedBg; ?>) no-repeat; } </style>
