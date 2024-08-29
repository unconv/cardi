<?php
class Numbers
{
    public static function floatval( mixed $number ): float {
        // TODO: use custom float conversion function
        return floatval( $number );
    }

    public static function number_format( float $number ): string {
        // TODO: get number formatting from settings
        return number_format( $number, 2 );
    }
}
