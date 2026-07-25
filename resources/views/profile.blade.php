<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    @livewireStyles
</head>
<body>
    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:profile.update-profile-information-form />
            </section>

            <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:profile.update-password-form />
            </section>

            <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:profile.delete-user-form />
            </section>
        </div>
    </main>
    @livewireScripts
</body>
</html>
