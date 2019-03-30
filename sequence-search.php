<?php

function search_GQuadruplex($sequence, $args = null) {
    // OLD: (?=((G{4})[ATGCN]{1,4}\2[ATGCN]{1,4}\2[ATGCN]{1,4}\2))

    preg_match_all('/G(?=((G{3})[ATGCN]{1,4}G\2[ATGCN]{1,4}G\2[ATGCN]{1,4}G\2))/i', $sequence, $matches);
}
