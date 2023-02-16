<?php

session_start();



if(!isset($_GET['username'])) {

  header("Location: index.php");

  exit;

}

//connect to database

$servername = "localhost";

$username = "root";

$password = "";

$dbname = "users";



// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

} 



$profileUsername = $_GET['username'];



if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {



}else{

  $loggedInUsername = $_SESSION['user'];

  $sql = "SELECT id FROM users WHERE username = '$loggedInUsername'";

  $result = $conn->query($sql);



  if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $loggedInUserId = $row['id'];

  }

}



$sql = "SELECT id, fullname, image, userProfileColor, date_created, description FROM users WHERE username = '$profileUsername'";

$result = $conn->query($sql);



if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

        $profileImage = $row["image"];

        $profileName = $row["fullname"];

        $background_color = $row["userProfileColor"];

        $register_date1 = $row["date_created"];

        $describe_user = $row["description"];

    }

} else {

    die("Profile not found");

}



$isOwner = false;

if(isset($_SESSION['user'])) {

  $username = $_SESSION['user'];

  if($username == $profileUsername) {

    $isOwner = true;

  }

}



?>

 <html>

<head>

  <title>Profile Page - <?php echo $profileUsername; ?></title>

  <link rel="stylesheet" href="/CSS/profile.css">

  <style>

  header {

    background-color: <?php echo $background_color; ?>;

  }

  backColorPick {

      background-color: <?php echo $background_color; ?>;

  }

  </style>

  <style>

    .rounded-border1 {

      border: 1px solid black;

      border-radius: 50%;

      display: inline-block;

      height: 100px;

   }

   .comments{

    margin-left: 0px;

    top: 295px;

    margin-top: 0px;

    left: 35%;

    right: 35%;

    border-radius: 5px;

    padding-left: 10px;

    padding-top: 10px;

    padding-bottom: 10px;

    filter: drop-shadow(0 0 0.75rem black);

    background: white;

    width: 30%;

    

    position: absolute;

   }

   .about{

    border-radius: 5px;

    margin-right: 75%;

    padding-left: 10px;

    padding-top: 10px;

    padding-bottom: 10px;

    filter: drop-shadow(0 0 0.75rem black);

    background: white;

    width: 20%;

    display: inline-block;

   }

   body{

    background-color: #c9c9c9;

    height: 100%;

    width: 100%;

    left: 0;

}

  </style>

</head>

<body>



  <header>

    <?php include 'nav.php';?>

    <h1 style="margin-top: 50px;">Welcome to <?php echo $profileUsername; $profileName; ?>'s profile page!</h1>

    <p><?php echo "<img class='rounded-border1' style='width: 100px; height: 100px; object-fit: cover;' src='/PFP/$profileImage'>"; ?><?php echo $profileUsername; $profileImage;?></p>

    <?php if($isOwner): ?>

      <a href="/user/setting/<?php echo $profileUsername; ?>">Edit Profile</a>

    <?php else: ?>

    <?php endif; ?>

  </header>

  <div>

    <div style="margin-left: 3%; margin-top: 10px;">

      <div class="about">

        <h2>About</h2>

          <?php

            echo"   

            <p><strong>Username: </strong> $profileUsername</p>

            <p><strong>Name: </strong> $profileName</p>

            <p><strong>Member Since: </strong>$register_date1</p><br>

            ";

          ?>

          <h2>Description</h2>

          <?php echo"<p><strong><i style='color:grey;'>$describe_user</i></strong></p><br>";?>

      </div>

      <div style="margin-bottom: -10px;"class="comments">

        <h2>Comments</h2>

	</div>

        <?php

            // connect to the database

            $conn = mysqli_connect("localhost", "root", "", "users");



            if (!$conn) {

                die("Connection failed: " . mysqli_connect_error());

            }



            $query = "SELECT * FROM products";

            $result = mysqli_query($conn, $query);

            $found = false; // flag to keep track of whether a comment has been f



            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    echo '<div style="margin-bottom: 100%; margin-top: 120px; display: flex; flex-direction: column; " class="comments">';

                    $product_id = $row['id'];

                    $product_url = "/product.php?id=$product_id";

                    $product_name = ucfirst($row['product_name']);

                    $description = ucfirst($row['description']);

                    $image = $row['image'];

                    $sql = "SELECT comment, username, created_at FROM comments WHERE product_id = '$product_id' and username='$profileUsername' ORDER BY created_at DESC";                        $result1 = mysqli_query($conn, $sql);



                    if (mysqli_num_rows($result1) > 0) { // check if the user has commented on the product

                        $found = true;

                        echo "<div>";

                        echo "<a href='$product_url'><h3 style='font-size: 24px; margin-bottom: -10px;'>$product_name</h3></a><br>";

                        while ($row = mysqli_fetch_assoc($result1)) {

                            echo $row['username'], '<p style="display: inline;">: </p>';

                            echo $row['comment'];

                            echo "<p style='margin-top: 0px;'>" . date('F j, Y, g:i a', strtotime($row['created_at'])) . "</p>";

                        echo '</div>';

                        }

                    }

                    echo '</div>';

                }

                echo '</div>';

                if (!$found) {

                    echo "This user has made no comments.";

                }

            }

        ?> 

  </div>

</body>

</html>

<html>

  <body>

    

  </body>

</html>





<?php

//$query = "SELECT * FROM comments WHERE username='$profileUsername'";

        // get product info

        //$query1 = "SELECT * FROM products";

       // $result2 = mysqli_query($conn, $query1);

        //$product_id = $row['id'];

        //$product_url = "product.php?id=$product_id";

        //$product_name = ucfirst($row['product_name']);



// if (mysqli_num_rows($result) > 0) {

//                while ($row = mysqli_fetch_assoc($result)) {

//                  $id = $row['id'];

//                  $product_url = "product.php?id=$product_id";

//                  $product_name = ucfirst($row['product_name']);

//                  $description = ucfirst($row['description']);

//                  $image = $row['image'];

//                }

//              }

//

?>
