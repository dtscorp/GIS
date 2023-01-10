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
                                          <select id="city" class="form-select" aria-label="Default select example">
                                              <option selected>Pilih Kota</option>
                                          </select>
                                      </div>
                                      <button type="submit" onclick="searchVaccinationFacility(event)"
                                          class="btn btn-primary">Cari Faskes Vaksinasi</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-12 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body">
                                  <div id="map" style="height: 300px;"></div>
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
        const result = await response.json();

        let marker = L.marker([result.data[0].latitude, result.data[0].longitude]).addTo(map);
        map.setView([result.data[0].latitude, result.data[0].longitude], 13);

        console.log(result)
    } catch (err) {
        console.log(err)
    }
}
      </script>
      <!-- partial -->