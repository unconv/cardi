<?php
namespace View;

class ReturnMoney extends View
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

        $card = $this->card_repo->find_by_number( $_POST['card_number'] );
        $amount = $card->amount * -1;

        if( ! $card ) {
            \Template::render("card_not_found.html");
        } else {
            $added = $this->transaction_repo->add_money( $card, $amount );

            if( ! $added ) {
                \FlashMessages::error( "Error returning money!" );
                header("Location: /card/" . $card->card_number);
                exit;
            } else {
                \Template::render("money_returned.html", [
                    // TODO: format number based on settings
                    "amount" => number_format( $card->amount, 2 ),
                ]);
            }
        }
    }
}
