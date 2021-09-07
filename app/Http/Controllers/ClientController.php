<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienSavetRequest;
use App\Models\Client;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view("clients.index", compact("clients"));
    }

    /**
     * Muestra el formulario de creación del cliente.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $documentTypes = DocumentType::all();
        return view("clients.form", compact("documentTypes"));
    }

    /**
     * Guarda un nuevo cliente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienSavetRequest $request)
    {
        //

        $client = new Client();
        $client->fill($request->all());
        $client->save();
        return redirect(route("client.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($clientId)
    {
        //
        $documentTypes = DocumentType::all();
        $client = Client::find($clientId);
        return view("clients.form", compact("client", "documentTypes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //

        $client = Client::find($request->id);
        $client->fill($request->all());
        $client->save();
        return redirect(route("client.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($clientId)
    {
        //

        $client = Client::find($clientId);
        $client->delete();
        return redirect(route("client.index"));
    }
}
