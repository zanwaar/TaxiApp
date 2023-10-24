<div>
    <main class="app containerw pb-5">

        <div class="my-3 p-3 ">
            <div class="d-flex justify-content-between">
                <h3 class="border-bottom border-gray pb-2 mb-0">Riwayat</h3>
                {!! $order->links() !!}
            </div>
            @forelse ($order as $index => $bg)
            <div class="list-group mb-2">
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <p> <small class="badge py-2 badge-{{ $bg->status_badge }} d-block d-sm-none">Status : {{$bg->status}}</small></p>
                    <div class="d-flex w-100 justify-content-between">
                        <h1 class="mb-1 text-muted">Layanan {{$bg->layanan}}</h1>

                        <p> <small class="badge badge-pill badge-{{ $bg->status_badge }} d-none d-sm-block">Status : {{$bg->status}}</small></p>
                    </div>
                    <span class="text-muted">{{ $bg->created_at->FormattedDate() ?? 'N/A' }}</span>
                    <h3 class="mb-1 text-primary">Rute Taxi - {{$bg->rute}}</h3>
                    <p class="mb-1">Nama Booking : {{$bg->namabooking}} <span class="badge-dark rounded px-2 ml-2"> {{$bg->notlpn}}</span></p>
                    <p class="mb-1">Alamat, {{$bg->alamat}}, Jumlah Penumpang : {{$bg->jumlah_penumpang}} Orang</p>

                    <h5 class="mt-3 text-success">Ulasan Rating Yang Diberikan Custommer</h5>
                    <p>Rating: {{ $bg->rating ? number_format($bg->rating->rating, 1) : 'N/A' }}
                        <span class="star-rating ml-2">
                            @for ($i = 1; $i <= 5; $i++) <i class="{{ $bg->rating && number_format($bg->rating->rating, 1) >= $i ? 'fas fa-star' : 'far fa-star' }}" data-rating="{{ $i }}"></i>
                                @endfor
                        </span>
                    </p>
                    <p>Ulasan: {{ $bg->rating ? $bg->rating->comment : 'No comment' }}</p>
                </div>
            </div>

            @empty
            <p class="mt-2">No results found</p>

            @endforelse
        </div>


    </main>

</div>
@push('css')
<style>
    .star-rating {
        line-height: 32px;
        font-size: 1.25em;
    }

    .star-rating .fas {
        color: yellow;
    }
</style>
@endpush