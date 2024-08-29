<?php
namespace View;

class AddCharge extends View
{
    public function render(): void {
        \Template::render( "add_charge.html", [
            "flash_messages" => \FlashMessages::render(),
        ] );
    }
}
