<!DOCTYPE html>
<html>
    <head><title>Hertz-UTS</title></head>
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        let cart_array, totalPrice = 0;
        
        //load cars in cart
        $(document).ready(function() {
            cart_array = JSON.parse(window.sessionStorage.getItem("cart")); //retreive sessionStorage
            $.each(cart_array, function(i, field) {
                let car = 
                `
                <tr id="${field.id}">
                    <td>
                        <img style="width:200px;height:150px;" src=${field.img} alt="${field.brand} ${field.model}">
                    </td>
                    <td style="width:200px;">${field.brand}-${field.model}-${field.model_year}</td>
                    <td>${field.price_per_day}</td>
                    <td>
                        <input id="item-${field.id}" type="number" min="0" value="1" style="text-align: center;" class="items"></input>
                    </td>
                    <td >
                        <button class="button" id="btn" onclick="deleteCar(${field.id})">Delete</button>
                    </td>
                </tr>
                `
                $(".reservelist").append(car);
            });
            // if(cart_array.length > 0) {
            //     <button class="button button-rsv" onclick="checkout()">Checkout</button>
            // }
        });
        
        //Checkout button is clicked
        function checkout() {
            //no car in cart
            if (cart_array.length <= 0) {
                alert("No car has been reserved."); //alert message 
                window.location.href="index.php"; //direct to homepage
            } else {
                //has car in carts
                //then check if rental day valid and calculate price
                var price = 0;
                let items = document.getElementsByClassName("items");
                let rentalDayValid = validateDay(items); //validate the rental day
                if (rentalDayValid) {
                    console.log("price");
                    price = calculatePrice(items); //calculate total price
                    window.sessionStorage.setItem("price", price); //store total price
                    window.location.href="checkout.php"; //direct to checkout page
                }  
            }
        }
        
        //Validate Rental day input
        function validateDay(days) {
            var state = true; //to store boolean
            $.each(days, function(i, item) {
                if(item.value <= 0 || item.value.length == 0) {
                    alert("Rental Day has to be at least 1 day. Please confirm the rental day.");
                    // console.log("false day");
                    state = false;
                } else {
                    // console.log("true day");
                    state = true;
                }
            });
            return state;
        }

        //Calculate price
        function calculatePrice(price) {
            let totalPrice = 0;
            $.each(price, function(i, item) {
                let id = item.id.split('-')[1]; //get car id
                let car = cart_array.find(car => car.id == id); //find if the car in cart
                
                //calculate the total price
                let days = parseInt(item.value);
                let dailyPrice = parseInt(car.price_per_day);
                totalPrice += days * dailyPrice;
            });
            return totalPrice;
        }
        
        //Delete button is clicked
        function deleteCar(id) {
            cart_array = cart_array.filter(car => car.id != id); //filter the car id that not the deteled car
            window.sessionStorage.setItem("cart", JSON.stringify(cart_array)); //reset sessionStorage
            document.getElementById(`${id}`).remove(); //remove car from cart
        }
        
        //return to homepage
        function back(){
        	    window.location.href = "index.php";	
        }
        
    </script>
    
    <body>
        <header>
            <div class="inner">
                <div class="home">
                    <a class="logo" href="index.php">Hertz-UTS</a>
                </div>
                <div align="center"><h2 style="color:#fff; justify-content: center;">Car Rental Centre</h2></div>
                <div><button class="button button-rsv" onClick=checkout()>Checkout</button></div>
            </div>
        </header>
        
        <div class="container">
            <h1 style="text-align: center;">Car Reservation</h1><br>
                <table class="reservelist">
                    <th>Thumbnail</th>
                    <th>Car(s)</th>
                    <th>Price Per Day</th>
                    <th>Rental Day(s)</th>
                    <th>Action</th>
                </table>
        </div>
        

    </body>
</html>