<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
DROP PROCEDURE IF EXISTS spGetTripDetails;
CREATE PROCEDURE spGetTripDetails(IN varDep VARCHAR(255), IN varDes VARCHAR(255))
BEGIN
    IF varDep IS NULL AND varDes IS NULL THEN
        SELECT DISTINCT country FROM departures;
    ELSE
        SELECT    TRIP.flight_number    AS FlightNo
                ,DEPA.country          AS DepCountry
                ,DEPA.airport          AS DepAirport
                ,DEST.country          AS DesCountry
                ,DEST.airport          AS DesAirport
                
        FROM    trips AS TRIP
        
        INNER JOIN departures AS DEPA
            ON  DEPA.id =  TRIP.departure_id
                
        INNER JOIN destinations AS DEST
            ON  DEST.id = TRIP.destination_id
                
        WHERE   TRIP.is_active = 1
          AND   DEPA.country = varDep COLLATE utf8mb4_0900_ai_ci
          AND   DEST.country = varDes COLLATE utf8mb4_0900_ai_ci;
    END IF;
END ;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetTripDetails;');
    }
};
