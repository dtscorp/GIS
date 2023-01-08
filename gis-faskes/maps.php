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
                            <form >
                                <div class="form-group">
                                  <label for=""></label>
                                  <select  id="province" class="form-select" aria-label="Default select example">
                                <option selected>Pilih Provinsi</option>
                              </select>
                                </div>
                              
                                <div class="form-group">
                                  <label for=""></label>
                                  <select  id="city" class="form-select" aria-label="Default select example">
                                <option selected>Pilih Kota</option>
                              </select>
                              </div>
                              <button type="submit" class="btn btn-primary">Cari <i class="mdi mdi-map-marker-plus"></i></button>
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
        const batchTrack = document.getElementById("province");
        var map = L.map('map').setView([51.505, -0.09], 13);
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
const displayOption = async () => {
  const options = await getProvince();
  console.log(options);
  for (option of options) {
    const newOption = document.createElement("option");
    newOption.value = option.key;
    newOption.text = option.value;
    batchTrack.appendChild(newOption);
  }
};
displayOption();
      </script>
      <!-- partial -->