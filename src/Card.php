<?php
class Card
{
    const CARD_NUMBER_MIN_LENGTH = 5;

    public function __construct(
        public int $id,
        public string $card_number,
        public float $amount,
        public \DateTime $registered_time
    ) {}

    /**
     * Validate the format of the card number
     *
     * @param string $card_number
     */
    public static function validate( string $card_number ): bool {
        $card_number = trim( $card_number );
        if( strlen( $card_number ) < self::CARD_NUMBER_MIN_LENGTH ) {
            return false;
        }

        return true;
    }
}
