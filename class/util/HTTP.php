<?php

namespace util;

class HTTP
{
    const OK = 200;
    const BAD_REQUEST = 400;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;
    
    public static function json( $code = 200, $msg = '' ) {
        http_response_code($code);
        return json_encode( [ 'code' => $code, 'msg' => $msg ] );
    }
    
    public static function requireVars( $requestVars ) {
        $msg = 'Missing required fields: ';
        $fail = false;
        foreach ( $requestVars as $var => $readable )
        {
            if ( empty($_REQUEST[$var]) ) {
                if ( !$fail )
                    $msg .= $readable;
                else
                    $msg .= ', ' . $readable;
                $fail = true;
            }
        }
        if ( $fail ) {
            echo self::json( self::BAD_REQUEST, $msg );
            exit;
        }
    }
    
    private function __construct()
    {
    }
    
    private function __clone()
    {
    }
}