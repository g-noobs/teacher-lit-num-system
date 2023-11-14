<?php 
class PHPClass{
    function generatePassword($length = 8) {
        // Define a set of characters to choose from for the password
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
    
        // Get the total number of characters
        $characterCount = strlen($characters);
    
        // Initialize an empty password string
        $password = '';
    
        // Generate a random password by selecting characters randomly from the set
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = random_int(0, $characterCount - 1);
            $password .= $characters[$randomIndex];
        }
    
        return $password;
    }
    function displayError(){
        echo '<section class="content">
        <div class="error-page">
        <h2 class="headline text-red">500</h2>
        <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
        <p>
        We will work on fixing that right away.
        Meanwhile, you may <a href="dashboard.php">return to dashboard</a> or try using the search form.
        </p>
        <form class="search-form">
        <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search">
        <div class="input-group-btn">
        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
        </button>
        </div>
        </div>
        
        </form>
        </div>
        </div>
        
        </section>';
    }
    function getFormattedCurrentDate() {
        $formattedDate = date("Y-m-d H:i:s"); // Get the current date and time in the format: YYYY-MM-DD HH:MM:SS
        return $formattedDate;
    }
}
?>