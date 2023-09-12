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
                                <td>
                                    <a href="">
                                        <span class="badge badge-pill  badge-dark">konfirmasi Driver</span>
                                    </a>
                                </td>
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
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog  modal-xl" role="document">
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'update' : 'create' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            @if($showEditModal)
                            <span>Edit Driver</span>
                            @else
                            <span>Add New Driver</span>
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Kapasitas</label>
                                    <input type="text" wire:model.defer="state.kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" aria-describedby="nameHelp" placeholder="No Polisi">
                                    @error('kapasitas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">No polisi</label>
                                    <input type="text" wire:model.defer="state.nopolisi" class="form-control @error('nopolisi') is-invalid @enderror" id="nopolisi" aria-describedby="nameHelp" placeholder="No Polisi">
                                    @error('nopolisi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.defer="state.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Enter full name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="text" wire:model.defer="state.email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" wire:model.defer="state.password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="passwordConfirmation">Confirm Password</label>
                                    <input type="password" wire:model.defer="state.password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customFile">Profile Photo</label>
                                    <div class="custom-file">
                                        <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <input wire:model="photo" type="file" class="custom-file-input" id="customFile">
                                            <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="custom-file-label" for="customFile">
                                            @if ($photo)
                                            {{ $photo->getClientOriginalName() }}
                                            @else
                                            Choose Image
                                            @endif
                                        </label>
                                    </div>

                                    @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="img d-block mt-2 w-100 rounded">
                                    @else
                                    <img src="{{ $state['avatar_url'] ?? '' }}" class="img d-block mb-2 w-100 rounded">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customFile">Photo Kendaraan</label>
                                    <div class="custom-file">
                                        <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <input wire:model="photokend" type="file" class="custom-file-input" id="customFile">
                                            <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width: ${progress}%`">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="custom-file-label" for="customFile">
                                            @if ($photokend)
                                            {{ $photokend->getClientOriginalName() }}
                                            @else
                                            Choose Image
                                            @endif
                                        </label>
                                    </div>

                                    @if ($photokend)
                                    <img src="{{ $photokend->temporaryUrl() }}" class="img d-block mt-2 w-100 rounded">
                                    @else
                                    <!-- <img src="{{ $state['avatar_url'] ?? '' }}" class="img d-block mb-2 w-100 rounded"> -->
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i>
                            @if($showEditModal)
                            <span>Save Changes</span>
                            @else
                            <span>Save</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete this driver?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                    <button type="button" wire:click.prevent="deleteorder" class="btn btn-danger"><i class="fa fa-trash mr-1"></i>Delete order</button>
                </div>
            </div>
        </div>
    </div>
</div>