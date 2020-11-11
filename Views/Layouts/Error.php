<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error!</title>
    <link rel="stylesheet" href="/public/assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">PHP Aplication</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/home">Home </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/posts">Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/acount">Acount</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <main role="main" class="container">

        <div class="starter-template">

            <?php
            echo $content_for_layout;
            ?>
            <img src="/public/images/Luffy_Wax.png" alt="" srcset="">
        </div>

    </main>
    <script src="/public/assets/bootstrap/Jquery/jquery-3.2.1.slim.min.js" ></script>
    <script src="/public/assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>