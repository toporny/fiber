<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blowing;
use App\Models\Blowdata;
use App\Models\Client;

class BlowingsController extends Controller
{
    public function index() 
    {
        return view('home.index');
    }


    public function showBlowingsByUser() 
    {
        $logged_user_id = auth()->user()->id;
        $blowings = Blowing::where('user_id', $logged_user_id)->paginate(20);
        return view('auth.show_blowings_by_user', ['blowings' => $blowings]);
    }


    public function showBlowingByUser($blowing_id) {
        $logged_user_id = auth()->user()->id;

        $blowing = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.*')
                    ->where('users.id', $logged_user_id)
                    ->where('blowings.id', '=', $blowing_id)
                    ->get()->first();

        return view('blowings.show_blowings_by_user', compact('blowing'));
    }


    public function makePdfBlowingByUser($blowing_id) {
        $logged_user_id = auth()->user()->id;

        // $blowing = DB::table('blowings')
        //             ->join('users', 'blowings.user_id', '=', 'users.id')
        //             ->select('blowings.*')
        //             ->where('users.id', $logged_user_id)
        //             ->where('blowings.id', '=', $blowing_id)
        //             ->get()->first();

        print "make pdf";
        //return view('blowings.show_blowings_by_user', compact('blowing'));
    }


    public function editBlowingByUser($blowing_id)
    {
        $logged_user_id = auth()->user()->id;

        $blowing = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.*')
                    ->where('users.id', $logged_user_id)
                    ->where('blowings.id', '=', $blowing_id)
                    ->get()->first();

        return view('blowings.edit_blowings_by_user', compact('blowing'));
    }



    public function editBlowingByUserPost(Request $request)
    {
        $logged_user_id = auth()->user()->id;
        $blowing_id = $request->input('blowing_id');

        $affectedRows = Blowing::where("user_id", $logged_user_id)
        ->where("id", $blowing_id)
        ->update([
            "client_name" => $request->input('client_name'),
            "client_address" => $request->input('client_address'),
            "client_nip" => $request->input('client_nip'),
            "route_name" => $request->input('route_name'),
            "route_start" => $request->input('route_start'),
            "route_end" => $request->input('route_end'),
            "route_gps_cords_x" => $request->input('route_gps_cords_x'),
            "route_gps_cords_y" => $request->input('route_gps_cords_y'),
            "operator" => $request->input('operator'),
            "place_location" => $request->input('place_location'),
            "pipe_manufacturer" => $request->input('pipe_manufacturer'),
            "pipe_type" => $request->input('pipe_type'),
            "pipe_symbol_color" => $request->input('pipe_symbol_color'),
            "pipe_outer_diameter" => $request->input('pipe_outer_diameter'),
            "pipe_thickness" => $request->input('pipe_thickness'),
            "pipe_notes" => $request->input('pipe_notes'),
            "cable_manufacturer" => $request->input('cable_manufacturer'),
            "cable_how_many_fibers" => $request->input('cable_how_many_fibers'),
            "cable_diameter" => $request->input('cable_diameter'),
            "cable_symbol_color" => $request->input('cable_symbol_color'),
            "cable_crash_test" => $request->input('cable_crash_test'),
            "cable_marker_start" => $request->input('cable_marker_start'),
            "cable_marker_end" => $request->input('cable_marker_end'),
            "blower_lubricant" => $request->input('blower_lubricant'),
            "blower_compressor" => $request->input('blower_compressor'),
            "blower_compressor_pressure" => $request->input('blower_compressor_pressure'),
            "blower_compressor_efficiency" => $request->input('blower_compressor_efficiency'),
            "temperature" => $request->input('temperature'),
            "language" => $request->input('language'),
        ])
        ;

        $blowing = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.*')
                    ->where('users.id', $logged_user_id)
                    ->where('blowings.id', '=', $blowing_id)
                    ->get()->first();

        return back()->with('success', 'Data successfully changed!');
    }


