<?php

namespace App\Console\Commands;

use App\Models\AuthActivityLog;
use Illuminate\Console\Command;

class PruneAuthActivityLogs extends Command
{
    protected $signature = 'security:prune-auth-logs';

    protected $description = 'Prune authentication activity logs according to configured retention.';

    public function handle(): int
    {
        $standardCutoff = now()->subDays((int) config('security.auth_log_retention_days', 90));
        $highRiskCutoff = now()->subDays((int) config('security.auth_high_risk_retention_days', 365));

        $standard = AuthActivityLog::query()
            ->whereIn('risk_level', [AuthActivityLog::RISK_LOW, AuthActivityLog::RISK_MEDIUM])
            ->where('occurred_at', '<', $standardCutoff)
            ->delete();

        $highRisk = AuthActivityLog::query()
            ->whereIn('risk_level', [AuthActivityLog::RISK_HIGH, AuthActivityLog::RISK_CRITICAL])
            ->where('occurred_at', '<', $highRiskCutoff)
            ->delete();

        $this->info("Pruned {$standard} standard logs and {$highRisk} high-risk logs.");

        return self::SUCCESS;
    }
}
