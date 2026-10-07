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
            DROP PROCEDURE IF EXISTS spCreateReis;
            CREATE PROCEDURE spCreateReis(
                IN employee_id INT,
                IN departure_country VARCHAR(255),
                IN departure_airport VARCHAR(255),
                IN arrival_country VARCHAR(255),
                IN arrival_airport VARCHAR(255),
                IN flight_number VARCHAR(255),
                IN departure_date DATE,
                IN departure_time TIME,
                IN arrival_date DATE,
                IN arrival_time TIME,
                IN trip_status VARCHAR(255),
                IN is_active BOOLEAN,
                IN note VARCHAR(255)
            )
            BEGIN
                INSERT INTO departures (country, airport)
                VALUES (departure_country, departure_airport);

                SET @departure_id = LAST_INSERT_ID();

                INSERT INTO destinations (country, airport)
                VALUES (arrival_country, arrival_airport);

                SET @destination_id = LAST_INSERT_ID();

                INSERT INTO trips (employee_id, departure_id, destination_id, flight_number, departure_date, departure_time, arrival_date, arrival_time, trip_status, is_active, note)
                VALUES (employee_id, @departure_id, @destination_id, flight_number, departure_date, departure_time, arrival_date, arrival_time, trip_status, is_active, note);
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateReis');
        DB::unprepared('DROP PROCEDURE IF EXISTS spEditReis');
    }
};