    public function ShowBlowingSource($blowing_id) {
        $logged_user_id = auth()->user()->id;

        // być może to polecenie trzeba będzie w przyszłości zoptymalizować w taki sposób
        // żeby nie było tutaj dwóch joinów tylko żeby brał z płaskiej tabeli
        // (czyli trzeba sobie wcześniej sprawdzić czy dp danego usera należy ten blowing
        // i czy tym samym ma prawo go czytać

        $source_data = DB::table('blowdatas')
                    ->join('blowings', 'blowdatas.blowing_id', '=', 'blowings.id')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowdatas.*')
                    ->where('users.id', $logged_user_id)
                    ->where('blowings.id', '=', $blowing_id)
                    ->get();


        // $logged_user_id = auth()->user()->id;
        // $source_data = Blowing::where('user_id', $logged_user_id)
        // ->where('id', $blowing_id);

        //return view('auth.show_blowings_by_user', ['blowings' => $blowings]);

        $source_data_divided1 = $source_data->splice(0, round($source_data->count()/2));
        $source_data_divided2 = $source_data;


        return view('blowings.show_blowing_source',
            [
                'source_data1' => $source_data_divided1,
                'source_data2' => $source_data_divided2
            ]
        );
    }



    public function editBlowingsByAdmin($user_id, $blowing_id) {
        print "edit Blowings By Admin";
    }

    public function showBlowingsByAdmin($user_id)  // nie dokończone !!
    {
        print "show blowings by user_id = ".$user_id;
        exit;
    }

    public function DeleteBlowing($blowing_id) 
    {
        // czy ten blowing należy na pewno do tego usera
        $logged_user_id = auth()->user()->id;

        $blowing = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.*')
                    ->where('users.id', $logged_user_id)
                    ->where('blowings.id', '=', $blowing_id)
                    ->get();

        if ($blowing->count() == 1) {
            return view('blowings.delete_blowing_by_user', ['blowing' => $blowing[0]]);
        } else {
            return redirect('/blowings/list');
        }
    }



    public function DeleteBlowingPost(Request $request) {
        $logged_user_id = auth()->user()->id;

        if (is_null($request->input('blowing_ids'))) {
            return redirect('/blowings/list');
        }

        $blowing_ids = array_keys($request->input('blowing_ids'));

        $blowing = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.id')
                    ->where('users.id', $logged_user_id)
                    ->whereIn('blowings.id', $blowing_ids)
                    ->get();

        if ($blowing->count() == count($request->input('blowing_ids'))) {
            Blowdata::whereIn('blowing_id', $blowing_ids)->delete();
            Blowing::whereIn('id', $blowing_ids)->delete();
            return redirect()->route('blowings.blowingsList')->withError('Record/s deleted');
        } else {
            return redirect('/blowings/list');
        }
    }

    

    public function DeleteManyBlowingsConfirm(Request $request) {

        if (is_null($request->input('blowing_ids'))) {
            return redirect('/blowings/list');
        }

        $id_array = $request->input('blowing_ids');
        $logged_user_id = auth()->user()->id;
        $keys = array_keys($id_array);
        $keys = array_unique($keys);

        $blowings = DB::table('blowings')
                    ->join('users', 'blowings.user_id', '=', 'users.id')
                    ->select('blowings.*')
                    ->where('users.id', $logged_user_id)
                    ->whereIn('blowings.id', $keys)
                    ->get();

        return view('blowings.delete_many_blowings_confirm', ['blowings' => $blowings]);
    }


