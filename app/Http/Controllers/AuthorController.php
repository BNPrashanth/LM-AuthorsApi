<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Author;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of Authors
     * @return Illuminate/Http/Response
     */
    public function index()
    {
        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * Create a new Author
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'country' => 'required',
        ];
        $this->validate($request, $rules);
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Return an existing Author
     * @return Illuminate/Http/Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);

        return $this->successResponse($author);
    }

    /**
     * Update an existing Author
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'gender' => 'in:male,female'
        ];
        $this->validate($request, $rules);
        $author = Author::findOrFail($author);
        $author->fill($request->all());

        if ($author->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();
        return $this->successResponse($author);
    }

    /**
     * Remove an existing Author
     * @return Illuminate/Http/Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);
        $author->delete();

        return $this->successResponse($author);
    }

}
