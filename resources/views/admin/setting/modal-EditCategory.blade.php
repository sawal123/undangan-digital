<div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1"
    aria-labelledby="editCategory{{ $category->id }}-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="editCategory{{ $category->id }}-title">Edit Category</h5>
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal"
                    id="close-modal"><i class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <form id="dataCategory{{$category->id}}"  enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                <div class="modal-body">
                    <div class="p-3 rounded box-shadow">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="category" value="{{$category->category}}" id="category{{ $category->id }}"
                                placeholder="Category">
                            <label for="category">Category</label>
                            <div id="categoryMessage"></div>
                        </div>
                        <div class="form-floating mb-2 d-flex gap-2">
                            <img src="{{Storage::url($category->icon)}}" class="img-thumbnail " width="60" height="60" alt="" srcset="">
                            <input type="file" class="form-control" name="icon" id="icon{{ $category->id }}">
                            {{-- <label for="icon">Icon</label> --}}
                            <div id="iconMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary update-category" data-id="{{$category->id}}">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


