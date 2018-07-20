<?php
    include_once "Header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNYT User</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Juxhin Abazi">
        <link rel="stylesheet" type="text/css" href="StyleUser.css">
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="js/jquery.validate.js"></script>  
    </head>
    <body>
        <?php
            include_once "DBConnect.php";

            $userID = $_GET['user_id'];
            $category = $_GET['cat'];
            
            $query_user_info = "SELECT user_id, name, description FROM user WHERE user_id = '".$userID."'";
            $user_info = mysqli_fetch_assoc(mysqli_query($connection, $query_user_info)) or die(mysqli_error($connection));
        ?>

        <!--Submission Navigation bar-->
        <div id="submission_bar">
            <?php
                echo "<a href=\"User.php?user_id=".$userID."&amp;cat=1\">Posts</a>";
                echo "<a href=\"User.php?user_id=".$userID."&amp;cat=2\">Comment</a>";
            
                if ($_SESSION['user_id'] == $userID)
                    echo "<a href='User.php?user_id=".$userID."&amp;cat=3'>Settings</a>";
            ?>
        </div>

        <!--User Sidebar-->
        <div id="user_bar">
            <img src="images/user_male.png" class="avatar">
            <h1><?php echo $user_info['name']?></h1>
            <p><?php echo $user_info['description']?></p>
            <div><form action="ParseOpenMain.php"><button>Go to Main Page</button></form></div>
            <?php
                if ($_SESSION['user_id'] === $userID)
                {
                    echo "<div><button onclick=\"document.getElementById('id01').style.display='block'\">Create a New Post</button></div>";
                    echo "<div><button onclick=\"document.getElementById('id02').style.display='block'\">Create a New Sub</button></div>";
                    echo "<div><form action=\"ParseLogOut.php\"><button>Log Out</button></form></div>";
                }
            ?>
        </div>

        <!--Post Block-->
        <div class="post_box">
            <?php
                if (isset($_GET['err']))
                {
                    if ($_GET['err'] == 1)
                    {
                        echo "The passwords don't match!";
                    }
                    else if ($_GET['err'] == 2)
                    {
                        echo "Make sure your current password is correct!";
                    }
                    else if ($_GET['err'] == 3)
                    {
                        echo "To change password you must fill all the required textboxes!";
                    }
                }
            ?>

            <?php
                include_once "DBConnect.php";
                
                if($category == 1)
                {
                    $query = "SELECT * FROM post, user WHERE post.user_id = ".$userID." AND post.user_id = user.user_id ORDER BY date DESC";               
                    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                    echo "<h3>Posts by ".$user_info['name']."</h3>";
                    echo "<p>Click on the icon any post you like to open it.</p>";
                    
                    if (mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo "<div class='container_post'>";
                            echo    "<a href=\"Post.php?post=".$row["post_id"]."\"><img class='post_icon' src='images/post.png' alt='Post Icon'></a>";
                            echo    "<div class='container_text'>";
                            echo        "<p class='title_p'>".$row["title"]." <em>by ".$row["username"]."</em></p>";
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
                        echo        "<p class='title_p'>There are no post by this user!</p>";
                        echo        "<p class='time_p'>You can always write one.</p>";
                        echo    "</div>";
                        echo "</div>";
                    }
                }
                else if($category == 2)
                {
                    $query = "SELECT comment.comment_id, comment.content, comment.date, comment.user_id, comment.post_id, user.username, post.title " 
                            ."FROM comment, user, post "
                            ."WHERE comment.user_id = '".$userID."' AND comment.user_id = user.user_id AND comment.post_id = post.post_id ORDER BY date DESC";               
                    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                    echo "<h3>Comments by ".$user_info['name']."</h3>";
                    echo "<p>Click on the icon of the comment to open where it is posted.</p>";
                    
                    if (mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo "<div class='container_post'>";
                            echo    "<a href=\"Post.php?post=".$row["post_id"]."\"><img class='post_icon' src='images/comment.png' alt='Post Icon'></a>";
                            echo    "<div class='container_text'>";
                            echo        "<p class='title_p'>".$row["content"]."</p>";
                            echo        "<p class='time_p'>".$row["date"]." <em>(posted at <a href=\"Post.php?post=".$row["post_id"]."\">".$row["title"]."</a></em>)</p>";
                            echo    "</div>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='container_post'>";
                        echo    "<img class='post_icon' src='images/attention.png' alt='Attention Icon'>";
                        echo    "<div class='container_text'>";
                        echo        "<p class='title_p'>There are no comments by this user!</p>";
                        echo        "<p class='time_p'>You can always write one.</p>";
                        echo    "</div>";
                        echo "</div>";
                    }
                }
                else if ($category == 3)
                {
                    echo "<h2 align=\"Center\">User Settings</h2>";
                    echo "<div class=\"settings\"><form action=\"ParseChangeSettings.php\" method=\"post\"";
                    echo    "<hr><hr><label for=\"oldPassword\"><emp>Enter Old Password: </emmp></label>";
                    echo    "<input type=\"password\" placeholder=\"Enter Old Password\" name=\"oldPassword\">";
                    
                    echo    "<label for=\"newPassword\"><emp>Enter New Password: </emmp></label>";
                    echo    "<input type=\"password\" placeholder=\"Enter New Password\" name=\"newPassword\" minlength=\"8\">";
                    
                    echo    "<label for=\"rePassword\"><emp>Re-Enter New Password: </emmp></label>";
                    echo    "<input type=\"password\" placeholder=\"Re - Enter New Password\" name=\"rePassword\" minlength=\"8\"><hr>";
                    
                    echo    "<label for=\"name\"><emp>Enter New Name: </emp></label>";
                    echo    "<input type=\"text\" placeholder=\"Enter New Name (username cannot be changed for security reasons)\" name=\"name\" minlength=\"3\">";

                    echo    "<label for=\"description\"><emp>Enter New Description: </emp></label>";
                    echo    "<input type=\"textarea\" placeholder=\"Enter New Description\" name=\"description\" minlength=\"30\"><hr>";

                    echo    "<input type=\"hidden\" name=\"user_id\" value=".$userID.">";
                    echo    "<input type=\"checkbox\" name=\"delete\">";
                    echo    "<label for=\"delete\"><emp>Check if you want to Delete your Account.</emmp></label><hr>";

                    echo    "<div class=\"clearfix\">";
                    echo        "<button class=\"cancelbtn\" type=\"reset\">Cancel</button>";
                    echo        "<button class=\"createbtn\" type=\"submit\">Save</button>";
                    echo    "</div>";
                    echo "</form></div>";
                    
                }

                mysqli_close($connection);
            ?>
        </div>

        <!--Modal Post Submit-->
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
                    <input type="textarea" placeholder="Enter Description" name="description" minlength="20" required>
                    
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