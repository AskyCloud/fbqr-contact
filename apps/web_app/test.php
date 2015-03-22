<?php

// Test Source
function Test5_1() {

    /* The Test */
    $t = microtime(true);
    for($i = 0; $i < 1000000; ++$i);

    return (microtime(true) - $t);
}

?>