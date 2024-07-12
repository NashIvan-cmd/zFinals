$.ajax({
    url: 'http://localhost:3000/zFinals/seller.php',
    type: 'post',
    success: function(response) {
        if(response == "success"){
            alert("Product added successfully!");
        } else {
            alert("Error adding product.");
        }
    }
});