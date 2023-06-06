<?php

namespace App\Http\Controllers;

use App\Models\ManagerModel;
use Illuminate\Http\Request;


class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $modelmanager;

    public function __construct()
    {
        $this->modelmanager = new ManagerModel();
    }

    public function index()
    {
        return view('manager.index');
    }


    public function getData()
    {
        $softwareRequests = $this->modelmanager->get_data_permintaan();

        return response()->json($softwareRequests);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
