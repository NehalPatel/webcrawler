<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gujarati News Web Crawler</title>
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
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Gujarati Web Crawler</a>
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
    <section class="bg-primary text-white" style="margin-top: 50px;">

        <div class="container">

            <form action="#" class="form" method="post">
                <div class="row">
                    <div class="col-md-2">
                        <label for="web_url">Web URL:</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" id="web_url" name="web_url" class="form-control" value="https://www.divyabhaskar.co.in/">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="call_link_builder" class="btn btn-default">Get URLs</button>
                    </div>
                </div>
            </form>
        </div>

    </section>

    <section id="search_result" style="display: none">
        <div class="container">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="offset">OFFSET :</label>
                        <input type="text" id="offset" name="offset" value="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="limit">LIMIT :</label>
                        <input type="text" id="limit" name="limit" value="2">
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="#" id="crawler_call" class="btn btn-primary pull-right">Start Crawling</a>
                </div>
            </div>


            <table class="table" id="table_result">
                <tr>
                    <th>Sr.No</th>
                    <th>URL</th>
                    <th>Last Visited</th>
                    <th>Status</th>
                </tr>
            </table>
        </div>
    </section>


    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>Copyright &copy; Gujarati Web Crawler 2018</small>
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


    <script>
        var urls;
        jQuery(document).ready(function($) {

            $("#call_link_builder").on('click', function(e) {

                link_builder($("#web_url").val());
                return false;

            });

            $("#crawler_call").on('click', function(e) {

                crawl_website();
                return false;

            });

        });

        function link_builder(url) {
            $("#call_link_builder").html('<i class="fa fa-spinner fa-spin">');
            //put link builder to work
            $.ajax({
                url: 'ajax_link_builder.php',
                type: 'post',
                dataType: 'json',
                data: {
                    'web_url': url
                },
                success: function(data) {
                    if (typeof data == "undefined") {
                        return false;
                    }

                    urls = data;

                    $("#search_result").show();
                    $.each(data, function(index, val) {
                        $("#table_result").append("<tr id='" + val['hash'] + "'><td>" + val['id'] + "</td><td>" + val['url'] + "</td><td class='last_visited'>" + val['last_visited'] + "</td><td class='status'>Pending</td></tr>");
                    });
                },
                complete: function() {
                    $("#call_link_builder").html('Get URLs');
                }
            });
        }

        function crawl_website() {
            $("#crawler_call").html('<i class="fa fa-spinner fa-spin">');
            //put link builder to work
            $.ajax({
                url: 'ajax_web_crawler.php',
                type: 'post',
                dataType: 'json',
                data: {
                    'offset': $("#offset").val(),
                    'limit': $("#limit").val()
                },
                success: function(data) {
                    if (typeof data == "undefined") {
                        return false;
                    }

                    $.each(data, function(index, val) {
                        $("#table_result #" + val['hash'] + " .last_visited").text(val['last_visited']);
                        $("#table_result #" + val['hash'] + " .status").text(val['status']);
                    });

                },
                complete: function() {
                    $("#crawler_call").html('Start Crawling');
                }
            });
        }
    </script>

</body>

</html>