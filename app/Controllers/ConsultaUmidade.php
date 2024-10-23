<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ConsultaUmidade extends BaseController
{
    protected $client;

    public function __construct()
    {
        $this->client = service('curlrequest');
        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    public function index()
    {
        return view('consultaUmidade');
    }

    public function verificaUmidade()
    {
        $umidade = $this->request->getPost('umidade');
        $lat = $this->request->getPost('lat');
        $lon = $this->request->getPost('long');

        $apiKey = '179929b7ffdec969a45a06c95705d2c4';

        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?{$lat}=35&{$lon}=139&appid={$apiKey}";
        
        try{
            $response = $this->client->request('GET', $apiUrl);
            $weatherData = json_decode($response->getBody());

            if(isset($weatherData['humidity'])){
                if($umidade < $weatherData['humidity']){
                    return $this->response->setJSON([
                        'message' => "ALERTA: A umidade atual é de: {$weatherData['humidity']}%, 
                                    sendo maior que o valor informado {$umidade}%"
                    ]);
                }else{
                    return $this->response->setJSON([
                        'message' => "A umidade atual {$weatherData['humidity']}% está dentro do 
                                    valor limite informado {$umidade}%"
                    ]);
                }
            }else{
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Não possível obter dados de umidade do OpenWeather'
                    ]);
            }
        }catch(Exception $e){
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }

    }
}
