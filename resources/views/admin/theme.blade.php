<x-app-layout>
    <div class="row">
        <div class="col-xl mt-4">
            <div class="card border-0">
                <div id="alert-container"></div>
                <div class="d-flex justify-content-between p-4 shadow rounded-top">
                    <h6 class="fw-bold mb-0">Theme</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themeForm">
                        <i class="mdi mdi-folder-plus-outline"></i>
                        Add Theme
                    </button>
                    @include('admin.theme.modal-theme')
                </div>
                <div class="table-responsive shadow rounded-bottom data-simplebar " style="height: 545px;">
                    <table class="table table-center bg-white mb-0" id="category-table">
                        <thead>
                            <tr>
                                <th class="border-bottom p-3">No.</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Nama Undangan</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Category</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Path</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Demo</th>
                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Preview</th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>

                            </style>
                            <!-- Start -->
                            @forelse ($themes as $index=>$theme)
                                <tr>
                                    <th class="p-3">{{ $index + 1 }}</th>
                                    <td class="p-3">
                                        <a href="#" class="text-primary"
                                            data-img-src="{{ Storage::url($theme->thumbnail) }}" data-bs-toggle="modal"
                                            data-bs-target="#zoomImageModal">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ Storage::url($theme->thumbnail) }}"
                                                    class="avatar avatar-ex-small rounded-circle shadow" alt="">
                                                <span class="ms-2">{{ $theme->nama }}</span>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $theme->category->category }}</td>
                                    <td>
                                        {{ $theme->path }}
                                    </td>
                                    <td>
                                        {{-- {{ $theme->demo }} --}}
                                        <a href="{{ route('admin.temademo',  $theme->demo ) }}" class="">{{ $theme->demo }}</a>
                                    </td>
                                    <td class="text-end p-3 ">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editTheme" data-id="{{ $theme->id }}"
                                            data-nama="{{ $theme->nama }}" data-path="{{ $theme->path }}" data-demo="{{ $theme->demo }}"
                                            data-category="{{ $theme->category_id }}"
                                            data-thumbnail="{{ Storage::url($theme->thumbnail) }}">Edit</button>
                                        <button class="deletetheme btn btn-sm btn-danger"
                                            data-url="{{ route('admin.theme.destroy', $theme->id) }}">
                                            Delete
                                        </button>
                                        </div>
                                      
                                    </td>
                                </tr>

                            @empty
                                <div class="alert  alert-info d-flex justify-content-center mx-auto" id="empty">
                                    <strong>Theme Masih Kosong!</strong>
                                </div>
                            @endforelse
                            <!-- End -->
                        </tbody>
                    </table>
                    @include('admin.theme.modal-editTheme')
                    <!-- Modal Bootstrap untuk Zoom Image -->
                    <div class="modal fade" id="zoomImageModal" tabindex="-1" aria-labelledby="zoomImageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="uil uil-times fs-4 text-dark d-flex justify-content-center text-center"></i></button>
                                </div>
                                <div class="modal-body">
                                    <img src="" id="zoomedImage" class="img-fluid" alt="Zoomed Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div>


</x-app-layout>
