<div>
    <main class="app containerw pb-5">
        <div class="pb-3">
            <a href="{{ route('order') }}" class="btn btn-light rounded shadow-sm "> Transaksi</a>
            <a href="{{ route('history') }}" class="btn btn-dark rounded shadow-sm  mx-3 ">History Transaksi</a>
        </div>

        <div class="my-3 p-3 bg-white rounded box-shadow">
            <h6 class="border-bottom border-gray pb-2 mb-0">Riwayat</h6>
            @forelse ($orders as $index => $order)
            <div class="media text-muted pt-3">
                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <strong class="text-gray-dark">DRIVER {{$order->driver->nama }} - {{$order->driver->nopolisi}}</strong>
                        <!-- <a href="#" class="badge-success px-2 rounded">Beri Ulasan</a> -->
                        <button type="button" wire:click.prevent="uls({{ $order }})" class="btn btn-sm btn-primary">
                            Beri Ulasan
                        </button>
                    </div>
                    <span class="d-block">{{ $order->created_at->FormattedDate() ?? 'N/A' }}</span>
                    <!-- <span class="d-block">{{$order}}</span> -->
                </div>
            </div>
            @empty
            <p class="mt-2">No results found</p>

            @endforelse
        </div>


        <!-- Modal -->
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
            <form autocomplete="off" wire:submit.prevent="rate">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <label for="exampleFormControlTextarea1">Reviews and Rating</label>
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++) <i class="{{ $rs >= $i ? 'fas fa-star' : 'far fa-star' }}" wire:click="setRating({{ $i }})" data-rating="{{ $i }}"></i>
                                    @endfor
                            </div>
                            <input type="hidden" wire:model.defer="state.rating" id="rating">
                            @error('rating')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                            <div class="form-group">
                                <textarea class="form-control" wire:model.defer="state.comment" id="comment" rows="3"></textarea>
                            </div>
                            @error('comment')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                            <button type="button" wire:click.prevent="close()" class="btn btn-secondary btn-block">Close</button>
                        </div>
                    </div>
                </div>
            </form>
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
@push('js')
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('ratingUpdated', rating => {});
    });
</script>
<script>
    $('form').submit(function() {
        @this.set('rs', $('#rating').val());
        @this.set('state.comment', $('#comment').val());
    })
</script>
@endpush