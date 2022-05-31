<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Http\Resources\UserCollection;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GameApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // haal alle games op - steek in resource die extra optionele parameter heeft userInGame
        // filter de actieve eruit
        // check voor de actieve of de user hier in zit
        // indien wel zet userInGame op true, anders false
        //$game->start_date > Carbon::now()

        $userId = Auth::id();
        /*$gamesInProgress = Game::where('start_date', '>', Carbon::now());
        $joinableGames = Game::where('start_date', '', Carbon::now())
            ->whereHas('users', function ($q) use ($userId){
                $q->whereNotIn('users.id', array($userId));
            })->get();*/
        /*
         * DIT WERKT
         * $activeGamesWithUser = new GameCollection(Game::where('active', true)
            ->whereHas('users', function ($q) use ($userId){
                $q->where('users.id', '=', $userId);
            })->get());
        foreach ($activeGamesWithUser as $activeGameWithUser){
            $activeGameWithUser->has_user = true;
        }
        $activeGamesIdsWithUser = $activeGamesWithUser->pluck('id');
        $games = new GameCollection(Game::whereNotIn('id', $activeGamesIdsWithUser)->get());
        $games = $games->merge($activeGamesWithUser);
        */
        /*
        $activeGamesWithUser = Game::where('active', true)
            ->whereHas('users', function ($q) use ($userId){
                $q->where('users.id', '=', $userId);
            })->get();
        foreach ($activeGamesWithUser as $activeGameWithUser){
            $activeGameWithUser->has_user = true;
        }
        $activeGamesIdsWithUser = $activeGamesWithUser->pluck('id');
        $games = Game::whereNotIn('id', $activeGamesIdsWithUser)->get();
        $games = $games->merge($activeGamesWithUser);*/

        ////JOINABLE GAMES CODE/////
        $notJoinable = new GameCollection(Game::where('start_date', '>', Carbon::now())
            ->whereHas('users', function ($q) use ($userId){
                $q->where('users.id', '=', $userId);
            })->get());

        $notJoinableIds = $notJoinable->pluck('id');
        $joinable = new GameCollection(Game::where('start_date', '>', Carbon::now())->whereNotIn('id', $notJoinableIds)->get());

        $startedGames = new GameCollection(Game::where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->get());
        $previousGames = new GameCollection(Game::where('end_date', '<', Carbon::now())->get());
        ////JOINABLE GAMES CODE/////


        return response(['data' => ['active' => ['active_joinable' => $joinable, 'active_not_joinable' => $notJoinable, 'started_games' => $startedGames], 'previous_games' => $previousGames]], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gate::authorize('show-game', $id);
        $game = Game::with('users')->findOrFail($id)->with('usersWithPivot')->findOrFail($id);
        $alivePlayers = $game->usersWithPivot->where('pivot.alive', 1);
        $winner = $alivePlayers->count() == 1 ? $alivePlayers->first()->first_name : null;
        /*$orderOnKill=$game->usersWithPivot->sortByDesc('pivot.when_killed');
        $mostKilled = array_slice($orderOnKill->usersWithPivot, '0', 5);*/
        $mostKilled = $game->usersWithPivot->sortByDesc('pivot.kills')->take(5);
        $mostKilled = new UserCollection($mostKilled);


        return response(['data' =>['game_data' => $game, 'alive_player' => $alivePlayers, 'winner' => $winner, 'most_killed' => $mostKilled]], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $gameId)
    {
        $request->validate([
            'gameId' => 'required'
        ]);/*
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());
        $tag = new TagResource($tag);*/

        $userId = Auth::id();
        $gameUser = Game::where('id', $gameId)->users()->attach($userId)->with('usersWithPivot')->get();
            /*->whereHas('users', function ($q) use ($userId){
                $q->where('users.id', $userId);
            })->with(['usersWithPivot'=> function ($query) use ($userId) {
                $query->where('users.id', $userId);
            }])->get();*/
        return response(['data' => $gameUser], 200)
            ->header('Content-Type', 'application/json');
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
     * Display all current games of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function current(){
        $userId = Auth::id();

        $activeGamesWithUser = new GameCollection(Game::where('active', true)
            ->whereHas('users', function ($q) use ($userId){
                $q->where('users.id', '=', $userId);
            })->get());

        return response(['data' => ['current_games' => $activeGamesWithUser]], 200)
            ->header('Content-Type', 'application/json');
    }
}