    private function DecodeBinaryTableFile($binary_content) {

        $a_return = Array (
            'date_time_from_file' => "",
            'client_name_from_file' => "",
            'contractor' => "",
            'route_name' => "",
            'cable_section' => "",
            'operator' => "",
            'place_location' => "",
            'pipe_notes' => "",
            'pipe_manufacturer' => "",
            'pipe_type' => "",
            'pipe_symbol_color' => "",
            'pipe_outer_diameter' => "",
            'pipe_thickness' => "",
            'cable_notes' => "",
            'cable_manufacturer' => "",
            'cable_symbol_color' => "",
            'cable_how_many_fibers' => "",
            'cable_diameter' => "",
            'cable_crash_test' => "",
            'blower_lubricant' => "",
            'blower_compressor' => "",
            'blower_compressor_pressure' => "",
            'blower_compressor_efficiency' => "",
            'separator' => "",
            'radiator' => "",
            'temperature' => "",
        );
        $aa =  mb_convert_encoding($binary_content, 'ASCII', 'UTF-16LE');

        $i = Array(
            'date_time_from_file' =>   Array(16, 17),  //  0000000
            'client_name_from_file' =>       Array(36, 50),   //  aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            'contractor' =>           Array(90, 50),   //  bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
            'route_name' =>   Array(144,30),   //  cccccccccccccccccccccccccccccc
            'cable_section' =>             Array(178,30),   //  dddddddddddddddddddddddddddddd
            'operator' =>            Array(210,30),   //  eeeeeeeeeeeeeeeeeeeeeeeeeeeeee
            'place_location' =>         Array(244,30),   //  ffffffffffffffffffffffffffffff
            'pipe_notes' =>          Array(278,50),   //  gggggggggggggggggggggggggggggggggggggggggggggggggg
            'pipe_manufacturer' =>      Array(332,30),   //  hhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
            'pipe_type' =>            Array(366,30),   //  iiiiiiiiiiiiiiiiiiiiiiiiiiiiii
            'pipe_symbol_color' =>    Array(400,30),   //  jjjjjjjjjjjjjjjjjjjjjjjjjjjjjj
            'pipe_outer_diameter' => Array(434,30),   //  kkkkkkkkkkkkkkkkkkkkkkkkkkkkkk
            'pipe_thickness' =>     Array(468,30),   //  llllllllllllllllllllllllllllll
            'cable_notes' =>         Array(502,50),   //  mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm
            'cable_manufacturer' =>     Array(556,30),   //  nnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
            'cable_symbol_color' =>          Array(590,30),   //  oooooooooooooooooooooooooooooo
            'cable_how_many_fibers' =>       Array(624,30),   //  pppppppppppppppppppppppppppppp
            'cable_diameter' =>            Array(658,30),   //  qqqqqqqqqqqqqqqqqqqqqqqqqqqqqq
            'cable_crash_test' =>          Array(692,4),    //  xxxx
            'blower_lubricant' =>     Array(720,50),   //  rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
            'blower_compressor' =>           Array(774,50),   //  ssssssssssssssssssssssssssssssssssssssssssssssssss
            'blower_compressor_pressure' =>           Array(828,30),   //  tttttttttttttttttttttttttttttt
            'blower_compressor_efficiency' =>             Array(862,30),   //  uuuuuuuuuuuuuuuuuuuuuuuuuuuuuu
            'separator' =>           Array(896,4),    //  vvvv
            'radiator' =>           Array(904,4),    //  wwww
            'temperature' =>         Array(908,4),    //  yyyy
        );

        $tmp = mb_substr($aa, $i['date_time_from_file'][0], $i['date_time_from_file'][1]);
        $tmp = str_replace(chr(9),' ', $tmp);
        $tmp = '20'.str_replace('/','-', $tmp);

        $a_return['date_time_from_file'] = $tmp;
        $a_return['client_name_from_file'] = trim(mb_substr($aa,       $i['client_name_from_file'][0],      $i['client_name_from_file'][1]));
        $a_return['contractor'] = trim(mb_substr($aa,           $i['contractor'][0],          $i['contractor'][1]));
        $a_return['route_name'] = trim(mb_substr($aa,   $i['route_name'][0],  $i['route_name'][1]));
        $a_return['cable_section'] = trim(mb_substr($aa,             $i['cable_section'][0],            $i['cable_section'][1]));
        $a_return['operator'] = trim(mb_substr($aa,            $i['operator'][0],           $i['operator'][1]));
        $a_return['place_location'] = trim(mb_substr($aa,         $i['place_location'][0],        $i['place_location'][1]));
        $a_return['pipe_notes'] = trim(mb_substr($aa,          $i['pipe_notes'][0],         $i['pipe_notes'][1]));
        $a_return['pipe_manufacturer'] = trim(mb_substr($aa,      $i['pipe_manufacturer'][0],     $i['pipe_manufacturer'][1]));
        $a_return['pipe_type'] = trim(mb_substr($aa,            $i['pipe_type'][0],           $i['pipe_type'][1]));
        $a_return['pipe_symbol_color'] = trim(mb_substr($aa,    $i['pipe_symbol_color'][0],   $i['pipe_symbol_color'][1]));
        $a_return['pipe_outer_diameter'] = trim(mb_substr($aa, $i['pipe_outer_diameter'][0],$i['pipe_outer_diameter'][1]));
        $a_return['pipe_thickness'] = trim(mb_substr($aa,     $i['pipe_thickness'][0],    $i['pipe_thickness'][1]));
        $a_return['cable_notes'] = trim(mb_substr($aa,         $i['cable_notes'][0],        $i['cable_notes'][1]));
        $a_return['cable_manufacturer'] = trim(mb_substr($aa,     $i['cable_manufacturer'][0],    $i['cable_manufacturer'][1]));
        $a_return['cable_symbol_color'] = trim(mb_substr($aa,          $i['cable_symbol_color'][0],         $i['cable_symbol_color'][1]));
        $a_return['cable_how_many_fibers'] = trim(mb_substr($aa,       $i['cable_how_many_fibers'][0],      $i['cable_how_many_fibers'][1]));
        $a_return['cable_diameter'] = trim(mb_substr($aa,            $i['cable_diameter'][0],           $i['cable_diameter'][1]));
        $a_return['cable_crash_test'] = trim(mb_substr($aa,          $i['cable_crash_test'][0],         $i['cable_crash_test'][1]));
        $a_return['blower_lubricant'] = trim(mb_substr($aa,     $i['blower_lubricant'][0],    $i['blower_lubricant'][1]));
        $a_return['blower_compressor'] = trim(mb_substr($aa,           $i['blower_compressor'][0],          $i['blower_compressor'][1]));
        $a_return['blower_compressor_pressure'] = trim(mb_substr($aa,           $i['blower_compressor_pressure'][0],          $i['blower_compressor_pressure'][1]));
        $a_return['blower_compressor_efficiency'] = trim(mb_substr($aa,             $i['blower_compressor_efficiency'][0],            $i['blower_compressor_efficiency'][1]));
        $a_return['separator'] = trim(mb_substr($aa,           $i['separator'][0],          $i['separator'][1]));
        $a_return['radiator'] = trim(mb_substr($aa,           $i['radiator'][0],          $i['radiator'][1]));
        $a_return['temperature'] = trim(mb_substr($aa,         $i['temperature'][0],        $i['temperature'][1]));
        return $a_return;
    }

