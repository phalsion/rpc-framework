<?php

/**
 * log_path.php
 *
 * @author liqi created_at 2017/10/18下午5:37
 */
if ( !function_exists('logPath') ) {
    function logPath( $path )
    {
        if ( substr($path, 0, 1) != '@' ) {
            return $path;
        }

        return env('') . substr($path, 1);
    }
}
