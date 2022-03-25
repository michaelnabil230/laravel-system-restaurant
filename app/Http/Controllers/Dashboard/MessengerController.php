<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\QaTopicCreateRequest;
use App\Http\Requests\Dashboard\QaTopicReplyRequest;
use App\Models\QaTopic;
use App\Models\User;

class MessengerController extends Controller
{
    public function index()
    {
        $topics = QaTopic::query()
            ->where(function ($query) {
                $query
                    ->where('creator_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->latest()
            ->paginate();

        $title = __('dashboard.all_messages');
        $unreads = $this->unreadTopics();

        return view('dashboard.messenger.index', compact('topics', 'title', 'unreads'));
    }

    public function unreadTopics(): array
    {
        $topics = QaTopic::where(function ($query) {
            $query
                ->where('creator_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
        })
            ->with('messages')
            ->latest()
            ->get();

        $inboxUnreadCount = 0;
        $outboxUnreadCount = 0;

        foreach ($topics as $topic) {
            foreach ($topic->messages as $message) {
                if (
                    $message->sender_id !== auth()->id()
                    && $message->read_at === null
                ) {
                    if ($topic->creator_id !== auth()->id()) {
                        ++$inboxUnreadCount;
                    } else {
                        ++$outboxUnreadCount;
                    }
                }
            }
        }

        return [
            'inbox' => $inboxUnreadCount,
            'outbox' => $outboxUnreadCount,
        ];
    }

    public function createTopic()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $unreads = $this->unreadTopics();

        return view('dashboard.messenger.create', compact('users', 'unreads'));
    }

    public function storeTopic(QaTopicCreateRequest $request)
    {
        $topic = QaTopic::create([
            'subject' => $request->subject,
            'creator_id' => auth()->id(),
            'receiver_id' => $request->recipient,
        ]);

        $topic->messages()->create([
            'sender_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return to_route('dashboard.messenger.index');
    }

    public function showMessages(QaTopic $topic)
    {
        $this->checkAccessRights($topic);

        foreach ($topic->messages as $message) {
            if ($message->sender_id !== auth()->id() && $message->read_at === null) {
                $message->read_at = now();
                $message->save();
            }
        }

        $unreads = $this->unreadTopics();

        return view('dashboard.messenger.show', compact('topic', 'unreads'));
    }

    private function checkAccessRights(QaTopic $topic)
    {
        $user = auth()->user();

        return abort_if(! in_array($user->id, [$topic->creator_id, $topic->receiver_id]), 401);
    }

    public function destroyTopic(QaTopic $topic)
    {
        $this->checkAccessRights($topic);

        $topic->delete();

        return to_route('dashboard.messenger.index');
    }

    public function showInbox()
    {
        $title = __('dashboard.inbox');

        $topics = QaTopic::where('receiver_id', auth()->id())
            ->latest()
            ->paginate();

        $unreads = $this->unreadTopics();

        return view('dashboard.messenger.index', compact('topics', 'title', 'unreads'));
    }

    public function showOutbox()
    {
        $title = __('dashboard.outbox');

        $topics = QaTopic::where('creator_id', auth()->id())
            ->latest()
            ->paginate();

        $unreads = $this->unreadTopics();

        return view('dashboard.messenger.index', compact('topics', 'title', 'unreads'));
    }

    public function replyToTopic(QaTopicReplyRequest $request, QaTopic $topic)
    {
        $this->checkAccessRights($topic);

        $topic->messages()->create([
            'sender_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return to_route('dashboard.messenger.index');
    }

    public function showReply(QaTopic $topic)
    {
        $this->checkAccessRights($topic);

        $receiverOrCreator = $topic->receiverOrCreator();

        abort_if($receiverOrCreator === null || $receiverOrCreator->trashed(), 404);

        $unreads = $this->unreadTopics();

        return view('dashboard.messenger.reply', compact('topic', 'unreads'));
    }
}
