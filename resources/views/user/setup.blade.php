@extends('layouts.auth')

@section('content')
    <section class="bg-home bg-circle-gradiant d-flex align-items-center">
        <div class="bg-overlay bg-overlay-white"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card form-signin p-4 rounded shadow">
                        <form  action="{{ route('dashboard.data.store') }}" method="POST">
                            @csrf
                            {{-- <a href="index.html"><img src="assets/images/logo-icon.png"
                                    class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a> --}}
                            <h5 class="mb-3 text-center">Isi Data Dengan Benar Untuk Menlajutkan Undanga Kamu!</h5>

                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Harry & Nia">
                                <label for="title">Title Undangan</label>
                            </div>

                            <div class="mb-3">
                                <label for="basic-url" class="form-label">Your vanity URL</label>
                                <div class="input-group ">
                                    <span class="input-group-text" id="basic-addon3">https://wayaenikah.com/</span>
                                    <input type="text" class="form-control" id="basic-url" name="slug"
                                        aria-describedby="basic-addon3 basic-addon4" placeholder="harrydannia">
                                </div>
                                <div id="nameValidationMessage" class="form-text"></div>
                                

                            </div>

                            <button class="btn btn-primary w-100 my-3" type="submit" id="next"
                                disabled>Lanjutkan!</button>
                        </form>
                        <form action="{{ route('dashboard.logout') }}" method="POST" class="">
                            @csrf
                            <button class="btn btn-danger w-100" type="submit">Log Out</button>
                        </form>
                        <p class="mb-0 text-muted mt-3 text-center">© 2024 Era Digital.</p>
                    </div>
                </div>
            </div>
        </div> <!--end container-->
    </section><!--end section-->
@endsection