    private function DecodeBinaryGpsFile($binary_content) {
        $a_return = Array (
            'latitude' => "",
            'longitude' => "",
        );
        $binary_content =  mb_convert_encoding($binary_content, 'ASCII', 'UTF-16LE');
        $line = explode("\n", $binary_content)[1];
        $i = Array(
            'latitude' =>   Array(18, 5),
            'longitude' =>  Array(26, 5),
        );
        $a_return['latitude']  = trim(mb_substr($line, $i['latitude'] [0], $i['latitude'] [1]));
        $a_return['longitude'] = trim(mb_substr($line, $i['longitude'][0], $i['longitude'][1]));
        //print_r($a_return);
        return $a_return;
   }



    public function uploadForm(Request $request) {

        $client = new \stdClass();

        $data = session()->get('data');

        $client->client_name    = (isset($data['client_name']))    ? $data['client_name']    : "";
        $client->client_nip     = (isset($data['client_nip']))     ? $data['client_nip']     : "";
        $client->client_address = (isset($data['client_address'])) ? $data['client_address'] : "";

        $logged_user_id = auth()->user()->id;

        $clients_list = DB::table('clients')
                    ->select('clients.*')
                    ->where('user_id', $logged_user_id)
                    ->get();

        $data = Array(
            'client' => $client,
            'clients_list' => $clients_list,
        );

        return view('blowings.upload_form', $data);
    }



