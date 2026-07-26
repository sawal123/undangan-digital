<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Keamanan</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitoring autentikasi, rate limit, dan percobaan akses tidak sah.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 mb-6">
        @foreach([
            'Login Berhasil' => $summary['login_success_today'],
            'Login Gagal' => $summary['login_failed_today'],
            'Registrasi' => $summary['register_today'],
            'Belum Verified' => $summary['unverified_users'],
            'IP Rate Limit' => $summary['rate_limited_ips'],
            'High Risk' => $summary['high_risk'],
        ] as $label => $value)
            <x-ui.card padding="p-4">
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $label }}</p>
                <p class="text-xl font-semibold text-slate-800 dark:text-white mt-1">{{ $value }}</p>
            </x-ui.card>
        @endforeach
    </div>

    <x-ui.card padding="p-4" class="mb-6">
        <div class="grid md:grid-cols-4 xl:grid-cols-8 gap-3">
            <x-ui.select wire:model.live="eventType" label="Jenis">
                <option value="">Semua</option>
                @foreach($eventTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </x-ui.select>
            <x-ui.select wire:model.live="riskLevel" label="Risk">
                <option value="">Semua</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </x-ui.select>
            <x-ui.input wire:model.live="status" label="Status" placeholder="success" />
            <x-ui.input wire:model.live="email" label="Email" placeholder="email" />
            <x-ui.input wire:model.live="ip" label="IP" placeholder="127.0.0.1" />
            <x-ui.input wire:model.live="date" label="Tanggal" type="date" />
            <x-ui.select wire:model.live="accountStatus" label="Akun">
                <option value="">Semua</option>
                <option value="verified">Verified</option>
                <option value="unverified">Belum Verified</option>
                <option value="suspended">Suspended</option>
            </x-ui.select>
            <div class="flex items-end">
                <x-ui.button type="button" variant="secondary" wire:click="resetFilters">Reset</x-ui.button>
            </div>
        </div>
    </x-ui.card>

    <x-ui.table
        :headers="['Waktu', 'Nama', 'Email', 'Aktivitas', 'Hasil', 'IP', 'Perangkat', 'Risk', 'Alasan']"
        title="Aktivitas Login dan Keamanan"
        :count="$logs->total()"
    >
        @foreach($logs as $log)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-xs whitespace-nowrap text-slate-600 dark:text-slate-400">{{ $log->occurred_at?->format('d M Y H:i:s') }}</td>
                <td class="px-5 py-3.5 text-sm text-slate-700 dark:text-slate-300">{{ $log->user?->name ?? '-' }}</td>
                <td class="px-5 py-3.5 text-sm text-slate-700 dark:text-slate-300">{{ $log->email ?? '-' }}</td>
                <td class="px-5 py-3.5 text-xs font-medium text-slate-700 dark:text-slate-300">{{ $log->event_type }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-600 dark:text-slate-400">{{ $log->status }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-600 dark:text-slate-400">{{ $log->ip_address ?? '-' }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-600 dark:text-slate-400 max-w-xs truncate" title="{{ $log->user_agent }}">{{ $log->user_agent ?? '-' }}</td>
                <td class="px-5 py-3.5 text-xs font-semibold {{ in_array($log->risk_level, ['high', 'critical']) ? 'text-rose-600' : 'text-slate-500' }}">{{ ucfirst($log->risk_level) }}</td>
                <td class="px-5 py-3.5 text-xs text-slate-600 dark:text-slate-400 max-w-sm">
                    {{ implode(', ', $log->risk_reasons ?? []) ?: '-' }}
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $logs->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>
</div>
