<?php
namespace View;

class ChargeCard extends View
{
    public function __construct(
        protected \Repository\Card $card_repo,
        protected \Repository\Transaction $transaction_repo,
    ) {}

    public function render(): void {
        if( ! isset( $_POST['payment_amount'] ) ) {
            \Template::render( "error.html", [
                "error" => "Payment amount missing",
                "back" => "/add_charge",
            ] );
            exit;
        }

        $amount = \Numbers::floatval( $_POST['payment_amount'] );

        if( isset( $_POST['card_number'] ) ) {
            $card = $this->card_repo->find_by_number( $_POST['card_number'] );

            if( ! $card ) {
                \FlashMessages::error( "Card does not exist!" );
            }

            if( $card->amount < $amount ) {
                \FlashMessages::error( sprintf(
                    "There's only %s on the card. You need %s more",
                    \Numbers::number_format( $card->amount ),
                    \Numbers::number_format( $amount - $card->amount )
                ) );
            } else {
                $added = $this->transaction_repo->add_charge( $card, $amount );

                if( ! $added ) {
                    \FlashMessages::error( "Unable to add charge!" );
                } else {
                    \FlashMessages::success( sprintf(
                        "Charged card successfully! There is %s left",
                        \Numbers::number_format( $card->amount - $amount ),
                    ) );

                    header("Location: /add_charge");
                    exit;
                }
            }
        }

        \Template::render( "charge_card.html", [
            "flash_messages" => \FlashMessages::render(),
            "payment_amount" => (string) $amount,
            "payment_amount_fmt" => \Numbers::number_format( $amount ),
        ] );
    }
}
