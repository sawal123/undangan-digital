<!-- Modal Content Start -->
<div class="modal fade" id="editTheme" tabindex="-1" aria-labelledby="editTheme-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="editTheme-title">Edit Theme</h5>
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <form id="update-theme" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="p-3 rounded box-shadow">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Undangan">
                            <label for="nama">Nama Undangan</label>
                            <div id="namaMessage"></div>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="path" id="path" placeholder="Path">
                            <label for="path">Path</label>
                            <div id="pathMessage"></div>
                        </div>
                        <select class="form-select form-floating mb-2" name="category_id" id="category" aria-label="Default select example">
                            <option selected disabled>Pilih Category</option>
                            @forelse ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @empty
                                <option disabled>Tidak Ada Category</option>
                            @endforelse
                        </select>
                        <div class="form-floating mb-2 d-flex gap-2">
                            <img src="" class="img-thumbnail" id="thumbnail" width="60" height="60" alt="">
                            <input type="file" class="form-control" name="thumbnail" id="thumbnail-input">
                            <div id="thumbnailMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
