<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{

    public function __construct(
        public $resource,
        private bool $isPagination = false,
        private bool $success = true,
        private string $message = 'Successfully fetched data!') {

        if (empty($resource)) {
            $resource = (object) ['data' => null];
        }
        else {
            if (gettype($resource) !== "object") {
                $resource = (object) $resource;
            }

            if (!$isPagination && !isset($resource->data)) {
                $resource = (object) ['data' => $resource];
            }
        }

        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ];

        if ($this->isPagination) {
            $response['meta'] = [
                "path" => $this->path,
                "per_page" => $this->per_page,
                "next_cursor" => $this->next_cursor,
                "next_page_url" => $this->next_page_url,
                "prev_cursor" => $this->prev_cursor,
                "prev_page_url" => $this->prev_page_url,
            ];
        }

        return $response;
    }
}
