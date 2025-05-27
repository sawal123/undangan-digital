
<div class="card border-0">

    <div class="d-flex justify-content-between p-4 shadow rounded-top">
        <h6 class="fw-bold mb-0">Category</h6>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryForm">
            <i class="mdi mdi-folder-plus-outline"></i>
            Add Category
        </button>
        @include('admin.setting.modal-category')


    </div>
    <div class="table-responsive shadow rounded-bottom data-simplebar " style="height: 545px;">
        <table class="table table-center bg-white mb-0" id="category-table">
            <thead>
                <tr>
                    <th class="border-bottom p-3">No.</th>
                    <th class="border-bottom p-3" style="min-width: 220px;">Category</th>
                    <th class="text-end border-bottom p-3" style="min-width: 100px;">Preview</th>
                </tr>
            </thead>
            <tbody>
                <style>

                </style>
                <!-- Start -->
                @forelse ($categories as $index=>$category)
                    <tr>
                        <th class="p-3">{{ $index + 1 }}</th>
                        <td class="p-3">
                            <a href="#" class="text-primary">
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url($category->icon) }}"
                                        class="avatar avatar-ex-small rounded-circle shadow" alt="">
                                    <span class="ms-2">{{ $category->category }}</span>
                                </div>
                            </a>
                        </td>
                        <td class="text-end p-3 ">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editCategory{{ $category->id }}">Edit</button>
                                @include('admin.setting.modal-EditCategory')
                                <button class="deleteCategory btn btn-sm btn-danger"
                                    data-url="{{ route('admin.categories.destroy', $category->id) }}">
                                    Delete
                                </button>
                            </div>

                        </td>
                    </tr>

                @empty
                    <div class="alert  alert-info d-flex justify-content-center mx-auto" id="empty">
                        <strong>Category Masih Kosong!</strong>
                    </div>
                @endforelse
                <!-- End -->
            </tbody>
        </table>
    </div>
</div>
