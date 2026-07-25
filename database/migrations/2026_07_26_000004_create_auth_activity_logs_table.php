<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auth_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->nullable()->index();
            $table->string('event_type', 64)->index();
            $table->string('status', 64)->default('success');
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->string('session_id')->nullable();
            $table->string('request_path')->nullable();
            $table->string('request_method', 12)->nullable();
            $table->string('risk_level', 16)->default('low')->index();
            $table->json('risk_reasons')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at')->index();
            $table->timestamps();

            $table->index(['ip_address', 'event_type', 'occurred_at'], 'auth_logs_ip_event_time_idx');
            $table->index(['user_id', 'event_type', 'occurred_at'], 'auth_logs_user_event_time_idx');
            $table->index(['email', 'event_type', 'occurred_at'], 'auth_logs_email_event_time_idx');
            $table->index(['created_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'suspended_at')) {
                $table->timestamp('suspended_at')->nullable()->after('email_verified_at')->index();
            }
            if (! Schema::hasColumn('users', 'suspension_reason')) {
                $table->text('suspension_reason')->nullable()->after('suspended_at');
            }
            if (! Schema::hasColumn('users', 'suspended_by')) {
                $table->foreignId('suspended_by')->nullable()->after('suspension_reason')->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            }
            if (! Schema::hasColumn('users', 'last_user_agent')) {
                $table->text('last_user_agent')->nullable()->after('last_login_ip');
            }
            if (! Schema::hasColumn('users', 'security_risk_level')) {
                $table->string('security_risk_level', 16)->default('low')->after('last_user_agent')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['suspended_by'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            foreach ([
                'suspended_at',
                'suspension_reason',
                'last_login_ip',
                'last_user_agent',
                'security_risk_level',
            ] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::dropIfExists('auth_activity_logs');
    }
};
