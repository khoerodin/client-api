<?php

namespace App\Http\Controllers\Api\V1;

use App\API\ApiHelper;
use App\Book;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    use ApiHelper;

    /**
     * @var Repository
     */
    protected $model;

    /**
     * BooksController constructor.
     *
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->model = new Repository($book);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->latest()->paginate();
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
        // run the validation
        $this->beforeCreate($request);

        return $request->user()->books()->create(
            $request->only($this->model->getModel()->fillable)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
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
        $this->beforeUpdate($request);

        if (!$this->model->update($request->only($this->model->getModel()->fillable), $id)) {
            return $this->errorBadRequest('Unable to update.');
        }

        return $this->model->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->model->delete($id) ? $this->noContent() : $this->errorBadRequest();
    }
}
