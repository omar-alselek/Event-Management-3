<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Store existing data
        $bookings = DB::table('bookings')->get();
        
        // Drop the existing column
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        // Add the column back with new enum values
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending')->after('attendee_names');
        });
        
        // Restore the data
        foreach ($bookings as $booking) {
            DB::table('bookings')
                ->where('id', $booking->id)
                ->update(['status' => $booking->status]);
        }
    }

    public function down(): void
    {
        // Store existing data
        $bookings = DB::table('bookings')->get();
        
        // Drop the column
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        // Add the column back with original enum values
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending')->after('attendee_names');
        });
        
        // Restore the data, converting 'completed' to 'confirmed'
        foreach ($bookings as $booking) {
            $status = $booking->status === 'completed' ? 'confirmed' : $booking->status;
            DB::table('bookings')
                ->where('id', $booking->id)
                ->update(['status' => $status]);
        }
    }
}; 