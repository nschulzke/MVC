<?php

namespace util;

class HTTP
{
    const OK = 200;
    const BAD_REQUEST = 400;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;
    
    public static function json( $code = 200, $msg = '' )
    {
        http_response_code( $code );
        
        return json_encode( [ 'code' => $code, 'msg' => $msg ] );
    }
    
    public static function requireVars( $requestVars )
    {
        $msg = 'Missing required fields: ';
        $fail = false;
        foreach ( $requestVars as $var => $readable ) {
            if ( empty( $_REQUEST[$var] ) ) {
                $msg .= '<br/>' . $readable;
                $fail = true;
            }
        }
        if ( $fail ) {
            echo self::json( self::BAD_REQUEST, $msg );
            exit;
        }
    }
    
    public static function numericVars( $requestVars )
    {
        $msg = 'Fields must be numeric:';
        $fail = false;
        foreach ( $requestVars as $var => $readable ) {
            if ( !is_numeric( $_REQUEST[$var] ) ) {
                $msg .= "<br/>" . $readable;
                $fail = true;
            }
        }
        if ( $fail ) {
            echo self::json( self::BAD_REQUEST, $msg );
            exit;
        }
    }
    
    public static function constrainVars( $constraints )
    {
        $msg = '';
        $fail = false;
        foreach ( $constraints as $text => $pass ) {
            if ( !$pass ) {
                if ( !$fail )
                    $msg .= $text;
                else
                    $msg .= '<br/>' . $text;
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