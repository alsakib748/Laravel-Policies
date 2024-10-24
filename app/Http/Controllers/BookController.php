<?php

namespace App\Http\Controllers;

use Carbon;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $books = Book::where('user_id',\Auth::id())->orderBy('id','desc')->get();

        $books = Book::orderBy('id','desc')->get();

        return view('book.book_all',compact('books'));
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
    public function show($id)
    {

        // $book = Book::findOrFail($id)->user_id;
        // dd($book);
        $book = Book::findOrFail($id);

        Gate::authorize('view',$book ); //todo: If this condition satisfy then execute the next line otherwise show 403 error code

        return view('book.book_view',compact('book'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        // $book = Book::where('id', $id)->first();

        $book = Book::findOrFail($id);

        Gate::authorize('edit',$book ); //todo: If this condition satisfy then execute the next line otherwise show 403 error code

        return view('book.book_edit',compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $book = Book::findOrFail($id);

        // dd($id);

        //todo: one way to check the user is authorized or not
        if($request->user()->cannot('update',$book)){

            abort(403, "You are not authorized.");

        }

        // Gate::authorize('update',$book); //todo: If this condition satisfy then execute the next line otherwise show 403 error code

        Book::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => Auth::guard('web')->user()->id,
            'updated_at' => Carbon\Carbon::now()
        ]);

        return redirect()->route('book.all');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $book = Book::findOrFail($id);

        Gate::authorize('delete',$book); //todo: If this condition satisfy then execute the next line otherwise show 403 error code

        Book::findOrFail($id)->delete();

        return redirect()->route('book.all');

    }
}
