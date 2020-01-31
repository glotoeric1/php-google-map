
<?php
session_start();
$timeNow=time();
if($timeNow >$_SESSION['empire'] ) {
    header('Location:login.php');
    exit();
}
$user=$_SESSION['username'];
require_once 'class/animalClass.php';
$obj2 = new AnimalClass();
// Processing form data when form is submitted
    if (isset($_POST['save'])) {

        //collecting input from form or user and verifying.
        $name=$obj2->RemoveInvalideInput($_POST['name']);
        $type=$obj2->RemoveInvalideInput($_POST['type']);
        $lat=$obj2->RemoveInvalideInput($_POST['lat']);
        $long=$obj2->RemoveInvalideInput($_POST['long']);
        $msg=$obj2->RemoveInvalideInput($_POST['message']);

        if (!empty($name) && !empty($type) && !empty($lat) && !empty($long) && !empty($msg) && !empty($user)){
            if($_FILES['file']['size'] !=0 && $_FILES['file']['name'] !=""){
                $file=$_FILES['file'];

                //inserting into the database.
                $insert=$obj2->InsertAnimals($name, $type, $lat, $long, $file, $msg, $user);
                if($insert){
                    $error='<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Success: </strong>Data has been successfully inserted!</div></div>';
                }else{
                    $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Oops unable to save please try again!</div></div>';
                }
            }else{
                $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>You did not select any image or icon!</div></div>';
            }
        }else{
            $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>There are empty field(s) exit!</div></div>';
        }

    }elseif (isset($_POST['edit'])){

        //collecting input from form or user and verifying.
        $id=$obj2->RemoveInvalideInput( $_POST['id']);
        $name=$obj2->RemoveInvalideInput($_POST['name']);
        $type=$obj2->RemoveInvalideInput($_POST['type']);
        $lat=$obj2->RemoveInvalideInput($_POST['lat']);
        $long=$obj2->RemoveInvalideInput($_POST['long']);
        $msg=$obj2->RemoveInvalideInput($_POST['message']);

        if (!empty($name) && !empty($type) && !empty($lat) && !empty($long) && !empty($msg) && !empty($user)){
            if($_FILES['file']['size'] !=0 && $_FILES['file']['name'] !=""){
                $file=$_FILES['file'];

                //Updating animals table from the database.
                $upate=$obj2->UpdateAnimals($name, $type, $lat, $long, $file, $msg,$user, $id);
                if($upate){
                    $error='<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Success: </strong>Data has been successfully updated!</div></div>';
                }else{
                    $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Oops unable to update please try again!</div></div>';
                }
            }else{
                $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>You did not select any image or icon!</div></div>';
            }
        }else{
            $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button><strong>Error: </strong>There are empty field(s) exit!</div></div>';
        }



    }elseif (isset($_GET['ide'])) {
        include_once 'class/db.php';
        $id = $obj2->RemoveInvalideInput($_GET['ide']);
        $insertAdmin= "SELECT * FROM animals WHERE id=?;";
        $stmt=$db->prepare($insertAdmin);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result){
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['an_name'];
                $lat = $row['lat'];
                $long = $row['lng'];
            }
        }else{
            return false;
        }

}else if (isset($_GET['idd'])){
    $id=$obj2->RemoveInvalideInput($_GET['idd']);
    $sql=$obj2->DeleteAnimals($id);
    if($sql){
        $error='<div class="container"><div class="alert alert-success alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button><strong>Success: </strong>User has been deleted successfully!</div></div>';
    }else{
        $error='<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button><strong>Error: </strong>Oops unable to save please try again!</div></div>';
    }
}

// Fetch the marker info from the database
$result=$obj2->SelectAnimal();

// Fetch the info-window data from the database
$result2=$obj2->SelectAnimal();


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Similie Project</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style1.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCP3zFD_8SzaiAfZtIPGy-UzSmkx_-_EMY&callback=initMap"
            async defer></script>
    <style type="text/css">
        .container-flud {
            height: 450px;
        }
        #mapCanvas {
            width: 100%;
            height: 450px;
        }
    </style>
