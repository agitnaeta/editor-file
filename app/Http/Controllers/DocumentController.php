<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::paginate(10);
        return view('document.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('document.create');
    }


    /**
     * Contoh membuat halaman dengan banyak CKEDITOR
     */
    public function createMultiple()
    {
        // array ini bisa dari mana saja

        // Contoh angka
        # $editors = [1,2,3,4,5];
        $editors = ["editor1","editor2","editor3"];

        // nanti editor di looping di view
        // bagusnya semua di definisikan di controller
        $data =[
            'editors'=>$editors
        ];

        // buka create-multiple.blade.php
        return view('document.create-multiple',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $document = new Document;
        $document->title = $request->title;
        $document->content = $request->content;
        $document->save();

        return redirect()->route('document.index');
    }


    public function storeMultiple(Request $request){
        $titles = $request->title;
        for($i = 0 ; $i < count($titles) ; $i++){
            $document = new Document;
            $document->title = $titles[$i];
            $document->content = $request->content[$i];
            $document->save();
        }
        return redirect()->route('document.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::find($id);
        return view('document.show', compact('document'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $document = Document::find($id);
        return $document;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('document.edit', compact('id'));
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
        $document = Document::find($id);
        $document->title = $request->title;
        $document->content = $request->content;
        $document->save();

        return redirect()->route('document.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Document::destroy($id);
        return redirect()->route('document.index');
    }
}
