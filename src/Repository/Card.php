<?php
namespace Repository;

class Card
{
    public function __construct(
        protected \PDO $db,
    ) {}

    public function find_by_number( string $number ): \Card|null {
        $number = trim( $number );

        $stmt = $this->db->prepare( "SELECT * FROM cards WHERE card_number = :card_number" );
        $stmt->execute( [
            ":card_number" => $number,
        ] );

        // TODO: doesn't work on SQLite?
        if( ! $stmt->rowCount() ) {
            return null;
        }

        $card = $stmt->fetch( \PDO::FETCH_ASSOC );

        return new \Card(
            id: $card["id"],
            card_number: $card["card_number"],
            amount: $card["amount"],
            registered_time: new \DateTime( $card["registered_time"] ),
        );
    }

    public function register_card( string $card_number ): bool {
        if( ! \Card::validate( $card_number ) ) {
            return false;
        }

        // TODO: check if card is registered already
        $stmt = $this->db->prepare( "INSERT INTO cards (card_number) VALUES (:card_number)" );
        $stmt->execute( [
            ":card_number" => $card_number,
        ] );

        return true;
    }
}
