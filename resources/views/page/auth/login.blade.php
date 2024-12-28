@extends('layouts.auth')

@section('content')
    <section class="bg-home bg-circle-gradiant d-flex align-items-center">
        <div class="bg-overlay bg-overlay-white"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card form-signin p-4 rounded shadow">
                        <form action="{{route('login.auth')}}" method="POST">
                            @csrf
                            <a href="/"><img src="{{asset('logo/logo.svg')}}"
                                    class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a>
                            <h5 class="mb-3 text-center">Please sign in</h5>

                            <div class="form-floating mb-2">
                                <input type="email" class="form-control" name="email" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            {{-- <div class="d-flex justify-content-between">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                    </div>
                                </div>
                                <p class="forgot-pass mb-0"><a href="{{route('forgot.password')}}"
                                        class="text-dark small fw-bold">Forgot password ?</a></p>
                            </div> --}}

                            <button class="btn btn-primary w-100" type="submit">Sign in</button>

                            <div class="col-12 text-center mt-3">
                                <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a
                                        href="{{ route('register.index') }}" wire:navigate class="text-dark fw-bold">Sign Up</a>
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
