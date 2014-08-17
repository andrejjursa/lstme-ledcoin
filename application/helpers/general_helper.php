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

/** 
 * Recursively delete a directory.
 * @param string $dir directory name.
 * @param boolean $delete_root_too delete specified top-level directory as well. 
 */ 
function unlink_recursive($dir, $delete_root_too) { 
    if(!$dh = @opendir($dir)) { return; } 
    
    while (FALSE !== ($obj = readdir($dh))) { 
        if($obj == '.' || $obj == '..') { continue; } 

        if (!@unlink($dir . '/' . $obj)) { 
            unlink_recursive($dir.'/'.$obj, TRUE); 
        } 
    } 

    closedir($dh); 
    
    if ($delete_root_too) { @rmdir($dir); } 
    
    return; 
} 