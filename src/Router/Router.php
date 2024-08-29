<?php
namespace Router;

class Router
{
    /**
     * Constructs the Router
     *
     * @param array<Route> $routes
     */
    public function __construct(
        public array $routes,
    ) {}

    public function route( string $uri ): void {
        if( strlen( $uri ) > 1 ) {
            $uri = rtrim( $uri, "/" );
        }

        foreach( $this->routes as $regex => $route ) {
            $pattern = "#^".$regex."/?$#";

            $matches = [];
            $match = preg_match_all( $pattern, $uri, $matches );
            if( $match === false ) {
                throw new \Exception("Error in route regex");
            }

            if( $match === 0 ) {
                continue;
            }

            $params = $matches[1] ?? [];

            if( is_a( $route->view, \View\View::class, true ) ) {
                /** @var \View\View $view */
                $view = new $route->view(...$route->args);
                $view->render( ...$params );
                return;
            } else {
                throw new \Exception( "The view for a route must be of type \\View\\View" );
            }
        }

        http_response_code( 404 );
        echo "Error! Not found!";
    }
}
