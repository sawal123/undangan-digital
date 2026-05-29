<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('birthday_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_id')->constrained('data')->cascadeOnDelete();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('parent_name')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $birthdayId = DB::table('event_types')->where('key', 'birthday')->value('id');

        if ($birthdayId) {
            DB::table('themes')
                ->whereNull('deleted_at')
                ->where(function ($query) {
                    $query->where('nama', 'like', '%ulang%')
                        ->orWhere('nama', 'like', '%ultah%')
                        ->orWhere('nama', 'like', '%birthday%')
                        ->orWhere('nama', 'like', '%spiderman%')
                        ->orWhere('path', 'like', '%ultah%')
                        ->orWhere('path', 'like', '%spiderman%')
                        ->orWhere('demo', 'like', '%ultah%')
                        ->orWhere('demo', 'like', '%spiderman%');
                })
                ->update(['event_type_id' => $birthdayId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birthday_profiles');
    }
};
