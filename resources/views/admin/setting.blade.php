<x-app-layout>
    <div class="row">
        <div id="alert-container"></div>
        <div class="col-lg-6 mt-4">
           @include('admin.setting.tableCategory')
        </div>
        <div class="col-lg-6 mt-4">
           @include('admin.setting.tableGift')
        </div>
    </div>
    <script>
        var urlCategory = "{{ url('/admin/categories/') }}"
    </script>
    <script src="{{ asset('assetDashboard/main/setting/editCategory.js') }}"></script>

</x-app-layout>
