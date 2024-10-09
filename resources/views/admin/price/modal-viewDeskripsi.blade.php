<div class="modal fade" id="viewDeskripsi{{ $harga->id }}" tabindex="-1"
    aria-labelledby="viewDeskripsi{{ $harga->id }}-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i
                        class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <div class="modal-body">
                <div class="p-3 rounded box-shadow">
                    @forelse (json_decode($harga->deskripsi) as $item)
                        <div class="alert alert-primary">
                            {{ $item }}
                        </div>
                    @empty
                        <p>Data tidak ada</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
