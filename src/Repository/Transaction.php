<?php
namespace Repository;

class Transaction
{
    public function __construct(
        protected \PDO $db,
    ) {}

    public function add_money( \Card $card, float $amount ): bool {
        $stmt = $this->db->prepare( "INSERT INTO transactions (card_id, amount) VALUES(:card_id, :amount)" );
        $stmt->execute( [
            ":card_id" => $card->id,
            ":amount" => $amount,
        ] );

        $this->update_card_amount( $card, $amount );

        // TODO: check for erros?

        return true;
    }

    public function add_charge( \Card $card, float $amount ): bool {
        if( $amount < 0 ) {
            throw new \Exception( "Charge amount must be positive" );
        }

        $stmt = $this->db->prepare( "INSERT INTO transactions (card_id, amount) VALUES(:card_id, :amount)" );
        $stmt->execute( [
            ":card_id" => $card->id,
            ":amount" => -$amount,
        ] );

        $this->update_card_amount( $card, -$amount );

        // TODO: check for erros?

        return true;
    }

    public function update_card_amount( \Card $card, float $amount ): bool {
        $stmt = $this->db->prepare( "UPDATE cards SET amount = amount + :new_amount WHERE id = :card_id" );
        $stmt->execute( [
            ":card_id" => $card->id,
            ":new_amount" => $amount,
        ] );

        // TODO: check for erros?

        return true;
    }
}
