<div>
    <main class="app containerw pb-5">
        @if ($order)
        @if ($order->status === 'selesai')
        <p>Anda Belum Lakukan Booking</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Booking Now</a>
        @else
        <form autocomplete=" off" wire:submit.prevent="create">
            <div class="pt-2">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Status Booking...! </h4>
                    <hr>
                    <p class="mb-0">Satu Langkah lagi Silahkan Lakukan Pembayaran Untuk status Booking</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4>Detail Booking</h4>
                            <button type="submit" class="btn btn-info btn-sm">Edit Booking</button>
                        </div>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputState">Nama : {{ auth()->user()->name}}</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="inputState">Rute</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->rute }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">No Telepon</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->notlpn }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Jml Penumpang</label>
                                    <input type="text" class="form-control" readonly value="{{ $order->jumlah_penumpang }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Alamat</label>
                                <input type="text" class="form-control" readonly value="{{ $order->alamat }}">
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">Pembayaran</button>
                            <button type="button" wire:click="confirmRemoval({{ $order }})" class="btn btn-danger btn-sm">Batal Booking</button>
                            <small class="form-text text-muted">Pembatalan Order di bisa di lakukan ......</small>
                        </form>
                    </div>

                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                @if ($order->driver === null)
                <style>
                    svg {
                        width: 100px;
                        height: 100px;
                        margin: 0;
                        display: inline-block;
                    }
                </style>
                <p class="text-muted">Sedang Mencari Driver Untuk Anda
                    <span class="ml-2">
                        <svg version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                            <circle fill="#2D4356" stroke="none" cx="6" cy="50" r="6">
                                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1" />
                            </circle>
                            <circle fill="#2D7ABE" stroke="none" cx="26" cy="50" r="6">
                                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2" />
                            </circle>
                            <circle fill="#2D4356" stroke="none" cx="46" cy="50" r="6">
                                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3" />
                            </circle>
                        </svg>
                    </span>
                </p>
                @else
                <h3>Taxi Driver</h3>
                @endif
            </div>
        </div>
        @endif
        @else
        <p>Anda Belum Lakukan Booking</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Booking Now</a>
        @endif
    </main>
    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete</h5>
                </div>

                <div class="modal-body">
                    <h4>Apakah Anda Yakin Untuk Batal Booking?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="delete" class="btn btn-danger">Ya</button>
                </div>
            </div>
        </div>
    </div>
</div>