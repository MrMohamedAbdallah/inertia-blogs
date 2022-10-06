<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class BlogResource extends JsonResource
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
            'title' => $this->title,
            'body' => strip_tags($this->body),
            'bodyHTML' => Purifier::clean($this->body),
            'cover' => $this->when($this->cover, function () {
                return str_starts_with($this->cover, 'https') ? $this->cover : Storage::url($this->cover);
            }),
            'can' => [
                'edit' => auth()->check() && $this->user->id == $this->user_id,
                'delete' => auth()->check() && $this->user->id == $this->user_id
            ],
            'user' => $this->whenLoaded('user', new UserResource($this->user)),
        ];
    }
}