    private function only_three_files_allowed($files) {
        $gps = false;
        $parameters = false;
        $table = false;
        foreach ($files as $file) {
            $filename = strtolower($file->getClientOriginalName());
            // poniżej taka dziwna kombinacja ponieważ czasami te pliki są w postaci 
            // "gps (1).txt", "parameters (1).txt", "table (1).bin"
            if ( (substr($filename, 0, 3) == 'gps') && ((substr($filename,-4)) == '.txt') ) $gps = true;
            if ( (substr($filename, 0, 10) == 'parameters') && ((substr($filename,-4)) == '.txt') ) $parameters = true;
            if ( (substr($filename, 0, 5) == 'table') && ((substr($filename,-4)) == '.bin') ) $table = true;
        }
        return ($gps && $parameters && $table);
    }



    public function DecodeParametersFile ($parameters_content) {
        $parameters_content =  mb_convert_encoding($parameters_content, 'ASCII', 'UTF-16LE');
        $all_samples = explode("\n", trim($parameters_content));
        // print_r($all_samples);
        // exit;
        $a_return = Array();
        // zaczynam od 1 zamiast od zera by pominąć pierwszy wiersz nagłówkowy
        for ($i=1; $i<count($all_samples); $i++) {
            $e = explode("\t", trim($all_samples[$i]));
            $a_return[$i]['datetime'] = '20'.substr($e[0], 0, 2).'-'.substr($e[0], 3, 2).'-'.substr($e[0],-2). ' '.$e[1];
            $a_return[$i]['speed'] = $e[2];
            $a_return[$i]['force'] = $e[3];
            $a_return[$i]['pressure'] = $e[4];
            $a_return[$i]['length'] = $e[5];
            $a_return[$i]['trip_id'] = $e[6];
        }
        return $a_return;
   }



   private function calculate_time_difference_in_minutes($start_date, $end_date) {

        $start_date = new \DateTime($start_date);
        $interval = $start_date->diff(new \DateTime($end_date));
        $intervalInSeconds = (new \DateTime())->setTimeStamp(0)->add($interval)->getTimeStamp();
        $intervalInMinutes = $intervalInSeconds/60; // and so on
        return round($intervalInMinutes,2);
   }


