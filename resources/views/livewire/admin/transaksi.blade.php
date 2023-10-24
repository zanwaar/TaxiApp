<div>

    <section class="content">
        <div class="container-fluid py-3">
            <div class="d-flex justify-content-between mb-2">
                <h2 class="m-0 text-dark">Data Transaksi</h2>
                <x-search-input wire:model="searchTerm" />
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between flex-row">
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
                        <div class="di">
                            <button class="{{ $filter == 'today' ? 'btn btn-warning ' : 'btn btn-outline-warning' }} text-bold" wire:click="filter('today')">Hari ini</button>
                            <button class="{{ $filter == 'all' ? 'btn btn-warning ' : 'btn btn-outline-warning' }} text-bold" w wire:click="filter('all')">Tampilkan Semua</button>
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
                                @if ($order->date != now()->toDateString())
                                <td>
                                    <a href="" wire:click.prevent="confirm({{ $order }})">
                                        <span class=" badge badge-pill badge-dark">konfirmasi Driver</span>
                                    </a>
                                </td>
                                @else
                                <td>
                                    <span class=" badge badge-pill badge-warning">pendding</span>
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
                <div class="modal-header d-flex justify-content-between">
                    <div>
                        <h3>Antrian Driver</h3>
                    </div>
                    <div class="div">
                        <p>Jumlah Penumpang <span class="ml-2 bg-danger px-3 rounded pb-1"> {{$jml}}</span></p>

                    </div>
                </div>

                <div class="modal-body">
                    @if ($drivers)

                    <table class="table table-responsive-md table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nomor Antrian</th>
                                <th scope="col">Nama Driver</th>
                                <th scope="col">Kapasitas</th>
                                <th scope="col">Sisa</th>
                                <th style="width: 8px;">Options</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($data as $index => $bg)

                            <tr>
                                <td style="width: 10px;">{{ $orders->firstItem() + $index  }}</td>
                                <td>
                                    <span class="mr-2">{{ $bg->user->name }}</span>
                                </td>
                                <td>{{ $bg->kapasitas }}</td>
                                <td class="badge text-bold badge-dark px-4" style="font-size: 18px;">{{ $bg->kapasitas - ($bg->order->total_penumpang ?? 0) }}</td>

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button wire:click="confirmRemoval({{ $bg }})" class="btn btn-primary px-3">Pilih</button>
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