<?php
    include_once "Header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNYT Forum</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Juxhin Abazi">
        <link rel="stylesheet" type="text/css" href="StyleMain.css">
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="js/jquery.validate.js"></script>  
    </head>
    <body>
        <?php
            $subID = $_GET['sub'];
            $userID = $_SESSION['user_id'];
        ?>

        <!--Sub Sidebar - to be substituted with a list generating PHP code-->
        <div id="sub_bar">
            <?php
                include "DBConnect.php";

                $query = "SELECT * FROM sub";
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                
                if (mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<a href=\"Main.php?sub=".urlencode($row['sub_id'])."\">".$row['title']."</a>";
                    }
                }
                else
                {
                    echo "<a>No Subs Created!</a>";
                }
                    
                mysqli_close($connection);
            ?>
        </div>

        <div id="container">
            <!--User Sidebar - to be substituted with an information generating PHP code-->
            <div id="user_bar">
                <img src="images/user_male.png" class="avatar">
                <h1><?php echo $_SESSION['name']?></h1>
                <p><?php echo $_SESSION['description']?></p>
                <div><form action="ParseOpenUser.php" method="post">
                    <button type="submit">Go to User Page</button>
                    <input type="hidden" name="user_id" value="<?php echo $userID;?>"/>
                </form></div>
                <div><button onclick="document.getElementById('id01').style.display='block'">Create a New Post</button></div>
                <div><button onclick="document.getElementById('id02').style.display='block'">Create a New Sub</button></div>
                <div><form action="ParseLogOut.php"><button>Log Out</button></form></div>
            </div>
            
            <!--Post Block - to be substituted with a block generating PHP code-->
            <div class="post_box">
                <?php                    
                    include "DBConnect.php";

                    $query = "SELECT * FROM sub WHERE sub_id =".$subID."";
                    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                    $row = mysqli_fetch_assoc($result);

                    echo "<hr><h3>".$row['title']."</h3><hr>";
                    echo "<p>".$row['description']."</p>";
                    echo "<p>Click on the icon to open the post.</p><hr><br>";
                    
                    mysqli_close($connection);
                ?>

                <?php
                    include "DBConnect.php";

                    $query = "SELECT  post.post_id, post.title, post.content, post.date, post.user_id, post.sub_id, user.username
                              FROM post, user, sub 
                              WHERE post.sub_id = $subID
                                    AND post.user_id = user.user_id 
                                    AND post.sub_id = sub.sub_id ORDER BY date DESC";
                    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                    

                    if (mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {                            
                            echo "<div class='container_post'>";
                            echo    "<a href=\"Post.php?post=".$row["post_id"]."\"><img class='post_icon' src='images/post.png' alt='Post Icon'></a>";
                            echo    "<div class='container_text'>";
                            echo        "<p class='title_p'>".$row["title"]." <em>by <a href='User.php?user_id=".$row['user_id']."&cat=1'>".$row["username"]."</a></em></p>";
                            echo        "<p class='time_p'>".$row["date"]."</p>";
                            echo    "</div>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='container_post'>";
                        echo    "<img class='post_icon' src='images/attention.png' alt='Attention Icon'>";
                        echo    "<div class='container_text'>";
                        echo        "<p class='title_p'>There are no posts written here yet!</p>";
                        echo        "<p class='time_p'>You can always write one.</p>";
                        echo    "</div>";
                        echo "</div>";
                    }
                        
                    mysqli_close($connection);
                ?>                
            </div>

            <!--Modal Post Submit-->
            <div id="id01" class="modal">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <form class="modal-content" action="ParseCreatePost.php" method="post">
                    <div class="container">
                        <h1>Creating a new Post</h1>
                        <p>Please fill in this form to create a new post.</p>
                        <hr>

                        <label for="title"><emp>Post Title</emmp></label>
                        <input type="text" placeholder="Enter Title" name="title" minlength="10" required>

                        <label for="content"><emp>Post Content</emp></label>
                        <input type="textarea" placeholder="Enter Content" name="content" minlength="20" required>

                        <label for="sub"><emp>Select Sub where to post: </emp></label>
                        <select name="sub">
                            <?php
                                
                                include "DBConnect.php";

                                $query = "SELECT * FROM sub";
                                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                                if (mysqli_num_rows($result) > 0) 
                                {
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<option value=\"".$row['sub_id']."\">".$row['title']."</option>";
                                    }
                                }
                                else
                                {
                                    echo "<option value='-1'>There are no subs created yet!</option>";
                                }
                                    
                                mysqli_close($connection);
                            ?>
                        </select>

                        <input type="hidden" name="user_id" value="<?php echo $userID;?>"/>

                        <div class="clearfix">
                            <button class="cancelbtn" type="button" onclick="document.getElementById('id01').style.display='none'">Cancel</button>
                            <button type="submit" name="post_submit" class="createbtn">Create</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--Modal Sub Submit-->
            <div id="id02" class="modal">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <form class="modal-content" action="ParseCreateSub.php" method="post">
                    <div class="container">
                        <h1>Creating a new Sub</h1>
                        <p>Please fill in this form to create a new sub.</p>
                        <hr>

                        <label for="title"><emp>Sub Title</emp></label>
                        <input type="text" placeholder="Enter Title" name="title" minlength="3" required>

                        <label for="description"><emp>Sub Content</emp></label>
                        <input type="textarea" placeholder="Enter Description" name="description" minlength="20" required>
                        
                        <input type="hidden" name="user_id" value="<?php echo $userID;?>"/>

                        <div class="clearfix">
                            <button class="cancelbtn" type="button" onclick="document.getElementById('id02').style.display='none'">Cancel</button>
                            <button type="submit" class="createbtn">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById('id01');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <script>
            // Get the modal
            var modal = document.getElementById('id02');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </body>
</html>