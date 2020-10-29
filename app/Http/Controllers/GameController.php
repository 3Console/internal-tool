<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GameService;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService) {
        $this->gameService = $gameService;
    }
    public function getGame3Resource(Request $request) {
        $userId = $request->user()->id;
        return $this->gameService->getGame3Resource($request->get('ids'), $userId);
    }
    public function getGame2Resource(Request $request) {
        $userId = $request->user()->id;
        return $this->gameService->getGame2Resource($request->get('ids'), $userId);
    }

    public function getGame1Resource(Request $request) {
        $userId = $request->user()->id;
        return $this->gameService->getGame1Resource($request->get('ids'), $userId);
    }
}
