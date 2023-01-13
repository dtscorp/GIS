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
                      <div class="col-12grid-margin stretch-card">
                      <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">About Program</h4>
                    <p class="card-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                  </div>
                </div>
                      </div>
                  </div>
                  <br>
                  <div class="row">
                      <div class="col-12grid-margin stretch-card">
                      <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">About US</h4>
                    <p class="card-description"> And our <code>Contribution</code>
                    </p>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th> User</th>
                          <th> Name </th>
                          <th> NIM </th>
                          <th> Contribution </th>
                          <th> Deadline </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="py-1">
                            <img src="/sig2/GIS/gis-faskes/assets/images/faces-clipart/pic-1.png" alt="image">
                          </td>
                          <td> Abdulloh Fahmi </td>
                          <td>0110220071</td>
                          <td>Handle search faskes features</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            <img src="/sig2/GIS/gis-faskes/assets/images/faces-clipart/pic-4.png" alt="image">
                          </td>
                          <td> Danang Tri Saputro </td>
                          <td>0110220057</td>
                          <td>Handle templating the  program</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            <img src="/sig2/GIS/gis-faskes/assets/images/faces-clipart/pic-1.png" alt="image">
                          </td>
                          <td> Seli Mulyani </td>
                          <td>0110220020</td>
                          <td>handle report document</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            <img src="/sig2/GIS/gis-faskes/assets/images/faces-clipart/pic-1.png" alt="image">
                          </td>
                          <td> Wahyu Adi Pramudya </td>
                          <td>0110220025</td>
                          <td>Handle developing program</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-1">
                            <img src="/sig2/GIS/gis-faskes/assets/images/faces-clipart/pic-1.png" alt="image">
                          </td>
                          <td> Roni Prawijaya </td>
                          <td>0110220198</td>
                          <td>Handle developing program</td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
              const totalVaccinationOfCountry = document.querySelector(".vaccination-country .total");

              const getVaccinationFacility = async () => {
                  const response = await fetch('https://kipi.covid19.go.id/api/get-faskes-vaksinasi');
                  const results = await response.json();

                  totalVaccinationOfCountry.innerHTML = `${results.count_total} faskes`;
              }

              getVaccinationFacility();
              </script>