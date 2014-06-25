<?php
function js_sh_rcount($mark, $key = true) 
{
    if ($key)
    echo '
    <script type="text/javascript">
    alert(' . "'" . " Правельних відповідей: " . $mark . "');
    </script>'";
}