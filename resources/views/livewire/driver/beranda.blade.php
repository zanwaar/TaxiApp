<div>

    <main class="app containerw pb-5">
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
                        <p>1</p>
                    </div>

                    <div class="tab-pane" :class="currentTab === 'changePassword' ? 'active' : ''" id="changePassword" wire:ignore.self>
                        <p>2</p>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-body">
                <h1 class="display-4 text-center ">TAXI RUTE</h1>
                <p class=" text-center ">Saat ini Belum Ada Ordean</p>
                <img src="{{asset('assets/bus.svg')}}" alt="User Image" srcset="" class="img-fluid">
            </div>
        </div>
    </main>
</div>