<div>

    <section class="content">
        <div class="container-fluid py-3">
            <div class="d-flex justify-content-between mb-2">
                <h2 class="m-0 text-dark">Data Transaksi</h2>
                <x-search-input wire:model="searchTerm" />
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row">
                        <div class="col-1">
                            <select wire:change="row($event.target.value)" class="form-control rounded shadow-sm mr-3">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-md table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Booking</th>
                                <th scope="col">Type Layanan</th>
                                <th scope="col">Rute</th>
                                <th scope="col">Jumlah Penumpang</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal dan waktu</th>
                                <th scope="col">Driver</th>
                                <!-- <th scope="col">Option</th> -->
                            </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($orders as $index => $order)
                            <tr>
                                <th scope="row">{{ $orders->firstItem() + $index  }}</th>

                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->layanan }}</td>
                                <td>{{ $order->rute }}</td>
                                <td>{{ $order->jumlah_penumpang }}</td>
                                <td><span class="badge badge-pill  badge-{{ $order->status_badge }}">{{ $order->status }}</span></td>
                                <td>{{ $order->created_at->toFormattedDate() ?? 'N/A' }}</td>
                                @if ($order->driver)
                                <td>{{ $order->driver->nopolisi }}</td>
                                @else
                                @if ($order->status != 'Batal')
                                <td>
                                    <a href="" wire:click.prevent="confirm({{ $order }})">
                                        <span class=" badge badge-pill badge-dark">konfirmasi Driver</span>
                                    </a>
                                </td>
                                @else
                                <td>
                                    -
                                </td>
                                @endif

                                @endif
                                <!-- <td>
                                    <a href="" wire:click.prevent="edit({{ $order }})">
                                        <i class="fa fa-edit mr-2"></i>
                                    </a>

                                    <a href="" wire:click.prevent="confirmorderRemoval({{ $order }})">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td> -->
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="8">
                                    <img src="https://42f2671d685f51e10fc6-b9fcecea3e50b3b59bdc28dead054ebc.ssl.cf5.rackcdn.com/v2/assets/empty.svg" alt="No results found">
                                    <p class="mt-2">No results found</p>
                                </td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">

                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Driver</h5>
                </div>

                <div class="modal-body">
                    @if ($drivers)
                    <table class="table_cost table-responsive-md ">
                        <thead>
                            <tr>
                                <th scope="col">Nama Driver</th>
                                <th scope="col">Nomor Polisi</th>
                                <th scope="col">Kapasitas</th>
                                <th scope="col">Status</th>
                                <th style="width: 8px;">Options</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($data as $index => $bg)
                            <tr>

                                <td>
                                    @if ($bg->user->avatar)
                                    <img src="{{ $bg->user->avatar_url }}" style="width: 70px; height:70px" class="img img-circle mr-1" alt="">
                                    @else
                                    <img src="https://ui-avatars.com/api/?background=5F9DF7&color=fff&name={{$bg->user->name}}" style="width: 70px; " class="img img-circle mr-1" alt="">

                                    @endif
                                    <span class="mr-2">{{ $bg->user->name }}</span>
                                </td>
                                <td>{{ $bg->nopolisi }}</td>
                                <td>{{ $bg->kapasitas }}</td>
                                <td><span class="badge badge-pill  badge-{{ $bg->status_badge }}">{{ $bg->status }}</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button wire:click="confirmRemoval({{ $bg }})" class="btn btn-primary">Pilih</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">
                                    <img src="https://42f2671d685f51e10fc6-b9fcecea3e50b3b59bdc28dead054ebc.ssl.cf5.rackcdn.com/v2/assets/empty.svg" alt="No results found">
                                    <p class="mt-2">No results found</p>
                                </td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>