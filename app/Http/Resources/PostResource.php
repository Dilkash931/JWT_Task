<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    private $functionName;

    public function __construct($resource, $functionName = null)
    {
        parent::__construct($resource);
        $this->functionName = $functionName;
    }

    public function toArray($request)
    {
        if ($this->functionName == 'index') {
            if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                return [
                    'response' => [
                        'message' => 'Posts retrieved successfully.',
                        'status' => 200,
                        'data' => $this->resource->items(), // Get items from paginator
                        'pagination' => [
                            'current_page' => $this->resource->currentPage(),
                            'per_page' => $this->resource->perPage(),
                            'total' => $this->resource->total(),
                        ]
                    ]
                ];
            }

            return [
                'response' => [
                    'message' => 'Post retrieved successfully.',
                    'status' => 200,
                    'data' => [
                        'id' => $this->id,
                        'name' => $this->Name,
                        'description' => $this->Description,
                        'status' => $this->Status,
                        'image_url' => $this->Image ? asset('storage/' . $this->Image) : null,
                        'created_at' => $this->created_at->toDateTimeString(),
                        'updated_at' => $this->updated_at->toDateTimeString(),
                    ],
                ]
            ];
        }

        if ($this->functionName == 'store') {
            return [
                'response' => [
                    'message' => 'Post created successfully',
                    'status' => 201,
                    'data' => [
                        'id' => $this->id,
                        'name' => $this->Name,
                        'description' => $this->Description,
                        'status' => $this->Status,
                        'image_url' => $this->Image ? asset('storage/' . $this->Image) : null,
                        'created_at' => $this->created_at->toDateTimeString(),
                        'updated_at' => $this->updated_at->toDateTimeString(),
                    ],
                ]
            ];
        }

        if ($this->functionName === 'show') {
            if ($this->resource === null) {
                return [
                    'response' => [
                        'message' => 'No post found.',
                        'status' => 404,
                    ]
                ];
            }
            
            return [
                'response' => [
                    'message' => 'Post details fetched successfully',
                    'status' => 200,
                    'data' => [
                        'id' => $this->id,
                        'name' => $this->Name,
                        'description' => $this->Description,
                        'status' => $this->Status,
                        'image_url' => $this->Image ? asset('storage/' . $this->Image) : null,
                    ],
                ]
            ];
        }

        if ($this->functionName === 'update') {
            if ($this->resource === null) {
                return [
                    'response' => [
                        'message' => 'Post not found.',
                        'status' => 404,
                    ]
                ];
            }

            return [
                'response' => [
                    'message' => 'Post updated successfully',
                    'status' => 200,
                    'data' => [
                        'id' => $this->id,
                        'name' => $this->Name,
                        'description' => $this->Description,
                        'status' => $this->Status,
                        'image_url' => $this->Image ? asset('storage/' . $this->Image) : null,
                    ],
                ]
            ];
        }

     if ($this->functionName == 'destroy') {
            return [
                'response' => [
                    'message' => 'Post deleted successfully',
                    'status' => 200,
                ]
            ];
        }
    }
}