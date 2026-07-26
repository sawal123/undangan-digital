<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Forgot your password? Enter your email address to receive a password reset link.
    </div>

    <form method="POST" action="#">
        @csrf
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
        </div>
    </form>
</x-guest-layout>
