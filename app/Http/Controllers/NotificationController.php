<?php

namespace App\Http\Controllers;

use App\Models\FriendShip;
use App\Models\Notification;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationController extends Controller
{
    use NotificationService;

    public function fetchNotifications(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $data = Notification::WHERE('to', $userId)->orderBy('created_at', 'DESC')->get();
        foreach ($data as $item) {
            $item->userNameFrom = $item->user->displayName;
        }
        return response()->json($data, 200);
    }

    public function sendNotifiToFriends(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        //get friendship of user
        $friendShips = FriendShip::WHERE('status', 1)
            ->WHERE('user_accept', $user->id)
            ->orWhere('user_request', $user->id)
            ->get();

        $deviceTokens = [];
        //pluck device token
        foreach ($friendShips as $friendShip) {
            if ($friendShip->user_request == $user->id) {
                $deviceTokens[] = User::find($friendShip->user_accept)->device_token;
            } else {
                $deviceTokens[] = User::find($friendShip->user_request)->device_token;
            }
        }
        //remove null value of device token
        $deviceTokens = array_filter($deviceTokens);
        //send notification
        $this->sendBatchNotification(
            $deviceTokens,
            [
                'topicName' => 'birthday',
                'title' => 'Chúc mứng sinh nhật',
                'body' => 'Chúc bạn sinh nhật vui vẻ',
                'image' => 'https://picsum.photos/536/354',
            ],
        );

        return response()->json([
            'message' => 'success',
        ], Response::HTTP_OK);
    }
}

trait NotificationService
{
    protected $apiKey = 'AAAAa2aSHMk:APA91bHOK2eHnWpBWl0atJ5PDGU2l95NaA9eVUR2KgsGwfN0h41Azq63xP9uCImWZtnpmBf7tJout110m_dKqa_ucl31T6DAKcyrGXVhdwqWN0-kyFXrnlakFZutyWqBzWrA96S4PWzF';
    /**
     * @param $deviceTokens
     * @param $data
     * @throws GuzzleException
     */
    public function sendBatchNotification($deviceTokens, $data = [])
    {
        $this->subscribeTopic($deviceTokens, $data['topicName']);
        $this->sendNotification($data, $data['topicName']);
        $this->unsubscribeTopic($deviceTokens, $data['topicName']);
    }

    /**
     * @param $data
     * @param $topicName
     * @throws GuzzleException
     */
    public function sendNotification($data, $topicName = null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $data = [
            'to' => '/topics/' . $topicName,
            'notification' => [
                'title' => $data['title'] ?? 'Something',
                'body' => $data['body'] ?? 'Something',
                'image' => $data['image'] ?? null,
            ],
            'data' => [
                'url' => $data['url'] ?? null,
                'redirect_to' => $data['redirect_to'] ?? null,
            ],
            // 'apns' => [
            //     'payload' => [
            //         'aps' => [
            //             'mutable-content' => 1,
            //         ],
            //     ],
            //     'fcm_options' => [
            //         'image' => $data['image'] ?? null,
            //     ],
            // ],
        ];

        $this->execute($url, $data);
    }

    /**
     * @throws GuzzleException
     */
    public function subscribeTopic(array $deviceTokens, $topicName = null)
    {
        $url = 'https://iid.googleapis.com/iid/v1:batchAdd';
        $data = [
            'to' => '/topics/' . $topicName,
            'registration_tokens' => $deviceTokens,
        ];

        $this->execute($url, $data);
    }

    /**
     * @throws GuzzleException
     */
    public function unsubscribeTopic($deviceTokens, $topicName = null)
    {
        $url = 'https://iid.googleapis.com/iid/v1:batchRemove';
        $data = [
            'to' => '/topics/' . $topicName,
            'registration_tokens' => $deviceTokens,
        ];

        $this->execute($url, $data);
    }

    /**
     * @return bool
     * @throws GuzzleException
     */
    private function execute(string $url, $requestData = [], string $method = 'POST')
    {
        $result = false;
        try {
            $client = new Client();
            $result = $client->request($method, $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => $requestData,
                'timeout' => 300,
            ]);

            $result = $result->getStatusCode() == Response::HTTP_OK;
        } catch (Exception $e) {
            //get body request
            dd($e->getMessage());
        }

        return $result;
    }
}
