<?php

function search_GQuadruplex(&$sequence, $args = null) {
    // OLD: (?=((G{4})[ATGCN]{1,4}\2[ATGCN]{1,4}\2[ATGCN]{1,4}\2))
    $start_time = microtime(true);

    preg_match_all('/G(?=((G{2})[ATGCN]{3,4}G\2[ATGCN]{3,4}G\2[ATGCN]{3,4}G\2))/i', $sequence, $matches, PREG_OFFSET_CAPTURE);

    echo "Time Taken (by Regex) = ", (microtime(true) - $start_time);

    return $matches;
}
