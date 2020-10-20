<?php 

namespace Ezadev\Bmkg;

class Daerah {
    public $_daerah = [
        "aceh"=>"Aceh",
        "bali"=>"Bali",
        "bangka_belitung"=>"BangkaBelitung",
        "banten"=>"Banten",
        "bengkulu"=>"Bengkulu",
        "di_yogyakarta"=>"DIYogyakarta",
        "dki_jakarta"=>"DKIJakarta",
        "gorontalo"=>"Gorontalo",
        "jambi"=>"Jambi",
        "jawa_barat"=>"JawaBarat",
        "jawa_tengah"=>"JawaTengah",
        "jawa_timur"=>"JawaTimur",
        "kalimantan_barat"=>"KalimantanBarat",
        "kalimantan_selatan"=>"KalimantanSelatan",
        "kalimantan_tengah"=>"KalimantanTengah",
        "kalimantan_timur"=>"KalimantanTimur",
        "kalimantan_utara"=>"KalimantanUtara",
        "kepulauan_riau"=>"KepulauanRiau",
        "lampung"=>"Lampung",
        "maluku"=>"Maluku",
        "maluku_utara"=>"MalukuUtara",
        "ntb"=>"NusaTenggaraBarat",
        "ntt"=>"NusaTenggaraTimur",
        "papua"=>"Papua",
        "papua_barat"=>"PapuaBarat",
        "riau"=>"Riau",
        "sulawesi_barat"=>"SulawesiBarat",
        "sulawesi_selatan"=>"SulawesiSelatan",
        "sulawesi_tengah"=>"SulawesiTengah",
        "sulawesi_tenggara"=>"SulawesiTenggara",
        "sulawesi_utara"=>"SulawesiUtara",
        "sulawesi_barat"=>"SumateraBarat",
        "sumatera_selatan"=>"SumateraSelatan",
        "sumatra_utara"=>"SumateraUtara",
        "indonesia"=>"Indonesia"
    ];

    public $kode_cuaca = [
        "0"=>'Cerah',
        "100"=>'cerah',
        "1"=>"Cerah Berawan",
        "101"=>"Cerah Berawan",
        "2"=>"Cerah Berawan",
        "102"=>"Cerah Berawan",
        "3"=>"Berawan",
        "103"=>"Cerah Berawan",
        "4"=>"Berawan Tebal",
        "104"=>"Cerah Berawan",
        "5"=>"Udara Kabur",
        "10"=>"Asap",
        "45"=>"Kabut",
        "60"=>"Hujan Ringan",
        "61"=>"Hujan Sedang",
        "63"=>"Hujan Lebat",
        "80"=>"Hujan Lokal",
        "95"=>"Hujan Petir",
        "97"=>"Hujan Petir"
        
    ];

    function slugify($string){
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $string), '_'));
    }
}