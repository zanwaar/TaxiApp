<div>
    <form autocomplete="off" wire:submit.prevent="create">
        <div x-data="app()" x-cloak>
            <div class="">
                <div x-show.transition="step === 'complete'">
                    @if($errors->any())
                    <div class="bg-white rounded-lg p-10 flex items-center shadow justify-between">
                        <div>
                            <!-- <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg> -->
                            <svg class="mb-4 h-20 w-20 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>

                            <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">Registration FALID</h2>

                            <div class="text-gray-600 mb-8">

                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>


                                <!-- Your Tailwind-styled HTML form goes here -->



                            </div>

                            <button @click="step = 1" class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Cek Kembali</button>
                        </div>
                    </div>
                    @else
                    <div class="bg-white rounded-lg p-10 flex items-center shadow justify-between">
                        <div>
                            <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>

                            <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">Registration Success</h2>

                            <div class="text-gray-600 mb-8">




                                <!-- Your Tailwind-styled HTML form goes here -->



                            </div>

                            <a href="{{ route('login') }}" class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">login</a>
                        </div>
                    </div>
                    @endif
                </div>

                <div x-show.transition="step != 'complete'">
                    <!-- Top Navigation -->
                    <div class="border-b-2 py-4">
                        <div class="uppercase tracking-wide text-xs font-bold text-gray-500 mb-1 leading-tight" x-text="`Step: ${step} of 3`"></div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div x-show="step === 1">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">DrivGO</div>
                                </div>

                                <div x-show="step === 2">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">DrivGO</div>
                                </div>
                            </div>

                            <div class="flex items-center md:w-64">
                                <div class="w-full bg-white rounded-full mr-2">
                                    <div class="rounded-full bg-green-500 text-xs leading-none h-2 text-center text-white" :style="'width: '+ parseInt(step / 3 * 100) +'%'"></div>
                                </div>
                                <div class="text-xs w-10 text-gray-600" x-text="parseInt(step / 3 * 100) +'%'"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Top Navigation -->

                    <!-- Step Content -->
                    <div class="py-10">
                        <div x-show.transition.in="step === 1">
                            <div class="flex flex-col space-y-2 text-center mb-5">
                                <h2 class="text-3xl md:text-4xl font-bold">
                                    Bergabung Menjadi Mitra Driver <span class="text-emerald-700">DraivGo</span></h2>
                            </div>
                            <div class="inline-block mb-5 w-1/2 pr-1">
                                <input class="w-full px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal nopolisi @error('nopolisi') border-red-500 @enderror" type="text" placeholder="No Polisi" wire:model.defer="state.nopolisi">
                            </div>
                            <div class="inline-block mb-5 -mx-1 pl-1 w-1/2">
                                <input class="w-full px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal kapasitas @error('kapasitas') border-red-500 @enderror" type="text" placeholder="Kapasiras" wire:model.defer="state.kapasitas">
                            </div>
                            <div class="inline-block mb-5 -mx-1 pl-1 w-full">
                                <input class="w-full px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal nostnk @error('nostnk') border-red-500 @enderror" type="text" placeholder="No STNK" wire:model.defer="state.nostnk" value="{{ old('nostnk') }}">
                            </div>
                            <div class="inline-block mb-5 -mx-1 pl-1 w-full">
                                <input class="w-full px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal sim @error('sim') border-red-500 @enderror" type="text" placeholder="No SIM" wire:model.defer="state.sim" value="{{ old('sim') }}">
                            </div>
                            <div class="inline-block mb-5 w-1/2 pr-1">
                                <input class="w-full px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal jenismobil @error('jenismobil') border-red-500 @enderror" type="text" placeholder="Jenis Mobil" wire:model.defer="state.jenismobil" value="{{ old('jenismobil') }}">
                            </div>
                            <div class="inline-block mb-5 -mx-1 pl-1 w-1/2">
                                <input class="w-full px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal namakepemilikan  @error('namakepemilikan') border-red-500 @enderror" type="text" placeholder="Nama Kepemilikan" wire:model.defer="state.namakepemilikan" value="{{ old('namakepemilikan') }}">
                            </div>
                        </div>
                        <div x-show.transition.in="step === 2">
                            <div class="flex flex-col space-y-2 text-center mb-5">
                                <h2 class="text-3xl md:text-4xl font-bold">
                                    Photo Kendaraan <span class="text-emerald-700">DraivGo</span></h2>
                            </div>
                            <div class="flex flex-wrap items-center mt-2">
                                <div class="w-full mb-4 md:mb-0 text-center">
                                    <label for="customFile" class="block text-gray-700 text-sm font-medium mb-2">Choose File</label>

                                    <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 5" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <input wire:model="photokend" type="file" class="hidden" id="customFile">
                                        <label for="customFile" class="cursor-pointer inline-block bg-blue-500 text-white rounded px-4 py-2 transition duration-300 ease-in-out hover:bg-blue-600">
                                            Upload File
                                        </label>
                                        <div x-show.transition="isUploading" class="mt-2 w-full">
                                            <div class="relative pt-1">
                                                <div class="flex mb-2 items-center justify-between">
                                                    <div>
                                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200">
                                                            Upload in Progress
                                                        </span>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="text-xs font-semibold inline-block text-teal-600">
                                                            <span x-text="progress"></span>%
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-teal-200">
                                                    <div x-bind:style="'width:' + progress + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-5">
                                    @if ($photokend)
                                    <img src="{{ $photokend->temporaryUrl() }}" class="block mt-2 w-full rounded">
                                    @else
                                    <img src="{{asset('assets/1.png')}}" class="block mb-2 w-full rounded">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div x-show.transition.in="step === 3">
                            <div class="flex flex-col space-y-2 text-center mb-5">
                                <h2 class="text-3xl md:text-4xl font-bold">
                                    Jadi Bagian dari Komunitas Kami <span class="text-emerald-700">DraivGo</span></h2>
                            </div>
                            <div class="flex flex-col max-w-xl space-y-5 ">
                                <input placeholder="username" type="text" wire:model.defer="state.name" value="{{ old('name') }}" class="  @error('name') border-red-500 @enderror flex px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal name" />
                                <input wire:model.defer="state.notlpn" placeholder="No Tlpn" type="text" value="{{ old('notlpn') }}" class=" @error('notlpn') border-red-500 @enderror flex px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal notlpn" />
                                <input type="text" placeholder="email" wire:model.defer="state.email" value="{{ old('email') }}" class=" @error('email') border-red-500 @enderror  flex px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal email" />

                                <input type="password" name="password" placeholder="password" class="flex px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal password  @error('password') border-red-500 @enderror" />


                                <!-- <button type="submit" class="flex items-center justify-center flex-none px-3 py-2 md:px-4 md:py-3 border-2 rounded-lg font-medium text-white border-black bg-emerald-700 hover:bg-emerald-800  ">
                                Daftar DraivGo</button> -->

                            </div>

                        </div>
                    </div>
                    <!-- / Step Content -->
                </div>

            </div>

            <!-- Bottom Navigation -->
            <div class="" x-show="step != 'complete'">
                <div class="max-w-3xl mx-auto px-4">
                    <div class="flex justify-between">
                        <div class="w-1/2">
                            <button x-show="step > 1" @click="step--" type="button" class="w-32 focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Previous</button>
                        </div>

                        <div class="w-1/2 text-right">
                            <button x-show="step < 3" @click="step++" type="button" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Next</button>

                            <button @click="step = 'complete'" x-show="step === 3" type="submit" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Complete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Bottom Navigation https://placehold.co/300x300/e2e8f0/cccccc -->
        </div>
    </form>
