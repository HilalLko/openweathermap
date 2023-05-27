<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $token;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $token)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request,$token="")
    {
        $udata = [];
        $send = [];
        $udata['user_id'] = $this->id;
        $udata['name'] = $this->name;
        $udata['email'] = $this->email;
        if ($this->token != '') {
            $udata['auth_token'] = $this->token;
        }
        $send['user_data'] = $udata;
        return $send;
    }
}
