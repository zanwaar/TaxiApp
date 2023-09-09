<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Drvier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item  active">Drvier</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid pb-5">
            <div class="card">
                <div class="card-body">
                    <button wire:click.prevent="addNew" class="btn btn-info shadow-sm"><i class="fa fa-plus-circle mr-1"></i> Add New Driver</button>
                    <table class="table_cost table-responsive-md ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Driver</th>
                                <th scope="col">Nomor Polisi</th>
                                <th scope="col">Kapasitas</th>
                                <th scope="col">Status</th>
                                <th style="width: 8px;">Options</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($driver as $index => $bg)
                            <tr>

                                <td>{{ $driver->firstItem() + $index }}</td>
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
                                        <a href="#" wire:click.prevent="edit({{ $bg }})" class="btn btn-info btn-sm text-white"><i class="fa fa-edit"></i></a>
                                        <button wire:click="confirmRemoval({{ $bg->user }})" class="btn btn-danger text-white"><i class="fas fa-trash"></i></button>
                                        <!-- <button wire:click="confirmRemovale(" type="button" class="btn btn-outline-secondary">Hapus</button> -->
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
                </div>
                <div class="card-footer d-flex justify-content-end">
                    {!! $driver->links() !!}
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
                    <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger"><i class="fa fa-trash mr-1"></i>Delete User</button>
                </div>
            </div>
        </div>
    </div>
</div>