</div>
@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    var nostnkValue;
    var simValue;
    var passwordValue;
    var emailValue;
    var notlpnValue;
    var nameValue;
    var namakepemilikanValue;
    var jenismobiValue;
    var kapasitasValue;
    var nopolisiValue;

    $('#customFile').on('change', function() {
        nopolisiValue = $('.nopolisi').val();
        kapasitasValue = $('.kapasitas').val();
        jenismobiValue = $('.jenismobi').val();
        namakepemilikanValue = $('.namakepemilikan').val();
        notlpnValue = $('.notlpn').val();
        emailValue = $('.email').val();
        passwordValue = $('.password').val();
        simValue = $('.sim').val();
        nameValue = $('.name').val();
        nostnkValue = $('.nostnk').val();
    });
    $('form').submit(function() {
        @this.set('state.nopolisi', $('.nopolisi').val());
        @this.set('state.kapasitas', $('.kapasitas').val());
        @this.set('state.nostnk', $('.nostnk').val());
        @this.set('state.sim', $('.sim').val());
        @this.set('state.jenismobil', $('.jenismobil').val());
        @this.set('state.namakepemilikan', $('.namakepemilikan').val());
        @this.set('state.name', $('.name').val());
        @this.set('state.notlpn', $('.notlpn').val());
        @this.set('state.email', $('.email').val());
        @this.set('state.password', $('.password').val());
    })
</script>

@endpush