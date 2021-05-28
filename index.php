<!DOCTYPE html>
<html>
    <head><title>Hertz-UTS</title></head>
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        let cars_array = []; // store cars.json
        let cart_array = []; //store car added to cart

        if(window.sessionStorage.getItem("cart")) {
            cart_array = JSON.parse(window.sessionStorage.getItem("cart"));
        }
        $(document).ready(function() {
            $.getJSON("cars.json", function(data) {
                cars_array = data;
              $.each(data, function(i, field){
                  // list cars on homepage
                  let carComponent = 
                  `
                    <div class="card card-1">
                    <div class="car-img-container"><img style="width:350px;height:350px;" src=${field.img} alt="${field.brand} ${field.model}"></div>
                    <h2>${field.brand}-${field.model}-${field.model_year}</h2><br>
                    <p><b>Mileage: </b>${field.mileage} kms</p>
                    <p><b>Fuel Type: </b>${field.fuel_type}</p>
                    <p><b>Seats: </b>${field.seats}</p>
                    <p><b>Price/day: </b>${field.price_per_day}</p>
                    <p><b>Availability: </b>${field.availability}</p>
                    <br>
                    <p><b>Description: </b>${field.description}</p>
                    <br>
                    <button class="button button-add" onClick="addCar(${field.id})">Add to cart</button>
                    </div>
                  `
                  $(".main").append(carComponent);
                });
            });
        });
        
        //add car to cart
        function addCar(id) {
            //check if car in .json
            let car = cars_array.find(car => car.id == id);
            //check if car in shopping cart
            let car_in_cart = cart_array.find(car => car.id == id);
            
            if (car_in_cart) {
                alert("You have added to your shopping cart."); //pop up message
            } else if (car.availability == "N") {
                alert("Sorry, the car is not available now. Please try other cars.");
            } else {
                cart_array.push(car);
                alert("Add to cart successfully.");
            }
            return true;
        }
        
        function cart() {
            let cart_json = JSON.stringify(cart_array); //convert cart_array into string
            window.sessionStorage.setItem("cart", cart_json); //set storage
            window.location.href="cart.php";
        }
        
		        
	</script>
    
    <body>
        <header>
            <div class="inner">
                <div class="home">
                    <a class="logo" href="index.php">Hertz-UTS</a>
                </div>
                <div align="center"><h2 style="color:#fff;">Car Rental Centre</h2></div>
                <div><button class="button button-rsv" onClick=cart()>Reservation</button></div>
            </div>
        </header>
        <div id="slider">
            <img src="images/homepage.jpg">
		</div>
		
		<div class="main"></div>
    </body>
    
    <div class="footer"><p>Car Rental: Hertz-UTS by 13xxxxxx</p></div>
</html>