</head>

<body id="body">

  <!--==========================
    Top Bar
  ============================-->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">
        <i class="fa fa-envelope-o"></i> <a href="mailto:glotoeric@gmail.com">glotoeric@gmail.com</a>
        <i class="fa fa-phone"></i>+22351871859
      </div>
      <div class="social-links float-right">
        <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
        <a href="http://www.facebook.com/eric.k.gloto" class="facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
        <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
        <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
      </div>
    </div>
  </section>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="#body" class="scrollto">Simi<span>lie</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="index.php">Home</a></li>
          <li class="menu-has-children"><a href="#">Service</a>
            <ul>
              <li><a href="sign-up.php">Create User Account</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
          <li><a href="#contact">Add Species</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Google map section
  ============================-->
  <section id="intro">
        <div class="container-flud">
            <div id="mapCanvas"></div>
        </div>
  </section><!-- #intro -->

  <main id="main" style="margin-top: 30px;">

    <!--==========================
      Data entrance form
    ============================-->
    <section id="contact" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
            <?php
            if(isset($error)){
                echo $error;
            }
            ?>
          <h2>Data entrance form </h2>
            <hr style="height: 4px; background-color: #50d8af;">
          <h4 style="font-family: cursive; color: #50d8af;">Below is a form provided to enter Species Data</h4>
        </div>
      <div class="container">
        <div class="form">
          <div id="sendmessage">Animal entrance form!</div>
          <div id="errormessage"></div>
            <div class="col-sm-12 section-t8">
                <div class="row">
                    <div class="col-md-12">
                        <form class="contactForm" action="index.php" method="POST" role="form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <span class="color-text-a">Species name:</span>
                                        <input type="text" name="name" value="<?php if(isset($name)) echo $name;?>" class="form-control form-control-lg form-control-a" placeholder="Specie Name Ex: Eagle" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <span class="color-text-a">Species Type:</span>
                                        <select name="type" class="form-control form-control-lg form-control-a" required>
                                            <option>select...</option>
                                            <option>Rabbits</option>
                                            <option>Birds</option>
                                            <option>Bears</option>
                                        </select>
                                        <div class="validation"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <span class="color-text-a">Latitude:</span>
                                        <input name="lat" type="number" value="<?php if(isset($lat)) echo $lat;?>" step="any" class="form-control form-control-lg form-control-a" placeholder="Must be decimal number, Ex: 12.998899" data-rule="email" data-msg="Ex: 12.675689" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <span class="color-text-a">Longitude:</span>
                                        <input name="long"  type="number" value="<?php if(isset($long)) echo $long;?>" step="any"  class="form-control form-control-lg form-control-a" placeholder="Must be decimal number, Ex: 12.998899" data-rule="email" data-msg="Ex: 12.675689" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <span class="color-text-a">Add icon:</span>
                                        <input name="file"  type="file"  class="form-control form-control-lg form-control-a" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <span class="color-text-a">Species Description:</span>
                                        <textarea name="message" value="<?php if(isset($msg)) echo $msg;?>" class="form-control" name="desc" cols="5" rows="4" data-rule="required" data-msg="Please write something for us" placeholder="Description...." required></textarea>
                                    </div>
                                </div>
                                <div class="text-center"><button type="submit" name="save">Save Data</button></div>
                                <div class="text-center"><button type="submit" name="edit">Edit Data</button></div>

                                <input type="hidden" name="id" value="<?php if(isset($id)) echo $id; ?>" size="30" />

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
          <!--==========================
          Table
        ============================-->
          <div class="row">
              <div class="col-md-12">
                  <hr style="height: 1px; background-color: #50d8af;">
                  <h4  style="font-family: cursive; color: #50d8af;">
                      List of Species:</h4>
                  <form class="form-inline justify-content-center">
                      <input type="text" id="recherche" name="search" placeholder="Enter search item......" class="form-control" size="32">
                  </form><br>
                  <table width="100%" border="" class="table table-striped table-condensed  table-hover text-center" id="tableId">
                      <thead style=""><tr>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">ID#:</th>
                          <th style="width: 280px;background-color: #50d8af;"  scope="col" class="table-dark">Name:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Type:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Latitude:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Longitude:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Icon:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Description:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Date:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Username:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Edit:</th>
                          <th style="width: 50px; background-color: #50d8af;"  scope="col" class="table-dark">Delete:</th>
                      </tr>
                      </thead>
                      <body>

                      <?php
                      require_once 'class/animalClass.php';
                      $obj3 = new AnimalClass();
                      $sql=$obj3->SelectAnimal();
                      if($sql){
                      while ($data=$sql->fetch_assoc()) {
                          echo '<td>'.$data['id'].'</td>';
                          echo '<td>'.$data['an_name'].'</td>';
                          echo '<td>'.$data['an_type'].'</td>';
                          echo '<td>'.$data['lat'].'</td>';
                          echo '<td>'.$data['lng'].'</td>';
                          echo '<td><img style="width: 30px;" src="'.$data['image'].'">'.'</td>';
                          echo '<td>'.$data['description'].'</td>';
                          echo '<td>'.$data['dateEdit'].'</td>';
                          echo '<td>'.$data['username'].'</td>';
                          echo'<td> 
			<button class="btn btn-warning" name="edit"> <a style="color: #ffffff;" href="index.php?ide='.$data['id'].'">Edit</button></a>
			</td>';
                          echo'<td>
			<button class="btn btn-danger" name="delete"> <a style="color: #ffffff;" href="index.php?idd='.$data['id'].'">Delete</button></a>
			</td>';
                          echo '</tr>';}

                      }?>
                      <script>
                          function initMap() {
                              var map;
                              var bounds = new google.maps.LatLngBounds();
                              var mapOptions = {
                                  mapTypeId: 'roadmap'
                              };

                              // Display a map on the web page
                              map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
                              map.setTilt(100);

                              // Multiple markers location, latitude, and longitude
                              var markers = [
                                  <?php if($result->num_rows > 0){
                                  while($row = $result->fetch_assoc()){
                                      echo '["'.$row['an_name'].'", '.$row['lat'].', '.$row['lng'].', "'.$row['image'].'"],';
                                  }
                              }
                                  ?>
                              ];

                              // Info window content
                              var infoWindowContent = [
                                  <?php if($result2->num_rows > 0){
                                  while($row = $result2->fetch_assoc()){ ?>
                                  ['<div class="info_content">' +
                                  '<h4><b><?php echo $row['an_name']; ?></b></h4>' +
                                  '<p style="font-size: 18px;"><?php echo $row['description']; ?></p>' + '</div>'],
                                  <?php }
                                  }
                                  ?>
                              ];

                              // Add multiple markers to map
                              var infoWindow = new google.maps.InfoWindow(), marker, i;

                              // Place each marker on the map
                              for( i = 0; i < markers.length; i++ ) {
                                  var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                                  bounds.extend(position);
                                  marker = new google.maps.Marker({
                                      position: position,
                                      map: map,
                                      icon: markers[i][3],
                                      title: markers[i][0]
                                  });

                                  // Add info window to marker
                                  google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                      return function() {
                                          infoWindow.setContent(infoWindowContent[i][0]);
                                          infoWindow.open(map, marker);
                                      }
                                  })(marker, i));

                                  // Center the map to fit all markers on the screen
                                  map.fitBounds(bounds);
                              }

                              // Set zoom level
                              var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                                  this.setZoom(2);
                                  google.maps.event.removeListener(boundsListener);
                              });
                          }

                          // Load initialize function
                          google.maps.event.addDomListener(window, 'load', initMap);
                      </script>
                      </body>
                  </table>
              </div><hr>
          </div><hr>
        </div>
        </div>
        </div>
    </section>
  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Eric</strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://facebook.com/eric.gloto">Eric Enterprise</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/magnific-popup/magnific-popup.min.js"></script>
  <script src="lib/sticky/sticky.js"></script>


  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
  <script src="js/search_table.js"></script>

</body>
</html>
