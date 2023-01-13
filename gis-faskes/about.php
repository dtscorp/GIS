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
                        <i class="mdi mdi-information"></i>
                    </span>
                    About
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
                            <p class="card-description" style="line-height: 1.7;">Program ini merupakan salah satu
                                contoh
                                dari penerapan SIG
                                (Sistem Informasih Geografis), memanfaatkan data dari <a
                                    href="https://covid19.go.id/dokumentasi-api-faskes-vaksinasi">dokumentasi faskes</a>
                                yang disediakan pemerintah yang berisi beberapa data fasilitas kesehatan yang mengadakan
                                vaksinasi Covid-19 dengan beberapa golongan sesuai ketersediaan. tujuan dari program ini
                                dibuat adalah untuk mempermudah masyarakat mencari fasilitas kesehatan yang menyediakan
                                vaksinasi Covid-19</p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">About Us</h4>
                            <p class="card-description"> And our Contribution
                            </p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> User</th>
                                        <th> Name </th>
                                        <th> NIM </th>
                                        <th> Contribution </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-1">
                                            <img src="./assets/images/faces-clipart/pic-1.png" alt="image">
                                        </td>
                                        <td> Abdulloh Fahmi </td>
                                        <td>0110220071</td>
                                        <td>Handle search faskes features</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">
                                            <img src="./assets/images/faces-clipart/pic-4.png" alt="image">
                                        </td>
                                        <td> Danang Tri Saputro </td>
                                        <td>0110220057</td>
                                        <td>Handle templating the program</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">
                                            <img src="./assets/images/faces-clipart/pic-2.png" alt="image">
                                        </td>
                                        <td> Seli Mulyani </td>
                                        <td>0110220020</td>
                                        <td>Handle report document</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">
                                            <img src="./assets/images/faces-clipart/pic-1.png" alt="image">
                                        </td>
                                        <td> Wahyu Adi Pramudya </td>
                                        <td>0110220025</td>
                                        <td>Handle developing program</td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">
                                            <img src="./assets/images/faces-clipart/pic-4.png" alt="image">
                                        </td>
                                        <td> Roni Prawijaya </td>
                                        <td>0110220198</td>
                                        <td>Handle developing program</td>
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