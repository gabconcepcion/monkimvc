<?php

echo '<br/>From applications/views/home/index.php:<br/>';
echo 'data:'.$data.'<br/>';
echo 'admin_constant:'.$admin_constant.'<br/>';
echo 'fruits: '.implode(', ', $fruits).'<br/>';  

echo '<br/>Check if private properties of View class will also be available on this view file<br/>';
echo '_private: '.$_private.'<br/>';   
echo '_public: '.$_public.'<br/>';
?>

<?php
function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

echo '<br/>MemoryUsage:'.convert(memory_get_usage(true)).'<br/>';