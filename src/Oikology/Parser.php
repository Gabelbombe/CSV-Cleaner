<?php

Namespace Oikology
{
    Class Parser
    {
        public      $file       = [];
        protected   $mods       = [];

        private     $_err       = [],
                    $_map       = [
                                    '33' => '!', '34' => '"', '35' => '#', '36' => '$', '37' => '%', '38' => '&', '39' => "'", '40' => '(', '41' => ')', '42' => '*',
                                    '43' => '+', '44' => ',', '45' => '-', '46' => '.', '47' => '/', '48' => '0', '49' => '1', '50' => '2', '51' => '3', '52' => '4',
                                    '53' => '5', '54' => '6', '55' => '7', '56' => '8', '57' => '9', '58' => ':', '59' => ';', '60' => '<', '61' => '=', '62' => '>',
                                    '63' => '?', '64' => '@', '65' => 'A', '66' => 'B', '67' => 'C', '68' => 'D', '69' => 'E', '70' => 'F', '71' => 'G', '72' => 'H',
                                    '73' => 'I', '74' => 'J', '75' => 'K', '76' => 'L', '77' => 'M', '78' => 'N', '79' => 'O', '80' => 'P', '81' => 'Q', '82' => 'R',
                                    '83' => 'S', '84' => 'T', '85' => 'U', '86' => 'V', '87' => 'W', '88' => 'X', '89' => 'Y', '90' => 'Z', '91' => '[', '92' => '\\',
                                    '93' => ']', '94' => '^', '95' => '_', '96' => '`', '97' => 'a', '98' => 'b', '99' => 'c', '100'=> 'd', '101'=> 'e', '102'=> 'f',
                                    '103'=> 'g', '104'=> 'h', '105'=> 'i', '106'=> 'j', '107'=> 'k', '108'=> 'l', '109'=> 'm', '110'=> 'n', '111'=> 'o', '112'=> 'p',
                                    '113'=> 'q', '114'=> 'r', '115'=> 's', '116'=> 't', '117'=> 'u', '118'=> 'v', '119'=> 'w', '120'=> 'x', '121'=> 'y', '122'=> 'z',
                                    '123'=> '{', '124'=> '|', '125'=> '}', '126'=> '~', '127'=> ' ', '128'=> '&#8364;', '129'=> ' ', '130'=> ',', '131'=> ' ', '132'=> '"',
                                    '133'=> '.', '134'=> ' ', '135'=> ' ', '136'=> '^', '137'=> ' ', '138'=> ' ', '139'=> '<', '140'=> ' ', '141'=> ' ', '142'=> ' ',
                                    '143'=> ' ', '144'=> ' ', '145'=> "'", '146'=> "'", '147'=> '"', '148'=> '"', '149'=> '.', '150'=> '-', '151'=> '-', '152'=> '~',
                                    '153'=> ' ', '154'=> ' ', '155'=> '>', '156'=> ' ', '157'=> ' ', '158'=> ' ', '159'=> ' ', '160'=> ' ', '161'=> '¡', '162'=> '¢',
                                    '163'=> '£', '164'=> '¤', '165'=> '¥', '166'=> '¦', '167'=> '§', '168'=> '¨', '169'=> '©', '170'=> 'ª', '171'=> '«', '172'=> '¬',
                                    '173'=> '­', '174'=> '®', '175'=> '¯', '176'=> '°', '177'=> '±', '178'=> '²', '179'=> '³', '180'=> '´', '181'=> 'µ', '182'=> '¶',
                                    '183'=> '·', '184'=> '¸', '185'=> '¹', '186'=> 'º', '187'=> '»', '188'=> '¼', '189'=> '½', '190'=> '¾', '191'=> '¿', '192'=> 'À',
                                    '193'=> 'Á', '194'=> 'Â', '195'=> 'Ã', '196'=> 'Ä', '197'=> 'Å', '198'=> 'Æ', '199'=> 'Ç', '200'=> 'È', '201'=> 'É', '202'=> 'Ê',
                                    '203'=> 'Ë', '204'=> 'Ì', '205'=> 'Í', '206'=> 'Î', '207'=> 'Ï', '208'=> 'Ð', '209'=> 'Ñ', '210'=> 'Ò', '211'=> 'Ó', '212'=> 'Ô',
                                    '213'=> 'Õ', '214'=> 'Ö', '215'=> '×', '216'=> 'Ø', '217'=> 'Ù', '218'=> 'Ú', '219'=> 'Û', '220'=> 'Ü', '221'=> 'Ý', '222'=> 'Þ',
                                    '223'=> 'ß', '224'=> 'à', '225'=> 'á', '226'=> 'â', '227'=> 'ã', '228'=> 'ä', '229'=> 'å', '230'=> 'æ', '231'=> 'ç', '232'=> 'è',
                                    '233'=> 'é', '234'=> 'ê', '235'=> 'ë', '236'=> 'ì', '237'=> 'í', '238'=> 'î', '239'=> 'ï', '240'=> 'ð', '241'=> 'ñ', '242'=> 'ò',
                                    '243'=> 'ó', '244'=> 'ô', '245'=> 'õ', '246'=> 'ö', '247'=> '÷', '248'=> 'ø', '249'=> 'ù', '250'=> 'ú', '251'=> 'û', '252'=> 'ü',
                                    '253'=> 'ý', '254'=> 'þ', '255'=> 'ÿ',
                                ];

        public function __construct()
        {
            $this->file = (object) [
                'base' => pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME),
                'save' => $_FILES['file']['tmp_name'],
                'name' => $_FILES["file"]["name"],
            ];

            $this->host = array_pop(filter_input_array(INPUT_POST, [
                'hhost' => [
                    'filter' => FILTER_SANITIZE_ENCODED
                ]
            ]));

            if (empty($this->host)) Throw New \LogicException('Cross site forgery detected, terminating...');
        }

        public static function emit()
        {
            $csv  = New Self(); // fake the static
            $data = [];

            foreach(array_map('str_getcsv', file($csv->file->save)) AS $inc => $sub)
            {
                $inc++;
                foreach($sub AS $row => $value)
                {
                    $data[$inc][] =
                    $sample       = str_replace(["\n", "\r", '\n', '\r'], '', $csv->strip($value));

                    if (md5($sample) !== md5($value))
                    {
                        $csv->mods['Line: '. $inc]['Row: ' . ++$row] = $value;
                    }
                }
            }

            $csv->post((object) [
                'host' => $csv->host,
                'data' => $csv->respond($data),
            ]);
        }

        protected function strip($string)
        {
            $search  = // lazy
            $replace = [];

            foreach ($this->_map AS $s => $r)
            {
                $search[]  = chr((int) $s);
                $replace[] = $r;
            }

            return str_replace($search, $replace, trim($string));
        }

        protected function respond($data)
        {
            if ($buffer = fopen("/tmp/{$this->file->base}-filter.csv", 'w'))
            {
                foreach($data AS $val) fputcsv($buffer, $val);
                fclose($buffer);

                // could do it anywhere, but why not here =P
                return (object) [
                    'name' => "/tmp/{$this->file->base}-filter.csv",
                    'errs' => json_encode($this->_err),
                    'mods' => base64_encode(serialize($this->mods)),
                ];
            }

            return [ 'errs' => 'Boolean return for fopen(), permission denied...' ];
        }

        private function post($object)
        {
            header("Location: /?" . $this->urlify($object->data));
            exit;
        }

        protected function objToArr($object)
        {
            if (is_object($object)) settype($object, 'array');
            if (is_array($object))  return array_map(__METHOD__, $object);

            return $object;
        }
        private function urlify($object)
        {
            return http_build_query($this->objtoArr($object), '', '&');
        }

    }
}