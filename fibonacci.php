<?php

	require_once 'vendor/autoload.php';

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use Slim\Views\Twig as View;

	// Configuración de cabeceras para CORS
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	header("Allow: GET, POST, OPTIONS, PUT, DELETE");
	$method = $_SERVER['REQUEST_METHOD'];
	if($method == "OPTIONS") {
	    die();
	}


	$c = new \Slim\Container([
		'settings' => [
			'displayErrorDetails' => true
		]
	]); //Create Your container

	//Override the default Not Found Handler
	$c['notFoundHandler'] = function ($c) {
	    return function ($request, $response) use ($c) {
	        return $c['response']
	            ->withStatus(400)
	            ->withHeader('Content-Type', 'text/html')
	            ->write('Bad Request');
	    };
	};

	$app = new \Slim\App($c);


	$app->get('/loadFibonacci/{numero}', function (Request $request, Response $response, array $args) {
		$numero = $args['numero'];

		if(!is_numeric($numero)) {
			$respuesta = [
				'data' => '',
				'response' => 'El parámetro debe ser numérico',
				'code' => '400'
			];

			return $response->withJson($respuesta, 400);
		}

		$fibonacci = array(0,1);
		$resultado = array();

		try {
			for($i=2; $i<=$numero; $i++) {
				$fibonacci[] = $fibonacci[$i-1] + $fibonacci[$i-2];
			}

			$respuesta = [
				'data' => $fibonacci[$numero-1],
				'response' => 'Ok',
				'code' => '200'
			];
		} catch(Exception $e) {
			$respuesta = [
				'data' => '',
				'response' => 'Ocurrió un error inesperado',
				'code' => '400'
			];
	
			return $response->withJson($respuesta, 400);
		}

		return $response->withJson($respuesta, 200);
	});


	$app->run();
