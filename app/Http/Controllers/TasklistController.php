<?php

namespace App\Http\Controllers;

use App\Tasklist;
use Illuminate\Http\Request;

class TasklistController extends Controller
{

    protected $tasklist;

    public function __construct(Tasklist $tasklist)
    {
        $this->tasklist = $tasklist;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->tasklist->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasklist       = new Tasklist();
        $tasklist->name = $request->name;
        return $tasklist->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Tasklist::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tasklist = Tasklist::find($id);
        
        if ($tasklist)
        {
            $tasklist->name = $request->name;
            return $tasklist->save();
        }

        return response(false, 404);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = Tasklist::find($id);
        
        if ($tasklist)
        {
            return $tasklist->remove();
        }

        return response(false, 404);
    }
}
