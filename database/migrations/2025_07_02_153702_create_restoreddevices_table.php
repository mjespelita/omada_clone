<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restoreddevices', function (Blueprint $table) {
            $table->id();
$table->string('name');
$table->string('device_name');
$table->string('device_mac');
$table->string('device_type');
$table->string('status');
$table->string('siteId');
$table->string('ticket_number');
$table->longtext('reason');
$table->longtext('troubleshoot');
$table->boolean('isTrash')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restoreddevices');
    }
};
