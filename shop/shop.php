<?php
include ("/var/db/dbconfig.php");
include('/var/www/html/HackTheVirusWeb/db/errors.php');

$nume_produs = "";
$pret = "";
$descriere = "";
$cantitate = "";
$errors = array(); 
$available_users = array();
$index=1;

if (isset($_POST['search_user']))
{
  $nume_produs = mysqli_real_escape_string($db, $_POST['nume_produs']);
  $pret = mysqli_real_escape_string($db, $_POST['pret']);
  $descriere = mysqli_real_escape_string($db, $_POST['descriere']);
  $cantitate = mysqli_real_escape_string($db, $_POST['cantitate']);

  if (empty($nume_produs)) { array_push($errors, "Specificati un nume_produs"); }
  if (empty($pret)) { array_push($errors, "Specificati de cand"); }
  if (empty($descriere)) { array_push($errors, "Specificati pana cand"); }
  if (empty($cantitate)) { array_push($errors, "Specificati talia animalului"); }
  

  $user_check_query = "SELECT * FROM anunturi";
  $result = mysqli_query($db, $user_check_query);
  

  if ($result) {
    $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach($user AS $row)
    {
        $available_users[$index]=$row['id'];
        $index++;
    }
  }
  else{
    /*echo "<script type='text/javascript'>
          alert('Nu s-a gasit anunt.');
          window.location = 'index.php';
          </script>";*/
  }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Vegefoods - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
<body class="goto-here">
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">	    
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
			  <li class="nav-item"><a href="index.html" class="nav-link">Shop</a></li>
			<li class="nav-item cta cta-colored"><a href="cart.html" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>


    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Products</span></p>
            <h1 class="mb-0 bread">Products</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center">
    			<div class="col-md-10 mb-5 text-center">
    				<ul class="product-category">
    					<li><a href="#" class="active">Oferte</a></li>
    				</ul>
    			</div>
    		</div>
    		<div class="row">
                <?php
                    $index--;
                    $ok = 0;
                    while($index)
                    {
                            $query = "SELECT * FROM anunturi WHERE id='$available_users[$index]'";
                            $result=mysqli_query($db, $query);
                            $ok = 1;
                           

                          if ($result) {
                              while ($row = $result->fetch_assoc()) {

                                $ppoza = $row["poza"];
                                $sql = "SELECT * FROM image_upload WHERE id='$ppoza'";
                                $result2 = mysqli_query($db, $sql);
                                $row2 = mysqli_fetch_assoc($result2);
                                  
                                $ppoza = $row2['image'];
                                $pname = $row["nume_produs"];
                                $ppret = $row["pret"];
                                $pcantitate = $row["cantitate"];
                                $pdescriere = $row['descriere'];
                
                                         echo '
                                         <div class="col-md-6 col-lg-3 ftco-animate">
                                            <div class="product">
                                                <a href="#" class="img-prod"><img class="img-fluid" src="../uploads/'.$ppoza.'" alt="Colorlib Template">
                                                    <span class="status">30%</span>
                                                    <div class="overlay"></div>
                                                </a>
                                                <div class="text py-3 pb-4 px-3 text-center">
                                                    <h3><a href="#">'.$pname.'</a></h3>
                                                    <div class="d-flex">
                                                        <div class="pricing">
                                                            <p class="price"><span class="mr-2 price">'.$ppret.'</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="bottom-area d-flex px-3">
                                                        <div class="m-auto d-flex">
                                                            <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                                                <span><i class="ion-ios-menu"></i></span>
                                                            </a>
                                                            <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                                                <span><i class="ion-ios-cart"></i></span>
                                                            </a>
                                                            <a href="#" class="heart d-flex justify-content-center align-items-center ">
                                                                <span><i class="ion-ios-heart"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                              }
                      }

                              $result->free();
                              $index--;
                      }

                    echo '</div></div></div></section>';
                    if(!$ok)
                    {
                      ?><script type="text/javascript">
                              window.location='index.html';
                              alert("Nu s-a gasit anunt.");

                              </script><?php
                    }
                    ?>

    				</div>
    			</div>
    		</div>
    		<div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
    	</div>
    </section>	
	 <footer class="ftco-footer ftco-section">
    	 <!--   <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Vegefoods</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">About</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
					 <li><a href="#" class="py-2 d-block">FAQs<a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>-->
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>