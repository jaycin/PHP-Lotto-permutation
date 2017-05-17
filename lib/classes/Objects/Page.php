<?php
/**
 * Created by PhpStorm.
 * User: Jaycin
 * Date: 2016/10/23
 * Time: 3:14 AM
 */
class Page extends BaseClass
{
    public $url;
    public $modules;
    public $hits;
    public $metaTag;
    public $body;
    public $name;
    public $Module;


    public function loadHeader($header)
    {

        //Populate scripts and css
        echo ('<head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
                <meta name="description" content="">
                <meta name="author" content="">
                <link rel="icon" href="../../favicon.ico">

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <title>Swazi Plastics</title>

                <!-- Bootstrap core CSS -->
                <link href="lib/css/bootstrap.css" rel="stylesheet">

                <!-- Custom styles for this template -->
                <link href="jumbotron.css" rel="stylesheet">
            </head>');
    }
    private function writeCarousel($images)
    {



    }
    private function writeNav($elements)
    {
        echo('<nav class="navbar navbar-inverse">
                        <a class="navbar-brand" href="?page=home">Swazi Plastic</a>
                        <ul class="nav navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="?page=home">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=contact">Contact</a>
                            </li>
                        </ul>
                    </nav>');
    }

    public function writeBody($data)
    {
        echo('<body>'.$this->writeNav($data).$this->writeCarousel($data).'
                    <div class="container">
                        <!-- Example row of columns -->
                        <div class="row">
                            <div class="col-md-4">
                                <h2>Heading</h2>
                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
                            </div>
                            <div class="col-md-4">
                                <h2>Heading</h2>
                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
                            </div>
                            <div class="col-md-4">
                                <h2>Heading</h2>
                                <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
                            </div>
                        </div>

                        <hr>
                        '.$this->writeFooter().'

                    </div>
                    </body>');
    }
    public function writeFooter()
    {

    }
}


?>