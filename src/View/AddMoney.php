<?php
namespace View;

class AddMoney extends View
{
    public function __construct(
        protected \Repository\Card $card_repo,
        protected \Repository\Transaction $transaction_repo,
    ) {}

    public function render(): void {
        if( ! isset( $_POST['card_number'] ) ) {
            http_response_code( 400 );
            die( "No card number provided!" );
        }

        if( ! \Card::validate( $_POST['card_number'] ) ) {
            http_response_code( 400 );
            die( "Invalid card number" );
        }

        if( ! isset( $_POST['add_money'] ) ) {
            http_response_code( 400 );
            die( "No money amount provided!" );
        }

        if( isset( $_POST['new_card'] ) && $_POST['new_card'] === "true" ) {
            $this->card_repo->register_card( $_POST['card_number'] );
        }

        $card = $this->card_repo->find_by_number( $_POST['card_number'] );
        $amount = floatval( $_POST['add_money'] ); // TODO: use custom float conversion function

        if( ! $card ) {
            \Template::render("card_not_found.html");
        } else {
            $added = $this->transaction_repo->add_money( $card, $amount );

            if( ! $added ) {
                \FlashMessages::error( "Error adding money!" );
            } else {
                \FlashMessages::success( "Money added successfully!" );
            }

            header( "Location: /card/" . $card->card_number );
            exit;
        }
    }
}
