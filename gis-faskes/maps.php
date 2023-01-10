      <!-- partial:partials/_navbar.html -->
      <?php 
      include ('./partials/_navbar.php');
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
          <!-- partial:partials/_sidebar.html -->
          <?php 
      include ('./partials/_sidebar.php');
      ?>
          <!-- partial -->
          <div class="main-panel">
              <div class="content-wrapper">
                  <div class="page-header">
                      <h3 class="page-title">
                          <span class="page-title-icon bg-gradient-primary text-white me-2">
                              <i class="mdi mdi-home"></i>
                          </span>
                          Faskes Vaksinasi Yang Tersedia
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
                              <div class="card-body">
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
                                      <button id="btnSearch" type="submit" onclick="searchVaccinationFacility(event)"
                                          class="btn btn-primary" disabled="true">Cari Faskes Vaksinasi</button>
                                  </form>
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
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <?php 
      include ('./partials/_footer.php');
      ?>

      <script>
const cityDropdown = document.getElementById("city");
const provinceDropdown = document.getElementById("province");
const btnSearch = document.getElementById("btnSearch");

let map = L.map('map');

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
        const coords = [];

        map.setView([results.data[0].latitude, results.data[0].longitude], 10);

        results.data.forEach(((data, idx) => {
            if (idx <= 4) {
                let marker = L.marker([data.latitude, data.longitude]).addTo(map);
                const popupContent =
                    `<b>${data.jenis_faskes} ${data.nama}</b><br>${data.alamat} | ${data.telp}<br><br><b>${data.status}</b>`
                marker.bindPopup(
                    popupContent
                ).openPopup();

                coords.push([Number(data.latitude), Number(data.longitude)])
            }
        }))


        navigator.geolocation.getCurrentPosition(position => {
            const closerLocation = L.GeometryUtil.closest(map, coords, [position.coords.latitude,
                position.coords.longitude
            ])

            L.Routing.control({
                waypoints: [
                    L.latLng(position.coords.latitude, position.coords
                        .longitude),
                    L.latLng(closerLocation.lat, closerLocation.lng)
                ],
            }).addTo(map);

            console.log(closerLocation.distance / 1000)
        })

    } catch (err) {
        console.log(err)
    }
}
      </script>