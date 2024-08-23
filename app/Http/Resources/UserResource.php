<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $functionName;

    public function __construct($resource, $functionName = null)
    {
        parent::__construct($resource);
        $this->functionName = $functionName;
    }

    public function toArray($request)
    {
        switch ($this->functionName) {
            case 'sendResetLinkEmail':
                return [
                    'response' => [
                        'message' => $this->resource['status'] == 200 ? 'Reset link sent successfully' : 'Unable to send reset link',
                        'status' => $this->resource['status'],
                    ]
                ];

            case 'resetPassword':
                return [
                    'response' => [
                        'message' => $this->resource['status'] == 200 ? 'Password reset successfully' : 'Password reset failed',
                        'status' => $this->resource['status'],
                    ]
                ];
            }

        if ($this->functionName == 'register') {
            return [
                'response' => [
                    'message' => 'You successfully registered.',
                    'status' => 201,
                    'data' => [
                        'id' => $this->resource->id,
                        'name' => $this->resource->name,
                        'email' => $this->resource->email,
                        'phone' => $this->resource->Phone,
                        'status' => $this->resource->Status,
                        'created_at' => $this->resource->created_at->toDateTimeString(),
                        'updated_at' => $this->resource->updated_at->toDateTimeString(),
                    ],
                ]
            ];
        }
        if ($this->functionName == 'login') {
            // Handling successful login
            if (isset($this->resource['token'])) {
                return [
                    'response' => [
                        'message' => 'You successfully logged in.',
                        'status' => 200,
                        'token' => $this->resource['token'],
                    ]
                ];
            }
            // Handling failed login
            return [
                'response' => [
                    'message' => 'Email or password is not correct.',
                    'status' => 401
                ]
            ];
        }
    
        if ($this->functionName == 'me') {
            return [
                'response' => [
                    'message' => 'User details retrieved successfully.',
                    'status' => 200,
                    'data' => [
                        'id' => $this->resource->id,
                        'name' => $this->resource->name,
                        'email' => $this->resource->email,
                        'phone' => $this->resource->Phone,
                        'status' => $this->resource->Status,
                        'created_at' => $this->resource->created_at->toDateTimeString(),
                        'updated_at' => $this->resource->updated_at->toDateTimeString(),
                    ],
                ]
            ];
        }

        if ($this->functionName == 'logout') {
            return [
                'response' => [
                    'message' => 'Successfully logged out.',
                    'status' => 200
                ]
            ];
        }
    }
}

