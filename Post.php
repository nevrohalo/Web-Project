<?php
    include_once "Header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Juxhin Abazi">
        <link rel="stylesheet" type="text/css" href="StylePost.css">
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="js/jquery.validate.js"></script>
        <title>UNYT Post</title>    
    </head>
    <body>
        <?php
            include_once "DBConnect.php";
        
            $postID = $_GET["post"];
            $userID = $_SESSION["user_id"];
        
            $query_user_info = "SELECT name, description FROM user WHERE user_id = '".$userID."'";
            $user_info = mysqli_fetch_assoc(mysqli_query($connection, $query_user_info)) or die(mysqli_error($connection));
        ?>

        <!--Sub Sidebar-->
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

        <!--Sub Sidebar-->
        <div id="user_bar">
            <img src="images/user_male.png" class="avatar">
            <h1><?php echo $user_info['name']?></h1>
            <p><?php echo $user_info['description']?></p>
            <div><form action="ParseOpenMain.php"><button>Go to Main Page</button></form></div>
            <div><form action="ParseOpenUser.php" method="post">
                <button type="submit">Go to User Page</button>
                <input type="hidden" name="user_id" value="<?php echo $userID;?>"/>
            </form></div>
            <div><button onclick="document.getElementById('id01').style.display='block'">Create a New Post</button></div>
            <div><button onclick="document.getElementById('id02').style.display='block'">Create a New Sub</button></div>
            <div><form action="ParseLogOut.php"><button>Log Out</button></form></div>
        </div>
        
        <!--Post Block-->
        <div class="comment_box">            
            <?php
                include "DBConnect.php";

                $query = "SELECT * FROM post, user WHERE post.post_id = ".$postID." AND post.user_id = user.user_id";
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                $row = mysqli_fetch_assoc($result);

                echo "<div class='container_comment'>";
                echo    "<div class='container_text'>";
                echo        "<p class='title_p'>".$row["title"]." <em>by <a href='User.php?user_id=".$row['user_id']."&cat=1'>".$row["username"]."</a></em></p>";
                echo        "<p class='content_c'>".$row["content"]."</p>";
                echo    "</div>";
                echo "</div>";
                    
                mysqli_close($connection);
            ?>
            
            <!--New Comment Form-->
            <hr>
            <div class="write_comment">
                <form action="ParseCreateComment.php" method="post">
                    <hr>
                    <label for="content"><emp>Type your comment here:<br></emp></label>
                    <input type="textarea" placeholder="Enter Comment" name="content" minlength="20" required>

                    <input type="hidden" name="user_id" value="<?php echo $userID;?>"/>
                    <input type="hidden" name="post_id" value="<?php echo $postID;?>"/>

                    <div class="comment_form">
                        <button class="cancelbtn" type="button">Cancel</button>
                        <button class="createbtn" type="submit">Create</button>
                    </div>
                </form>
            </div>

            <!--Comments Block-->
            <hr>
            <h3>Comments</h3>
            <?php
                include "DBConnect.php";

                $query = "SELECT comment.comment_id, comment.content, comment.date, comment.post_id, comment.user_id, user.username 
                          FROM comment, user, post 
                          WHERE comment.post_id = ".$postID." AND comment.user_id = user.user_id AND comment.post_id = post.post_id ORDER BY date DESC";
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                   
                if (mysqli_num_rows($result) > 0) 
                {
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        echo "<div class='container_comment'>";
                        echo    "<div class='container_text'>";
                        echo        "<p class='title_p'>".$row["content"]."</p>";
                        echo        "<p class='content_p'>".$row["date"]." <em>by <a href='User.php?user_id=".$row['user_id']."&cat=2'>".$row["username"]."</a></em></p>";
                        echo    "</div>";
                        echo "</div>";
                    }
                }
                else
                {
                    echo "<div class='container_post'>";
                    echo    "<img class='post_icon' src='images/attention.png' alt='Attention Icon'>";
                    echo    "<div class='container_text'>";
                    echo        "<p class='title_p'>There are no comments written here yet!</p>";
                    echo        "<p class='time_p'>You can always write one.</p>";
                    echo    "</div>";
                    echo "</div>";
                }
                    
                mysqli_close($connection);
            ?>
        </div>

        <div id="id01" class="modal">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <form class="modal-content" action="ParseCreatePost.php" method = "post">
                <div class="container">
                    <h1>Creating a new Post</h1>
                    <p>Please fill in this form to create a new post.</p>
                    <hr>

                    <label for="title"><emp>Post Title</emmp></label>
                    <input type="text" placeholder="Enter Title" name="title" minlength="10" required>

                    <label for="content"><emp>Post Content</emp></label>
                    <input type="textarea" placeholder="Enter Content" name="content" minlength="20" required>

                    <label for="sub"><emp>Post Sub</emp></label>
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
                    <input type="textarea" placeholder="Enter Description"name="description"  minlength="20" required>
                    
                    <input type="hidden" name="user_id" value="<?php echo $userID;?>"/>

                    <div class="clearfix">
                        <button class="cancelbtn" type="button" onclick="document.getElementById('id02').style.display='none'">Cancel</button>
                        <button type="submit" class="createbtn">Create</button>
                    </div>
                </div>
            </form>
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