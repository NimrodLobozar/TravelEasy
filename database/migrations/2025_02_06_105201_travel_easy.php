<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->text('passport_details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->nullable()->constrained('people')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('password');
            $table->boolean('is_logged_in')->default(false);
            $table->timestamp('logged_in')->nullable();
            $table->timestamp('logged_out')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->string('relation_number')->unique();
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('addition')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->string('number')->unique();
            $table->enum('employee_type', ['Manager', 'Administrator', 'Desk Employee']);
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('airport');
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable(); 
            $table->timestamps();
        });

        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('airport');
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('departure_id')->constrained('departures')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('flight_number');
            $table->date('departure_date'); // Ensure this is defined as 'date'
            $table->time('departure_time');
            $table->date('arrival_date');   // Ensure this is defined as 'date'
            $table->time('arrival_time');
            $table->string('trip_status');
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // part of invoices
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->string('seat_number');
            $table->date('purchase_date');
            $table->time('purchase_time');
            $table->string('booking_status');
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->text('special_requests')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // invoices table T.T.
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('number')->unique();
            $table->date('date');
            $table->decimal('amount_excl_vat', 10, 2);
            $table->decimal('vat', 8, 2);
            $table->decimal('amount_incl_vat', 10, 2);
            $table->string('status');
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // Conversations table
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Messages table
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            // $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        // DB::statement('ALTER TABLE messages MODIFY is_read BIT(1) default 0');

    }

    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraints
        Schema::dropIfExists('messages'); // Add this
        Schema::dropIfExists('conversations'); // Add this
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('departures');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('people');
    }
};
