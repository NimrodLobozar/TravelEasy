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
                ,TRIP.departure_date   AS DepDate
                ,TRIP.arrival_date     AS ArrDate
                ,TRIP.departure_time   AS DepTime
                ,TRIP.arrival_time     AS ArrTime
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

DROP PROCEDURE IF EXISTS spGetAvailableDates;
CREATE PROCEDURE spGetAvailableDates(IN varDep VARCHAR(255), IN varDes VARCHAR(255))
BEGIN
    SELECT DISTINCT departure_date
    FROM trips
    INNER JOIN departures ON trips.departure_id = departures.id
    INNER JOIN destinations ON trips.destination_id = destinations.id
    WHERE departures.country = varDep COLLATE utf8mb4_0900_ai_ci
      AND destinations.country = varDes COLLATE utf8mb4_0900_ai_ci
      AND trips.is_active = 1;
END;

DROP PROCEDURE IF EXISTS spGetDestinationsByDeparture;
CREATE PROCEDURE spGetDestinationsByDeparture(IN varDep VARCHAR(255))
BEGIN
    SELECT DISTINCT DEST.country
    FROM trips
    INNER JOIN departures ON trips.departure_id = departures.id
    INNER JOIN destinations ON trips.destination_id = destinations.id
    WHERE departures.country = varDep COLLATE utf8mb4_0900_ai_ci
      AND trips.is_active = 1;
END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetTripDetails;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAvailableDates;');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetDestinationsByDeparture;');
    }
};
