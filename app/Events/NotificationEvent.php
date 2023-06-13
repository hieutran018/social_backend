<?php

namespace App\Events;

use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notif;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notif)
    {
        $this->notif = $notif;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //thông báo đến bạn bè bài viết vừa được tạo (gửi đến android)
        $notify = new NotificationController();

        $userFrom = User::find($this->notif['from']);
        $topicName = Str::slug($this->notif['title'], '-');
        $payload = $this->notif['object_type'] . strval($this->notif['object_id']);
        $title = $this->notif['userNameFrom'] . " " . $this->notif['title'];

        $notify->sendNotifiToFriends(
            $userFrom,
            [
                'topicName' => $topicName,
                'title' => $title,
                'body' => '', //'Bạn của bạn vừa đăng bài viết mới, xem ngay!',
                'image' => null, // 'https://picsum.photos/536/354' random image
                'payload' => "$payload",
                // do có chữ 'from' trong này nên mắc công lồng thêm 1 object bên ngoài
                'data' => ['notif' => $this->notif],
            ],
        );


        return ['notif-' . $this->notif['to']];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
