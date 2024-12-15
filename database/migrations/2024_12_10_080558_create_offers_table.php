<?php

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); #def fr id = listing_id
            $table->foreignIdFor(Listing::class)->constrained('listings');
            $table->foreignIdFor(User::class, 'bidder_id')->constrained('users');
            $table->unsignedInteger('amount'); #only positive values
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};