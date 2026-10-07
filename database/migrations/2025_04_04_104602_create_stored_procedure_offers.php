<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
// Removed unused imports

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS spGetOffers;
            CREATE PROCEDURE spGetOffers(IN varDep VARCHAR(255), IN varDes VARCHAR(255))
            BEGIN
                SELECT    TRIP.flight_number    AS FlightNo,
                          DEPA.country          AS DepCountry,
                          DEPA.airport          AS DepAirport,
                          TRIP.departure_date   AS DepDate,
                          TRIP.arrival_date     AS ArrDate,
                          TRIP.departure_time   AS DepTime,
                          TRIP.arrival_time     AS ArrTime,
                          DEST.country          AS DesCountry,
                          DEST.airport          AS DesAirport,
                          OFFER.offer_code      AS OfferCode,
                          OFFER.discount_percentage AS DiscountPercentage,
                          OFFER.valid_from      AS ValidFrom,
                          OFFER.valid_until     AS ValidUntil
                FROM    trips AS TRIP
                INNER JOIN departures AS DEPA
                    ON  DEPA.id =  TRIP.departure_id
                INNER JOIN destinations AS DEST
                    ON  DEST.id = TRIP.destination_id
                INNER JOIN offers AS OFFER
                    ON  OFFER.trip_id = TRIP.id;
            END;
        ');
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetOffers;');
    }
};