    public function uploadSubmit1(Request $request)
    {
        $request->validate([
          'client_name' => "required|min:3|max:50",
          'client_address' => 'max:50',
          'client_nip' => 'max:50',
        ]);


        if ($request->input('add_record_to_database') == 'on') {
            $client = Client::where('user_id', auth()->user()->id)
            ->where('client_name', $request->input('client_name'))
            ->where('client_address', $request->input('client_address'))
            ->where('client_nip', $request->input('client_nip'))
            ->get();

            // jeśli już jest taki klient w bazie to nie dodawaj
            if ($client->isEmpty()) {
                $client = new Client;
                $client->user_id = auth()->user()->id;
                $client->client_name = $request->input('client_name');
                $client->client_address = $request->input('client_address');
                $client->client_nip = $request->input('client_nip');
                $client->save();
            }
        }


        if ($request->hasFile('files'))
        {
            $allowedfileExtension = ['txt', 'bin', 'bmp'];
            $files = $request->file('files');

            if ( (count($files) < 3) || (count($files) > 4) ) {
                return back()->with('error', count($files). ' files uploaded but only 3 files required: "gps.txt", "parameters.txt", "table.bin".')->with(['data' => $data]);
            };

            if (!$this->only_three_files_allowed($files)) {
                return back()->with('error', '3 files required: "gps.txt", "parameters.txt", "table.bin".'); // ->with(['data' => $data])
            }

            $gps_file = null;
            $parameters_file = null;
            $table_file = null;

            foreach ($files as $file)
            {
                $filename = $file->getClientOriginalName();
                if (substr(strtolower($filename), 0, 3) == 'gps') $gps_file = $file->getRealPath();
                if (substr(strtolower($filename), 0, 10) == 'parameters') $parameters_file = $file->getRealPath();
                if (substr(strtolower($filename), 0, 5) == 'table') $table_file = $file->getRealPath();
            }

            $table_content = file_get_contents($table_file);
            $gps_content = file_get_contents($gps_file);
            $parameters_content = file_get_contents($parameters_file);

            $table_decoded = $this->DecodeBinaryTableFile($table_content);
            $gps_decoded = $this->DecodeBinaryGpsFile($gps_content);
            $parameters_decoded = $this->DecodeParametersFile($parameters_content);

			//$blowing = new \stdClass();
            $blowing = new Blowing();

            $blowing->user_id = auth()->user()->id;
            $blowing->date_time_from_file = $table_decoded['date_time_from_file'];
            $blowing->client_name_from_file =  $table_decoded['client_name_from_file'];
            $blowing->numbers_of_samples_from_file =  count($parameters_decoded);

            // $blowing->client_name_from_file = 'werwer';
			$blowing->client_name = $request->input('client_name');
			$blowing->client_nip = $request->input('client_nip');
			$blowing->client_address = $request->input('client_address');
			$blowing->language = 'pl';
			$blowing->route_name = $table_decoded['route_name'];

            $start_date = substr($parameters_decoded[1]['datetime'], 0, 19);
            $end_date = substr($parameters_decoded[count($parameters_decoded)]['datetime'], 0, 19);
			$blowing->installation_time_start = $start_date;
			$blowing->installation_time_end = $end_date;
            $install_time = $this->calculate_time_difference_in_minutes($start_date, $end_date);
            $blowing->installation_time_in_minutes = $install_time;
            $blowing->route_gps_cords_x = $gps_decoded['latitude'];
            $blowing->route_gps_cords_y = $gps_decoded['longitude'];

			$blowing->operator = $table_decoded['operator'];
			$blowing->place_location = $table_decoded['place_location'];
			$blowing->pipe_manufacturer = $table_decoded['pipe_manufacturer'];
			$blowing->pipe_type = $table_decoded['pipe_type'];
			$blowing->pipe_symbol_color = $table_decoded['pipe_symbol_color'];
			$blowing->pipe_outer_diameter = $table_decoded['pipe_outer_diameter'];
			$blowing->pipe_thickness = $table_decoded['pipe_thickness'];
            $blowing->pipe_notes = $table_decoded['pipe_notes'];
			$blowing->cable_manufacturer = $table_decoded['cable_manufacturer'];
			$blowing->cable_how_many_fibers = $table_decoded['cable_how_many_fibers'];
			$blowing->cable_symbol_color = $table_decoded['cable_symbol_color'];
			$blowing->cable_manufacturer =  $table_decoded['cable_manufacturer'];
			$blowing->cable_how_many_fibers =  $table_decoded['cable_how_many_fibers'];
			$blowing->cable_diameter = $table_decoded['cable_diameter'];
            $blowing->cable_crash_test = $table_decoded['cable_crash_test'];
			$blowing->blower_lubricant = $table_decoded['blower_lubricant'];
			$blowing->blower_compressor = $table_decoded['blower_compressor'];
			$blowing->blower_compressor_pressure = $table_decoded['blower_compressor_pressure'];
			$blowing->blower_compressor_efficiency = $table_decoded['blower_compressor_efficiency'];
            $blowing->blower_separator = 0;
            $blowing->blower_radiator = 0;
            $blowing->temperature = $table_decoded['temperature'];
            $blowing->cable_length = '6666'.' - (wyliczone!!)';
            $blowing->draft = 1;
            $blowing->save();


            foreach ($parameters_decoded as &$item) {
                $item['blowing_id'] = $blowing->id;
            }

            $parameters_decoded2 = array_chunk($parameters_decoded, 100);
            
            foreach ($parameters_decoded2 as $max_100_elements) {
                Blowdata::insert($max_100_elements); // Eloquent approach
            }

            // $blowing2 = DB::table('blowings')
            //             ->join('users', 'blowings.user_id', '=', 'users.id')
            //             ->select('blowings.*')
            //             ->where('users.id', auth()->user()->id)
            //             ->where('blowings.id', '=', $blowing->id)
            //             ->get()->first();


 #           $blowing->id
#            return redirect()->route('profile', ['id' => 1]);

            //$data = Array('blowing' => $blowing2);
            //         Route::post('/blowings/add_step1', 'BlowingsController@uploadSubmit1')->name('blowings.uploadSubmit1');

            return redirect()->route('blowings.editBlowing', ['id' => $blowing->id]);

        } else {
            return back()->withErrors(["files[]" => "Please attach at 3 blowing files."]);
        }
    }

