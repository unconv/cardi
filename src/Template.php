<?php
class Template
{
    /**
     * Render a template
     *
     * @param string $template_file Template file name from "templates" folder or an absolute path to a template
     * @param array<string, string> $args Variables to be used in the template
     */
    public static function render( string $template_file, array $args = [] ): void {
        if( strpos( $template_file, "/" ) !== 0 ) {
            $template_file = __DIR__ . "/../templates/" . $template_file;
        }

        if( ! file_exists( $template_file ) ) {
            throw new \Exception( sprintf( "Template file %s does not exist!", $template_file ) );
        }

        $template = file_get_contents( $template_file );

        if( ! $template ) {
            throw new \Exception( sprintf( "Unable to read template file %s", $template_file ) );
        }
        $find = [];
        $replace = [];

        foreach( $args as $variable => $value ) {
            $find[] = "{{ $variable }}";
            $replace[] = $value;
        }

        $template = str_replace( $find, $replace, $template );

        echo $template;
    }
}
