<?php

namespace App\Http\Resources;

use App\Models\Game_User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'total_kills' => $this->total_kills,
            'deaths' => $this->deaths,
            'games_played' => $this->games_played,
            'roles' => new RoleCollection($this->whenLoaded('roles')),
            'game_user' => new GameUserResource($this->whenPivotLoaded('game_user', function () {
                return $this->pivot;
            }))
            //'game_user' => $this->relationLoaded('players') ? new GameUserResource($this->pivot) : null,
        ];
    }
}
