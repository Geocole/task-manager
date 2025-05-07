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
            $table->string('name'); // nom du projet
            $table->text('description')->nullable(); // résumé du projet
            $table->string('client_name'); // nom du client
            $table->string('project_manager')->nullable(); // chef de projet
            $table->decimal('budget', 12, 2)->nullable(); // budget alloué
            $table->enum('status', ['planned', 'in_progress', 'completed', 'on_hold'])->default('planned');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('delivery_date')->nullable(); // date de livraison effective
            $table->string('location')->nullable(); // lieu d'exécution
            $table->string('category')->nullable(); // ex: IT, BTP, Design...
            $table->string('code')->unique(); // code projet ex: PRJ-2025-001
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
