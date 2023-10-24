@role('user|driver')
<div>
    <main class="app containerw pb-5">
        <div class="d-flex justify-content-between">
            <h3 class="pb-2">Profile</h3>
            <div class="pl-1"><a href="{{ route('logout') }}" onclick=" event.preventDefault(); document.getElementById('logout-form').submit();"><button type="button" class="btn btn-danger rounded btn-sm shadow-sm"><span>Logout</span></button> </a></div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        <div class="row pb-5">
            <div class="col-md-12">
                <div class="card" x-data="{ currentTab: $persist('profile') }">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills" wire:ignore>
                            <li @click.prevent="currentTab = 'profile'" class="nav-item"><a class="nav-link" :class="currentTab === 'profile' ? 'active text-white' : ''" href="#profile" data-toggle="tab">Edit Profile</a></li>
                            <li @click.prevent="currentTab = 'changePassword'" class="nav-item"><a class="nav-link" :class="currentTab === 'changePassword' ? 'active text-white' : ''" href="#changePassword" data-toggle="tab">Change Password</a></li>
                            @role('driver')
                            <li @click.prevent="currentTab = 'driver'" class="nav-item"><a class="nav-link" :class="currentTab === 'driver' ? 'active text-white' : ''" href="#driver" data-toggle="tab">Kendaraan</a></li>
                            @endrole
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" :class="currentTab === 'profile' ? 'active' : ''" id="profile" wire:ignore.self>
                                <div class="row">
                                    <div class="col-4 box-profile">
                                        <div class="d-flex justify-content-center" x-data="{ imagePreview: '{{ auth()->user()->avatar_url }}' }">
                                            <input wire:model="image" type="file" class="d-none" x-ref="image" x-on:change="
                                        reader = new FileReader();
                                        reader.onload = (event) => {
                                            imagePreview = event.target.result;
                                            document.getElementById('profileImage').src = `${imagePreview}`;
                                        };
                                        reader.readAsDataURL($refs.image.files[0]);
                                    " />
                                            <img x-on:click="$refs.image.click()" style="width: 200px; height auto;" x-bind:src="imagePreview ? imagePreview : '/backend/dist/img/user4-128x128.jpg'" alt="User profile picture">
                                        </div>
                                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                                        <p class="text-muted text-center">{{ auth()->user()->roles[0]->name}}</p>
                                    </div>
                                    <div class="col-8">
                                        <form wire:submit.prevent="updateProfile" class="form-horizontal">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input wire:model.defer="state.name" type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Name">
                                                    @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input wire:model.defer="state.email" type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email">
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @role('driver')
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">No Tlpn</label>
                                                <div class="col-sm-10">
                                                    <input wire:model.defer="drivers.no_tlpn" type="text" class="form-control @error('no_tlpn') is-invalid @enderror" id="inputEmail" placeholder="No Tlpn">
                                                    @error('no_tlpn')
                                                    <div class="invalid-feedback">
                                                        {{ $message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @endrole
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10 ">
                                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" :class="currentTab === 'changePassword' ? 'active' : ''" id="changePassword" wire:ignore.self>
                                <form wire:submit.prevent="changePassword" class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="currentPassword" class="col-sm-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input wire:model.defer="state.current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword" placeholder="Current Password">
                                            @error('current_password')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="newPassword" class="col-sm-3 col-form-label">New
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input wire:model.defer="state.password" type="password" class="form-control @error('password') is-invalid @enderror" id="newPassword" placeholder="New Password">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="passwordConfirmation" class="col-sm-3 col-form-label">Confirm
                                            New Password</label>
                                        <div class="col-sm-9">
                                            <input wire:model.defer="state.password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordConfirmation" placeholder="Confirm New Password">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9 ">
                                            <button type="submit" class="btn btn-success">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @role('driver')
                            <div class="tab-pane" :class="currentTab === 'driver' ? 'active' : ''" id="driver" wire:ignore.self>
                                <form autocomplete="off" wire:submit.prevent="update_kendaraan">
                                    <div class="form-row">
                                        <div class="form-group col-md-8">
                                            <label for="name">No polisi</label>
                                            <input type="text" wire:model.defer="drivers.nopolisi" class="form-control @error('nopolisi') is-invalid @enderror" id="nopolisi" aria-describedby="nameHelp" placeholder="No Polisi">
                                            @error('nopolisi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Kapasitas</label>
                                            <input type="text" wire:model.defer="drivers.kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" aria-describedby="nameHelp" placeholder="Kapsitas">
                                            @error('kapasitas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group ">
                                        <label for="name">No STNK</label>
                                        <input type="text" wire:model.defer="drivers.no_stnk" class="form-control @error('no_stnk') is-invalid @enderror" id="no_stnk" aria-describedby="nameHelp" placeholder="No STNK">
                                        @error('no_stnk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <label for="name">No SIM</label>
                                        <input type="text" wire:model.defer="drivers.no_sim" class="form-control @error('no_sim') is-invalid @enderror" id="no_sim" aria-describedby="nameHelp" placeholder="No SIM">
                                        @error('no_sim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Jenis Mobil</label>
                                            <input type="text" wire:model.defer="drivers.jenis_mobil" class="form-control @error('jenis_mobil') is-invalid @enderror" id="jenis_mobil" aria-describedby="nameHelp" placeholder="Jenis Mobil">
                                            @error('jenis_mobil')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="name">Nama Kepemilikan</label>
                                            <input type="text" wire:model.defer="drivers.nama_kepemilikan" class="form-control @error('nama_kepemilikan') is-invalid @enderror" id="nama_kepemilikan" aria-describedby="nameHelp" placeholder="Nama Kepemilikan">
                                            @error('nama_kepemilikan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="customFile">Photo Kendaraan</label>
                                        <div class="row">
                                            <div class="col-md-6">
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
                                                        Choose Kendaraan
                                                        @endif
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                @if ($photokend)
                                                <img src="{{ $photokend->temporaryUrl() }}" class="img d-block mt-2 w-100 rounded">
                                                @else
                                                <img src="{{asset('storage/avatars')}}/{{  $drivers['fotokend'] ?? '' }}" class="img d-block mb-2 w-100 rounded">
                                                @endif
                                            </div>
                                        </div>



                                    </div>
                                    <button type="submit" class="btn btn-success"><span>Save Changes</span></button>
                                </form>
                            </div>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</main>

</div>
@else
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid pb-5">
            <div class="row">
                <div class="col-md-4">

                    <!-- Profile Image -->
                    <div class=" card">
                        <div class="card-body box-profile">
                            <div class="text-center" x-data="{ imagePreview: '{{ auth()->user()->avatar_url }}' }">
                                <input wire:model="image" type="file" class="d-none" x-ref="image" x-on:change="
                                        reader = new FileReader();
                                        reader.onload = (event) => {
                                            imagePreview = event.target.result;
                                            document.getElementById('profileImage').src = `${imagePreview}`;
                                        };
                                        reader.readAsDataURL($refs.image.files[0]);
                                    " />
                                <img x-on:click="$refs.image.click()" class="card-img-top" x-bind:src="imagePreview ? imagePreview : '/backend/dist/img/user4-128x128.jpg'" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                            <p class="text-muted text-center">{{ auth()->user()->roles[0]->name}}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card" x-data="{ currentTab: $persist('profile') }">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" wire:ignore>
                                <li @click.prevent="currentTab = 'profile'" class="nav-item"><a class="nav-link" :class="currentTab === 'profile' ? 'active text-white' : ''" href="#profile" data-toggle="tab"><i class="fa fa-user mr-1"></i> Edit Profile</a></li>
                                <li @click.prevent="currentTab = 'changePassword'" class="nav-item"><a class="nav-link" :class="currentTab === 'changePassword' ? 'active text-white' : ''" href="#changePassword" data-toggle="tab"><i class="fa fa-key mr-1"></i> Change
                                        Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" :class="currentTab === 'profile' ? 'active' : ''" id="profile" wire:ignore.self>
                                    <form wire:submit.prevent="updateProfile" class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input wire:model.defer="state.name" type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Name">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input wire:model.defer="state.email" type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save mr-1"></i> Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" :class="currentTab === 'changePassword' ? 'active' : ''" id="changePassword" wire:ignore.self>
                                    <form wire:submit.prevent="changePassword" class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="currentPassword" class="col-sm-3 col-form-label">Current
                                                Password</label>
                                            <div class="col-sm-9">
                                                <input wire:model.defer="state.current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword" placeholder="Current Password">
                                                @error('current_password')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="newPassword" class="col-sm-3 col-form-label">New
                                                Password</label>
                                            <div class="col-sm-9">
                                                <input wire:model.defer="state.password" type="password" class="form-control @error('password') is-invalid @enderror" id="newPassword" placeholder="New Password">
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="passwordConfirmation" class="col-sm-3 col-form-label">Confirm
                                                New Password</label>
                                            <div class="col-sm-9">
                                                <input wire:model.defer="state.password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordConfirmation" placeholder="Confirm New Password">
                                                @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save mr-1"></i> Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>


                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endrole


@push('styles')
<style>
    .profile-user-img:hover {
        background-color: blue;
        cursor: pointer;
    }
</style>
@endpush

@push('alpine-plugins')
<!-- Alpine Plugins -->
<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        Livewire.on('nameChanged', (changedName) => {
            $('[x-ref="username"]').text(changedName);
        })
    });
</script>
@endpush