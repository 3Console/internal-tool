<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WordRequest;
use App\Http\Services\WordService;
use App\Http\Services\ImageService;
use App\Models\Word;

class WordController extends Controller
{
    protected $wordService, $imageService;

    public function __construct(WordService $wordService, ImageService $imageService)
    {
        $this->wordService = $wordService;
        $this->imageService = $imageService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function increasePriority(Request $request) {
        return $this->wordService->increasePriority($request->ids);
    }

    public function decreasePriority(Request $request) {
        return $this->wordService->decreasePriority($request->ids);
    }

    public function getAllPhrases(Request $request) {
        return $this->wordService->getAllPhrases($request->user()->id);
    }

    public function getRandomWord() {
        return $this->wordService->getRandomWord();
    }

    public function changeImportant($wordId) {
        $word = Word::findOrFail($wordId);
        return $this->wordService->changeImportant($word);
    }

    public function updateImage($wordId, Request $request) {
        if($request->hasFile('file')) {
            $word = Word::findOrFail($wordId);
            $imageUrl = $this->imageService->storeImageToFolder($request, 'images');
            return $this->wordService->updateImage($word, $imageUrl);
        }
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
    public function store(WordRequest $request)
    {
        return $this->wordService->storeWord($request);
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return $this->wordService->updateWord(Word::find($id), $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Word $word)
    {
        return $this->wordService->deleteOneWord($word);
    }
}
