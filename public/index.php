<?php

use Router\Route;
use Router\Router;

require_once( __DIR__ . "/../autoload.php" );

session_start();

// TODO: get credentials from settings
$db = new PDO("mysql:host=localhost;dbname=cardi", "cardi", "cardi");

$card_repo = new Repository\Card( $db );
$transaction_repo = new Repository\Transaction( $db );

$router = new Router( [
    "/" => new Route(
        view: \View\Index::class,
    ),
    "/card" => new Route(
        view: \View\Card::class,
        args: [$card_repo],
    ),
    "/card/([a-zA-Z0-9]+)" => new Route(
        view: \View\Card::class,
        args: [$card_repo],
    ),
    "/add_money" => new Route(
        view: \View\AddMoney::class,
        args: [$card_repo, $transaction_repo],
    ),
    "/return_money" => new Route(
        view: \View\ReturnMoney::class,
        args: [$card_repo, $transaction_repo],
    ),
] );

$router->route( $_SERVER['REQUEST_URI'] );
