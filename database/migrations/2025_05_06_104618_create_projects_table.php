<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('client_name');
            $table->string('project_manager')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'on_hold'])->default('planned');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->string('code')->unique();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
