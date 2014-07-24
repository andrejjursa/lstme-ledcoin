<?php

function get_inflection_by_numbers($number, $for_zero, $for_one, $for_two, $for_three, $for_four, $otherwise) {
    switch ((int)$number) {
        case 0: return $for_zero;
        case 1: return $for_one;
        case 2: return $for_two;
        case 3: return $for_three;
        case 4: return $for_four;
    }
    return $otherwise;
}