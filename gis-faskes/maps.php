      <?php 
      include ('./partials/_navbar.php');
      ?>
      <div class="container-fluid page-body-wrapper">
          <?php 
      include ('./partials/_sidebar.php');
      ?>
          <div class="main-panel">
              <div class="content-wrapper">
                  <div class="page-header">
                      <h3 class="page-title">
                          <span class="page-title-icon bg-gradient-primary text-white me-2">
                              <i class="mdi mdi-hospital"></i>
                          </span>
                          Faskes Vaksinasi
                      </h3>
                      <nav aria-label="breadcrumb">
                          <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page"><span></span>Overview <i
                                      class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i></li>
                          </ul>
                      </nav>
                  </div>
                  <div class="row">
                      <div class="col-12 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body d-flex flex-column">
                                  <form>
                                      <div class="form-group">
                                          <select id="province" class="form-select" aria-label="Default select example"
                                              onchange="handleOnchangeProvince(event)">
                                              <option selected>Pilih Provinsi</option>
                                          </select>
                                      </div>

                                      <div class="form-group">
                                          <select id="city" class="form-select" aria-label="Default select example"
                                              disabled="true">
                                              <option selected>Pilih Kota</option>
                                          </select>
                                      </div>
                                      <button id="btnSearch" type="button" onclick="searchVaccinationFacility(event)"
                                          class="btn btn-primary" disabled="true">Cari Faskes Vaksinasi</button>
                                      <button id="btnReset" type="button" onclick="resetMarker(event)"
                                          class="btn btn-danger" disabled="true">Reset</button>
                                      <button id="btnAddRoute" type="button" onclick="addWaypointRoute(event)"
                                          class="btn btn-info float-end" disabled="true">
                                          <i class="mdi mdi-routes"></i>
                                          Lihat Rute
                                      </button>
                                  </form>
                                  <span class="mt-4" style="font-size: 0.75rem; color: #ff456b">Note: Reset terlebih
                                      dahulu
                                      jika ingin
                                      mengubah
                                      kota</span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-12 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div id="map" style="height: 400px;"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <?php 
      include ('./partials/_footer.php');
      ?>

      <script>
const cityDropdown = document.getElementById("city");
const provinceDropdown = document.getElementById("province");
const btnSearch = document.getElementById("btnSearch");
const btnReset = document.getElementById("btnReset");
const btnAddRoute = document.getElementById("btnAddRoute");

let map = L.map('map');
const markers = [];
let coords = [];
let waypoints;
let popupCurrentLoc;
let popupFaskesLoc;

navigator.geolocation.getCurrentPosition(position => {
    map.setView([position.coords.latitude, position.coords.longitude], 13);
})

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


const getProvince = async () => {
    const url = 'https://kipi.covid19.go.id/api/get-province';
    const config = {
        method: 'POST',
    }
    const response = await fetch(url, config);
    const result = await response.json();

    return result.results

}
const provinceOption = async () => {
    const provinces = await getProvince();

    for (province of provinces) {
        const newOption = document.createElement("option");
        newOption.value = province.key;
        newOption.text = province.value;
        provinceDropdown.appendChild(newOption);
    }
};

provinceOption();

const getCity = async (provinceKey) => {
    const url = `https://kipi.covid19.go.id/api/get-city?start_id=${provinceKey}`;
    const config = {
        method: 'POST',
    }
    const response = await fetch(url, config);
    const result = await response.json();

    return result.results
}

const cityOption = async (provinceKey) => {
    const cities = await getCity(provinceKey);
    let newOption = ``;

    for (city of cities) {
        newOption += `<option value="${city.key}">${city.value}</option>`;

        cityDropdown.innerHTML = newOption;
    }
};

const handleOnchangeProvince = (event) => {
    const provinceKey = event.target.value;
    cityDropdown.disabled = false;
    btnSearch.disabled = false;
    cityOption(provinceKey);
}

const searchVaccinationFacility = async (event) => {
    event.preventDefault();
    btnReset.disabled = false;
    btnAddRoute.disabled = false;

    try {
        const url = "https://kipi.covid19.go.id/api/get-faskes-vaksinasi?" + new URLSearchParams({
            skip: 0,
            province: provinceDropdown.value,
            city: cityDropdown.value
        });

        const config = {
            method: "GET"
        }

        const response = await fetch(url, config)
        const results = await response.json();

        addFaskesPinpoints(results)

    } catch (err) {
        console.log(err)
    }
}

const addFaskesPinpoints = (results) => {
    map.setView([results.data[0].latitude, results.data[0].longitude], 10);

    results.data.forEach(((data, idx) => {
        if (idx <= 4) {
            let marker = L.marker([data.latitude, data.longitude]);
            const popupContent =
                `<b>${data.jenis_faskes} ${data.nama}</b><br>${data.alamat} | ${data.telp}<br><br><b>${data.status}</b>`
            marker.bindPopup(
                popupContent
            )
            markers.push(marker);
            map.addLayer(marker);

            coords.push([Number(data.latitude), Number(data.longitude)])
        }
    }))
}

const addWaypointRoute = () => {
    navigator.geolocation.getCurrentPosition(position => {
        const closerLocation = L.GeometryUtil.closest(map, coords, [position.coords.latitude,
            position.coords.longitude
        ])

        waypoints = L.Routing.control({
            waypoints: [
                L.latLng(position.coords.latitude,
                    position.coords.longitude),
                L.latLng(closerLocation.lat, closerLocation.lng)
            ],
        }).addTo(map)

        popupCurrentLoc = L.popup({
                autoClose: false
            })
            .setContent('Lokasi Anda')
            .setLatLng([position.coords.latitude,
                position.coords.longitude
            ]).openOn(map);

        popupFaskesLoc = L.popup({
                autoClose: false
            })
            .setContent('Lokasi Faskes')
            .setLatLng([closerLocation.lat,
                closerLocation.lng
            ]).openOn(map);

    })

}

const resetMarker = (event) => {
    btnAddRoute.disabled = true;
    event.preventDefault();

    coords = [];

    if (waypoints) {
        map.removeControl(waypoints);
        map.removeLayer(popupCurrentLoc);
        map.removeLayer(popupFaskesLoc);
    }

    markers.forEach(marker => {
        map.removeLayer(marker)
    })


}
      </script>