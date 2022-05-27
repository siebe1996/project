<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameUserResource;
use App\Models\Game;
use App\Models\Game_User;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GameUserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        return response(['data' => $id], 200)
            ->header('Content-Type', 'application/json');
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
        if($request->filled('gameId')){
            $gameId = $request->gameId;
            Gate::authorize('store-gameuser', $gameId);
            $userId = Auth::id();
            $game = Game::where('id', $gameId)->first();
            if($game->start_date > Carbon::now()){
                $game->users()->attach($userId);
                return response(['data' => $game], 201)
                    ->header('Content-Type', 'application/json');
            }
            return response(['data' => 'u cant join game that is started'], 451)
                ->header('Content-Type', 'application/json');
        }
        return response(['data' => 'bad request'], 400)
            ->header('Content-Type', 'application/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $gameId
     * @return \Illuminate\Http\Response
     */
    public function show($gameId) //toDo dit moet via Request $request
    {
        $userId = Auth::id();
        $weaponId = Game::where('id', $gameId)->pluck('weapon_id');
        $gameUser = Game::where('id', $gameId)
            ->whereHas('users', function ($q) use ($userId){
            $q->where('users.id', $userId);
        })->with(['usersWithPivot'=> function ($query) use ($userId) {
                $query->where('users.id', $userId);
            }])->with(['weapon'=> function ($query) use ($weaponId) {
                $query->where('id', $weaponId);
            }])->first();

        $targetId = $gameUser->usersWithPivot->first()->pivot->target_id;
        $targetName = User::where('id', $targetId)->pluck('first_name');
        $data = new GameResource($gameUser);
        //todo: why doesn't this work with players
        $data->usersWithPivot->first()->pivot->target_name = $targetName;
        //$gameUser->usersWithpivot->first()->pivot->target_id = 5;
        /*$gameUser->usersWithpivot->first()->target_id = null;
        $gameUser->first();*/

        return response(['data' => $data], 200)
            ->header('Content-Type', 'application/json');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getGamesForUser()
    {
        $userId = Auth::id();
        $games = new GameCollection(Game::
            whereHas('users', function ($q) use ($userId){
                $q->where('users.id', $userId);
            })->with(['usersWithPivot'=> function ($query) use ($userId) {
                $query->where('users.id', $userId);
            }])->get());
        return response(['data' => $games], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display target of current game.
     *
     * @return \Illuminate\Http\Response
     */
    public function target(Request $request){
        if($request->filled('targetId')){
            $targetId = $request->targetId;
            $userId = Auth::id();
            $targetName = User::where('id', $targetId)->pluck('first_name');

            //$targetId = $gameUser->users_with_pivot;//->players->game_user->target_id;

            return response(['data' => $targetName], 200)
                ->header('Content-Type', 'application/json');
        }
        return response(['data' => 'bad request'], 400)
            ->header('Content-Type', 'application/json');
    }
}
