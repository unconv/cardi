<?php
class FlashMessages
{
    public static function success( string $message ): void {
        if( ! isset( $_SESSION["flash_success"] ) || ! is_array( $_SESSION["flash_success"] ) ) {
            $_SESSION["flash_success"] = [];
        }

        $_SESSION["flash_success"][] = $message;
    }

    public static function error( string $message ): void {
        if( ! isset( $_SESSION["flash_error"] ) || ! is_array( $_SESSION["flash_error"] ) ) {
            $_SESSION["flash_error"] = [];
        }

        $_SESSION["flash_error"][] = $message;
    }

    public static function render(): string {
        $return = "";

        if( isset( $_SESSION["flash_error"] ) && is_array( $_SESSION["flash_error"] ) ) {
            foreach( $_SESSION["flash_error"] as $error ) {
                $return .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2.5" role="alert"><span class="block sm:inline">'.htmlspecialchars( $error ).'</span></div>';
            }
        }

        if( isset( $_SESSION["flash_success"] ) && is_array( $_SESSION["flash_success"] ) ) {
            foreach( $_SESSION["flash_success"] as $success ) {
                $return .= '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-2.5" role="alert"><span class="block sm:inline">'.htmlspecialchars( $success ).'</span></div>';
            }
        }

        $_SESSION['flash_success'] = [];
        $_SESSION['flash_error'] = [];

        return $return;
    }
}
