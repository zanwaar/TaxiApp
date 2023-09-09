<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @livewireStyles
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }

        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100vw;
        }

        /* Add any custom styles for the button here */
        #circleButton:hover {
            background-color: #0056b3;
            /* Change background color on hover */
        }

        /* Add shadow to the button */
        #circleButton {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Media Query untuk perangkat mobile */
        @media (max-width: 768px) {
            #circleButton {
                bottom: 20px;
                /* Pindahkan tombol ke bawah pada perangkat mobile */
                top: auto;
                /* Hapus aturan top */
            }
        }
    </style>
</head>

<body>
    <livewire:layanan.maps />
  <div id="map"></div>
    <script>
        const map = L.map('map').fitWorld();

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Create a layer group to hold the draggable marker and circle
        const locationGroup = L.layerGroup().addTo(map);

        let locationMarker;
        // let locationCircle;

        // Function to update and save the "titikkor" value to localStorage
        function updateAndSaveTitikkor(latlng) {
            // Update the input field with the new lat and lng values
            document.getElementById('titikkor').value = `${latlng.lat}, ${latlng.lng}`;

            // Save the "titikkor" value to localStorage
            localStorage.setItem('titikkor', JSON.stringify(latlng));
        }

        // Function to retrieve the "titikkor" value from localStorage
        function getSavedTitikkor() {
            const savedTitikkor = localStorage.getItem('titikkor');
            if (savedTitikkor) {
                return JSON.parse(savedTitikkor);
            } else {
                return null;
            }
        }

        function onLocationFound(e) {
            const radius = e.accuracy / 2;

            // Check if "titikkor" is already saved in localStorage
            const savedTitikkor = getSavedTitikkor();

            // Create a draggable marker and add it to the layer group
            locationMarker = L.marker(savedTitikkor || e.latlng, {
                draggable: true
            }).addTo(locationGroup);

            // Create a circle and add it to the layer group
            // locationCircle = L.circle(savedTitikkor || e.latlng, radius).addTo(locationGroup);

            // Set the view to the marker's location
            map.setView(savedTitikkor || e.latlng, 18);

            // Listen for the 'drag' event on the marker
            locationMarker.on('drag', () => {
                const latlng = locationMarker.getLatLng();
                updateAndSaveTitikkor(latlng);
                // locationCircle.setLatLng(latlng); // Update circle's position
            });

            // Set the initial lat and lng values to the input field
            updateAndSaveTitikkor(savedTitikkor || e.latlng);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        map.locate({
            setView: true,
            maxZoom: 18
        });
        // Event listener untuk tombol "Circle"
        document.getElementById('circleButton').addEventListener('click', function() {
            // Tindakan yang akan dijalankan saat tombol diklik
            const element = document.getElementById('titikkor'); // Gantilah 'idElemen' dengan ID elemen yang Anda ingin ambil nilai nya

            // Contoh penggunaan:
            const inputValue = element.value; // Mengambil nilai dari elemen input
            alert('Titik Penjemputan : ' + inputValue);
            window.history.back(); // Contoh: Menampilkan pesan pop-up
        });
        // Event listener untuk klik pada peta
        map.on('click', onMapClick);

        // Fungsi yang akan dipanggil saat peta diklik
        function onMapClick(e) {
            // Hapus marker sebelumnya jika ada
            locationGroup.clearLayers();

            // Tambahkan marker pada koordinat yang diklik oleh pengguna
            const clickedMarker = L.marker(e.latlng, {
                draggable: true
            }).addTo(locationGroup);
            updateAndSaveTitikkor(e.latlng);
            // Listen for the 'drag' event on the marker
            clickedMarker.on('drag', () => {
                const latlng = clickedMarker.getLatLng();
                updateAndSaveTitikkor(latlng);
            });

        }
    </script>
</body>

</html>