    public function uploadSubmit2(Request $request)
    {
        
        $request->validate([
            'client_name' => "required|min:3|max:50",
            'client_address' => 'max:50',
            'client_nip' => 'max:50',
            'route_name' => 'max:50',
            'operator' => 'max:50',
            'route_start' => 'max:50',
            'route_end' => 'max:50',
// 'route_gps_cords_x'            => 'max:50|numeric|min:0|not_in:0',
// 'route_gps_cords_y'            => 'max:50|numeric|min:0|not_in:0',
            'pipe_manufacturer'            => 'max:50',
            'pipe_type'                    => 'max:50',
            'pipe_symbol_color'            => 'max:50',
            'pipe_outer_diameter'          => 'max:10|numeric|min:0|not_in:0',
            'pipe_thickness'               => 'max:10|numeric|min:0|not_in:0',
            'pipe_notes'                   => 'max:50',
            'cable_manufacturer'           => 'max:50',
'cable_how_many_fibers'        => 'max:1|integer|min:1|max:999',
            'cable_symbol_color'           => 'max:50',
            'cable_diameter'               => 'max:50|numeric|min:0|not_in:0',
            'cable_crash_test'             => 'max:50',
            'cable_marker_start'           => 'present|nullable|integer|min:0|max:999',
            'cable_marker_end'             => 'present|nullable|integer|min:0|max:999',
            'blower_lubricant'             => 'max:50',
            'blower_compressor'            => 'max:50',
            'blower_compressor_pressure'   => 'max:50',
            'blower_compressor_efficiency' => 'max:50',
            'temperature'                  => 'numeric|min:-40|max:70',
        ]);

        $logged_user_id = auth()->user()->id;
        $blowing_id = $request->input('blowing_id');

        $affectedRows = Blowing::where("user_id", $logged_user_id)
        ->where("id", $blowing_id)
        ->update([
            "client_name" => $request->input('client_name'),
            "client_address" => $request->input('client_address'),
            "client_nip" => $request->input('client_nip'),
            "route_name" => $request->input('route_name'),
            "route_start" => $request->input('route_start'),
            "route_end" => $request->input('route_end'),
            "route_gps_cords_x" => $request->input('route_gps_cords_x'),
            "route_gps_cords_y" => $request->input('route_gps_cords_y'),
            "operator" => $request->input('operator'),
            "place_location" => $request->input('place_location'),
            "pipe_manufacturer" => $request->input('pipe_manufacturer'),
            "pipe_type" => $request->input('pipe_type'),
            "pipe_symbol_color" => $request->input('pipe_symbol_color'),
            "pipe_outer_diameter" => $request->input('pipe_outer_diameter'),
            "pipe_thickness" => $request->input('pipe_thickness'),
            "pipe_notes" => $request->input('pipe_notes'),
            "cable_manufacturer" => $request->input('cable_manufacturer'),
            "cable_how_many_fibers" => $request->input('cable_how_many_fibers'),
            "cable_diameter" => $request->input('cable_diameter'),
            "cable_symbol_color" => $request->input('cable_symbol_color'),
            "cable_crash_test" => $request->input('cable_crash_test'),
            "cable_marker_start" => $request->input('cable_marker_start'),
            "cable_marker_end" => $request->input('cable_marker_end'),
            "blower_lubricant" => $request->input('blower_lubricant'),
            "blower_compressor" => $request->input('blower_compressor'),
            "blower_compressor_pressure" => $request->input('blower_compressor_pressure'),
            "blower_compressor_efficiency" => $request->input('blower_compressor_efficiency'),
            "temperature" => $request->input('temperature'),
            "language" => $request->input('language'),
            "draft" => 0,
        ]);

        return redirect('/blowings/list');
        //return view('blowings.edit_blowings_by_user', compact('blowing'));

    }




}

