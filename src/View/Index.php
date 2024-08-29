<?php
namespace View;

class Index extends View
{
    public function render(): void {
        require_once( __DIR__ . "/../../templates/index.html" );
    }
}
