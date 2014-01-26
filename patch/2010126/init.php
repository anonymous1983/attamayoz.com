<?php
/*
 * 
 * Update Cost from att_db_tree
 * 
 */
$sql = "
        UPDATE att_db_tree AS T SET cost = ( SELECT cost
        FROM att_db_tree_type AS TT
        WHERE TT.id_tree_type = t.id_tree_type ) 
        WHERE 1
        ";