<?php
namespace View;

class Card extends View
{
    public function __construct(
        protected \Repository\Card $card_repo,
    ) {}

    public function render( string $card_number = null ): void {
        $card_number = $card_number ?? $_POST['card_number'];

        if( ! isset( $card_number ) ) {
            http_response_code( 400 );
            die( "No card number provided!" );
        }

        if( ! \Card::validate( $card_number ) ) {
            http_response_code( 400 );
            die( "Invalid card number!" );
        }

        $card_number = trim( $card_number );

        $card = $this->card_repo->find_by_number( $card_number );

        if( ! $card ) {
            $new_card = "true";
            $return_money_class = "hidden";
            $new_card_info = "This is an unregistered card";
            $amount = 0;
        } else {
            $new_card = "false";
            $return_money_class = "";
            $new_card_info = "";
            $amount = $card->amount;
        }

        if( $card->amount <= 0 ) {
            $return_money_class = "hidden";
        }

        \Template::render( "card_details.html", [
            // TODO: get number formatting from settings
            "amount" => number_format( $amount, 2 ),
            "card_number" => $card_number,
            "new_card" => $new_card,
            "return_money_class" => $return_money_class,
            "new_card_info" => $new_card_info,
            "flash_messages" => \FlashMessages::render(),
        ] );
    }
}
