@extends('layouts.auth')

@section('content')
<section class="bg-home bg-circle-gradiant d-flex align-items-center">
    <div class="bg-overlay bg-overlay-white"></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card form-signin p-4 rounded shadow">
                    <form>
                        <a href="index.html"><img src="assets/images/logo-icon.png" class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a>
                        <h5 class="mb-3 text-center">Register your account</h5>
                    
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Harry">
                            <label for="floatingInput">First Name</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com">
                            <label for="floatingEmail">Email Address</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                    
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">I Accept <a href="#" class="text-primary">Terms And Condition</a></label>
                        </div>
        
                        <button class="btn btn-primary w-100" type="submit">Register</button>

                        <div class="col-12 text-center mt-3">
                            <p class="mb-0 mt-3"><small class="text-dark me-2">Already have an account ?</small> <a href="{{route('login')}}" wire:navigate class="text-dark fw-bold">Sign in</a></p>
                        </div><!--end col-->
                        <p class="mb-0 text-muted mt-3 text-center">© 2024 Era Digital.</p>
                    </form>
                </div>
            </div>
        </div>
    </div> <!--end container-->
</section><!--end section-->
@endsection