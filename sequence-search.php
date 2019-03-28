<?php

function search_GQuadruplex($sequence) {
    preg_match_all('(?=((G{4})[ATGCN]{1,4}\2[ATGCN]{1,4}\2[ATGCN]{1,4}\2))', $sequence, $matches);
}
