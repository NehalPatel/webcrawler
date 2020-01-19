<?php

require_once dirname(__FILE__) . '/db/db_helper.php';

$page = $_REQUEST['page'] ? $_REQUEST['page'] : 1;
$offset = ($page - 1) * 10;
$limit = 10;

$select_sql = "select id, hash, url, title, page_title, SUBSTRING(`data`, 1, 300) as data FROM tbl_webdata LIMIT $offset, $limit";

// echo $select_sql;exit;

$result = mysqli_query($conn, $select_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gujarati News Search Engine</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/freelancer.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Gujarati Search Engine</a>
            <button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="clearfix"></div>
    <section class="bg-primary text-white" style="margin-top: 50px; padding:6rem 0 2rem">

        <div class="container">

            <form action="#" class="form" method="post">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" id="s" name="s" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="search_button" class="btn btn-default">શોધ કરો</button>
                    </div>
                </div>
            </form>
        </div>

    </section>

    <section id="search_result">
        <div class="container">

            <div id="record-container">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>

                    <div id="<?php echo $row['hash'] ?>" class="record"><a href="<?php echo $row['url'] ?>" target="_blank"><?php echo $row['page_title'] ?></a>
                        <p class="description"><?php echo $row['data'] ?></p>
                    </div>

                <?php endwhile; ?>

            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="pagination">
                        <?php for($i=1; $i<=10; $i++): ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : '' ?>"><a class="page-link" href="search.php?page=<?php echo $i?>" ><?php echo $i?></a></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>Copyright &copy; Gujarati Web search engine <?php echo date("Y"); ?></small>
        </div>
    </div>
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
        <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>