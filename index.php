<?php
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;

$log = new Logger('Ass1Logg');
$log->pushHandler(new StreamHandler('viewLogger.log', Logger::INFO));
$name = $_GET['name'];
//$log->info($name);

$client = new \GuzzleHttp\Client();

$res = $client->request('GET', 'http://unicorns.idioti.se/' . $_GET['id'], [
                         'headers' => [
                         'Accept'     => 'application/json' ] ]);
	
		


$data = json_decode($res->getBody(), true);
?>


<!doctype html>
<html>
    <head>
        <title>Unicorns</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="background.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    
    <body>
		<div class="container">
		<h1>Enhörningar</h1>
		<hr>
		<h4>Id på en noshörning</h4>
		<form action="index.php" method="get">
			<div class="form-group">                  
                    <input type="id" id="id" name="id" class="form-control">
            </div>
            <div class="form-group">
                    <input type="submit" value="Visa enhörning" class="btn btn-success">
                    <a href="index.php" class="btn btn-primary">Visa alla enhörningar</a>
			</div>
			<hr>
				<p>
                    <?php
                    
                    if (isset($_GET['id']) && $_GET['id'] != NULL)
                    {
						 
						$res = $client->request('GET', 'http://unicorns.idioti.se/' . $_GET['id'], [
                        'headers' => [
                        'Accept'     => 'application/json' ] ]);
                         
						$data = json_decode($res->getBody(), true);
						$log->info("Requested info about: " . $data['name']);
						$image = file_get_contents('http://unicorns.idioti.se/' . $_GET['id']);
						echo $image;
					}
                    else
                    {
                    ?>
                    </p>
                    <h3>Alla enhörningar</h3>
                    <hr>
                    <p>
					<?php
						for ($i=0; $i < count($data) - 5; $i++) 
						{
							echo "<h5>" . ($data[$i]['id']) . ": " . ($data[$i]['name']) .
                                 "<a href='index.php?id=".$data[$i]['id'].
                                 "' class='btn btn-default' style='float:right;'>" . 
                                 "Mer Information" . "</a>" .
							     "</h5>" . 
								 "<hr>";
								 
								  
						}
						$log->info("Requested info about all unicorns");
					}
					?>
					</p>
                    
            </div>
        </form>
       </div>
    </body>

</html>

