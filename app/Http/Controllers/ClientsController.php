<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientsController extends Controller
{

    public function index()
    {
        $logged_user_id = auth()->user()->id;
        $clients = Client::where('user_id', $logged_user_id)->paginate(20);
        return view('clients.show_clients_by_user', ['clients' => $clients]);
    }


    public function DeleteManyClientsConfirm(Request $request) {

        $id_array = $request->input('client_ids');
        $logged_user_id = auth()->user()->id;
        $keys = array_keys($id_array);
        $keys = array_unique($keys);
        $clients = DB::table('clients')
                    ->join('users', 'clients.user_id', '=', 'users.id')
                    ->select('clients.*')
                    ->where('users.id', $logged_user_id)
                    ->whereIn('clients.id', $keys)
                    ->get();

        return view('clients.delete_many_clients_confirm', ['clients' => $clients]);
    }


    public function DeleteClientsPost(Request $request) {
        $logged_user_id = auth()->user()->id;

        if (is_null($request->input('client_ids'))) {
            return redirect('/clients/list');
        }

        $client_ids = array_keys($request->input('client_ids'));

        $client = DB::table('clients')
                    ->join('users', 'clients.user_id', '=', 'users.id')
                    ->select('clients.id')
                    ->where('users.id', $logged_user_id)
                    ->whereIn('clients.id', $client_ids)
                    ->get();

        if ($client->count() == count($request->input('client_ids'))) {
            //Blowdata::whereIn('client_id', $client_ids)->delete();
            client::whereIn('id', $client_ids)->delete();
            return redirect()->route('clients.clientsList')->withError('Record/s deleted');
        } else {
            return redirect('/clients/list');
        }
    }



    public function addClient()
    {
        $client = new \stdClass();
        $client->id = -1;
        $client->client_name = '';
        $client->client_nip = '';
        $client->client_address = '';
        $data = Array('client' => $client, 'action' => '/clients/add');
        return view('clients.edit_client_by_user', $data);
    }



    public function addClientPost(Request $request)
    {

        $request->validate([
          'client_name' => "required|min:3|max:50",
          'client_address' => 'max:50',
          'client_nip' => 'max:50',
        ]);

        $client = new Client;
        $client->user_id = auth()->user()->id;
        $client->client_name = $request->input('client_name');
        $client->client_address = $request->input('client_address');
        $client->client_nip = $request->input('client_nip');
        $client->save();

        return redirect()->route('clients.clientsList')->withSuccess('Record added');
    }


    
    public function editClient($id)
    {
        if (!is_numeric($id)) {
            return redirect('/clients/list');
        }

        $logged_user_id = auth()->user()->id;
        $client = Client::where('id',$id)->where('user_id', $logged_user_id)->get()->first();
        if (is_null($client)) {
            return redirect('/clients/list');
        }

        $data = Array('client' => $client, 'action' => '/clients/edit');
        return view('clients.edit_client_by_user', $data);
    }



    public function editClientPost(Request $request)
    {
        $logged_user_id = auth()->user()->id;
        $client_id = $request->input('client_id');

        $client = Client::where('id', $client_id)->where('user_id', $logged_user_id)->get()->first();
        if (is_null($client)) {
            return redirect('/clients/list');
        }

        $request->validate([
          'client_name' => "required|min:3|max:50",
          'client_address' => 'max:50',
          'client_nip' => 'max:50',
        ]);


        $data = Array(
            'client_name'    => $request->input('client_name'),
            'client_address' => $request->input('client_address'),
            'client_nip'     => $request->input('client_nip'),
        );

        Client::where('id', $client_id)->where('user_id', $logged_user_id)->update($data);

        return redirect()->route('clients.clientsList')->withSuccess('Record updated');
        
    }

}
