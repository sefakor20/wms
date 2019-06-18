<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>

	<title>Login - Online Medical Store</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-3" style="margin-top: 80px;">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><center>Online Medical Store</center></h4>
                                <p class="category" style="text-align: center;">provide the required credentials to login</p>
                            </div>
                            <div class="content">
                                <form method="POST" action="Submits/login.php">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Username</label>
                                                <input type="text" class="form-control" placeholder="Enter Your Username" name="username" required>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        if (isset($_SESSION['error'])) {
                                            ?>
                                            <span style="color: red;"><?php echo $_SESSION['error']; ?></span>
                                            <?php
                                        } 
                                        $_SESSION['error'] = null;
                                    ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Enter Your Password" name="password" required>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-fill pull-right" name="submit">Login</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

</body>

</html>
