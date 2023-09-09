<div>
    <div style="position: absolute; top:5px; right:30px; z-index: 999;">
        <input type="text" name="titikkor" readonly id="titikkor" wire:model.defer="titikkor" class="form-control @error('titikkor') is-invalid @enderror" placeholder="Lokasi">
    </div>
    <!-- Add a circular button with SVG icon -->
    <p style="position: absolute; top: 30px; right: 90px; z-index: 999; ">Titik Penjemputan</p>

    <div id="circleButton" style="position: absolute; top: 30px; right: 30px; z-index: 999; width: 50px; height: 50px; background-color: #007bff; border-radius: 50%; text-align: center; line-height: 50px; cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" style="fill: white; width: 1em; height: 1em; vertical-align: middle;">
            <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
        </svg>
    </div>
</div>