@extends('layouts.auth')

@section('content')
    <section class="bg-home bg-circle-gradiant d-flex align-items-center">
        <div class="bg-overlay bg-overlay-white"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card form-signin p-4 rounded shadow">
                        <a href="/"><img src="{{ asset('logo/logo.svg') }}" width="80"
                                class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a>
                        <h5 class="mb-3 text-center">Please sign in</h5>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('login.auth') }}" method="POST">
                            @csrf


                            <div class="form-floating mb-2">
                                <input type="email" class="form-control" name="email" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>


                            <!-- Input Password dengan Heroicon -->
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <!-- Heroicons Eye Open -->
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Sign in</button>

                            <div class="col-12 text-center mt-3">
                                <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a
                                        href="{{ route('register.index') }}" wire:navigate class="text-dark fw-bold">Sign
                                        Up</a>
                                </p>
                            </div><!--end col-->

                            <p class="mb-0 text-muted mt-3 text-center">©
                                2025 Wayae Nikah.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!--end container-->
    </section><!--end section-->
@endsection
