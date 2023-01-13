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
                              <i class="mdi mdi-home"></i>
                          </span>
                          Dashboard
                      </h3>
                      <nav aria-label="breadcrumb">
                          <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page"><span></span>Overview <i
                                      class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i></li>
                          </ul>
                      </nav>
                  </div>
                  <div class="row">
                      <div class="col-4 grid-margin stretch-card">
                          <div class="card">
                              <div class="card-body vaccination-country">
                                  <h4 class="card-title">Total Faskes Vaksinasi di Indonesia</h4>
                                  <h4 class="card-subtitle mb-2 text-muted total"></h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <?php 
      include ('./partials/_footer.php');
      ?>

              <script>
              const totalVaccinationOfCountry = document.querySelector(".vaccination-country .total");

              const getVaccinationFacility = async () => {
                  const response = await fetch('https://kipi.covid19.go.id/api/get-faskes-vaksinasi');
                  const results = await response.json();

                  totalVaccinationOfCountry.innerHTML = `${results.count_total} faskes`;
              }

              getVaccinationFacility();
              </script>