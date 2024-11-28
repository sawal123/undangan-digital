<!-- Modal Content Start -->
<div class="modal fade" id="categoryForm" tabindex="-1" aria-labelledby="categoryForm-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="categoryForm-title">Add Category</h5>
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <form  id="form-data" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="p-3 rounded box-shadow">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="category" id="category"
                                placeholder="Category">
                            <label for="category">Category</label>
                            <div id="categoryMessage"></div>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="file" class="form-control" name="icon" id="icon"
                               >
                            <div id="iconMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    var urlForm = "{{route('admin.categories.store')}}"
</script>
<script src="{{asset('assetDashboard/main/setting/ajax-category.js')}}"></script>
<!-- Modal Content End -->
