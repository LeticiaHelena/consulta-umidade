<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ConsultaUmidade extends BaseController
{
    public function index()
    {
        return view('consultaUmidade');
    }

    public function verificaUmidade()
    {
        $client = service('curlrequest');

        $umidade = $this->request->getPost('umidade');
        $lat = $this->request->getPost('lat');
        $lon = $this->request->getPost('long');

        $apiKey = '179929b7ffdec969a45a06c95705d2c4';

        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}";

        try{
            $response = $client->request('GET', $apiUrl);
            $weatherData = json_decode($response->getBody());

            $humidity = $weatherData->main->humidity;

            if(isset($humidity)){
                if($umidade < $humidity){
                    return $this->response->setJSON([
                        'message' => "ALERTA: A umidade atual é de: {$humidity}%, 
                                    sendo maior que o valor informado {$umidade}%"
                    ]);
                }else{
                    return $this->response->setJSON([
                        'message' => "A umidade atual {$humidity}% está dentro do 
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
