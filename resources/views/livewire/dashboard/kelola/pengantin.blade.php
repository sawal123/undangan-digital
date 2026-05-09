<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Data Pengantin</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Silahkan isi dan perbarui informasi pengantin Pria dan Wanita.</p>
        </div>
    </div>

    <!-- Pria & Wanita Components -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pria -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5">
            <livewire:dashboard-demo.kelola.pria :data-id="$dataId" />
        </div>
        <!-- Wanita -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5">
            <livewire:dashboard-demo.kelola.wanita :data-id="$dataId" />
        </div>
    </div>
</div>
