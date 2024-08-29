<?php
namespace View;

class Index extends View
{
    public function render(): void {
        \Template::render( "index.html", [
            "flash_messages" => \FlashMessages::render(),
        ] );
    }
}
