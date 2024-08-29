<?php
namespace Router;

class Route
{
    /**
     * Constructs a Route
     *
     * @param string $view Classname of the view
     * @param array<mixed> $args Arguments passed to the view constructor
     */
    public function __construct(
        public string $view,
        public array $args = [],
    ) {}
}
