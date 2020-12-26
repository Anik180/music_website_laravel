<?php
/**
 * for any single value
 * @author MR
 */
function hybrid_first($table,$column,$case,$select) {
    $result = DB::table("$table")
            ->where("$column", $case)
            ->select($select)
            ->first();
    if (isset($result->$select)) {
        return $result->$select;
    } else {
        return null;
    }
}


function getYouTubeIdFromURL($url)
{
  $url_string = parse_url($url, PHP_URL_QUERY);
  parse_str($url_string, $args);
  return isset($args['v']) ? $args['v'] : false;
}