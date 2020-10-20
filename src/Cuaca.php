<?php 

namespace Ezadev\Bmkg;

/**
 * Ambil data cuaca dari Website BMKG
 * Sumber data dari BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)
 * @author Khairu Aqsara Sudirman <https://khairu-aqsara.net>
 * @license http://creativecommons.org/publicdomain/mark/1.0/ Public Domain
 * @return json
 */


use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class Cuaca extends Daerah
{

    /**
     * @xml
     */
    public $xml;
    /**
     * @json
     */
    public $json;
    

    /**
     * @string
     */
    private $daerah;
    /**
     * @string
     */
    private $url = "https://data.bmkg.go.id/datamkg/MEWS/DigitalForecast/DigitalForecast-";

    /**
     * GuzzleHttp\Client
     */
    private $client;


    /**
     * @param string $daerah
     */
    public function __construct($daerah)
    {
        $this->daerah = $daerah;

        if($this->validate()){
            $this->client = New Client([
                'timeout'=> 30.0,
                'verify'=>false
            ]);
        }
    }

    /**
     * Validate Nama Daerah
     * @return boolean
     */
    protected function validate()
    {
        if(!array_key_exists($this->slugify($this->daerah), $this->_daerah)){
            throw new \Exception('Daerah Tidak ditemukan');
        }else{
            return true;
        }
    }

    /**
     * Get Promise Request ke situs BMKG
     * Kemudian Format Hasilnya
     * @return void
     */
    public function get()
    {
        $build_request = urldecode($this->url.$this->_daerah[$this->slugify($this->daerah)].".xml");
        $promises = [
            'res'=>$this->client->getAsync($build_request)
        ];

        $this->xml = Promise\unwrap($promises);
        $this->parseResponse();
        return $this;
    }

    /**
     * Parse Respon, dari situs BMKG
     * @return void
     */
    public function parseResponse()
    {
        //print_r($this->xml['res']->getHeaders());
        //die();
        if(isset($this->xml['res'])){
            if($this->xml['res']->getHeaders()["Content-Length"][0] > 0){
                $body = $this->xml['res']->getBody();
                $this->json = json_decode(json_encode(simplexml_load_string($body)), TRUE);
                $this->formatJson();
            }else{
                throw new \Exception('Request Failed');
            }
        }else{
            throw new \Exception('Unable to read the respon from promise');
        }
    }

    /**
     * Custom Formating untuk JSON
     * Note: Ini disesuaiakan dengan kebutuhan, silahkan parsing sendiri
     * jika merasa memebutuhkan bentuk data yang sesuai dengan kemauan masing-masing
     * @return array
     */
    protected function formatJson()
    {   
        $new_data = [];
        $new_data['metadata'] = $this->json['forecast']['issue'];
        if(isset($this->json['forecast']['area'])){
            foreach($this->json['forecast']['area'] as $area){
                if(isset($area['parameter'])){
                    if(sizeof($area['parameter']) > 0){
                        foreach($area['parameter'] as $data){
                            if(isset($data['timerange'])){
                                if(sizeof($data['timerange']) > 0){
                                    foreach($data['timerange'] as $timerange){
                                        $except = ["Max temperature","Max humidity","Min temperature","Min humidity","Max temperature"];
                                        if(!in_array($data['@attributes']['description'], $except)){
                                            $new_data['cuaca'][$area['name'][1]][$data['@attributes']['description']][] = [
                                                'jam'=>intval($timerange['@attributes']['h']),
                                                'value'=> ($data['@attributes']['description'] == "Weather") 
                                                    ? $this->kode_cuaca[$timerange['value']]
                                                    : $timerange['value']
                                            ] ;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->json = $new_data;
    }

    /**
     * Set Header Kedalam Bentuk JSON
     * @return void
     */
    protected function wantJson()
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
    }

    /**
     * Return respon data dalam bentuk json
     * @return json
     */
    public function json()
    {
        $this->wantJson();
        echo json_encode($this->json);
    }

    /**
     * Return respon data daerah yang tersedia dalam bentuk json
     * @return json
     */
    public function getAvailableDaerah()
    {
        $this->wantJson();
        echo json_encode($this->_daerah);
    }

    /**
     * Return respon data kode cuaca dalam bentuk json
     * Kode cuaca diambil dari default website BMKG
     * @return json
     */
    public function getAvailableKodeCuaca()
    {
        $this->wantJson();
        echo json_encode($this->kode_cuaca);
    }
}