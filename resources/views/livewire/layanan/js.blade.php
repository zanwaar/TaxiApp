<div>
    <div id="map2" wire:ignore style="width: 100%; height: 400px;"></div>
</div>
@push('js')
<script>
    document.addEventListener('livewire:load', function() {
        // Your JS here.

        var titikor = document.querySelector("[name=titikkor]");
        var map = L.map('map2').setView([-5.1475267571872605, 119.47171032428743], 17);
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var cor = [-0, 1]
        map.attributionControl.setPrefix(false);
        var marker = new L.marker(cor, {
            draggable: 'ture',
        });


        function onMapClick(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map)
            } else {
                marker.setLatLng(e.latlng)
            }

            titikor.value = lat + "," + lng;
        }
        map.addLayer(marker)

        function onMapdrag(e) {
            var pos = marker.getLatLng();
            marker.setLatLng(pos, {
                cor
            })
            $("#titikkor").val(pos.lat + "," + pos.lng);
        }

        map.on('click', onMapClick);
        marker.on('dragend', onMapdrag);
        var gps = new L.Control.Gps({
            autoActive: true,
            autoCenter: true
        }); //inizialize control

        gps
            .on('gps:located', function(e) {
                //	e.marker.bindPopup(e.latlng.toString()).openPopup()
                console.log(e.latlng, map.getCenter())
            })
            .on('gps:disabled', function(e) {
                e.marker.closePopup()
            });

        gps.addTo(map);
    })
</script>
<script>
    $('form').submit(function() {
        @this.set('titikkor', $('#titikkor').val());
    })
</script>
@endpush