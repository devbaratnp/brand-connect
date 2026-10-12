<?php

namespace App\Http\Controllers;

use App\Mail\MessageReceivedMail;
use App\Models\Campaign;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inbox()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->with('sender', 'campaign')
            ->latest()
            ->paginate(20);

        return view('messages.inbox', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
            ->with('receiver', 'campaign')
            ->latest()
            ->paginate(20);

        return view('messages.sent', compact('messages'));
    }

    public function create()
    {
        $campaigns = [];
        $users = [];

        if (Auth::user()->isBrand()) {
            $campaigns = Campaign::where('brand_id', Auth::id())->get();
            $users = User::where('role', 'creator')->get();
        } elseif (Auth::user()->isCreator()) {
            $campaigns = Campaign::where('status', 'open')->get();
            $users = User::where('role', 'brand')->get();
        }

        return view('messages.create', compact('campaigns', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'message' => 'required|string|max:2000',
        ]);

        $data['sender_id'] = Auth::id();

        $message = Message::create($data);

        Mail::to($message->receiver->email)->send(new MessageReceivedMail($message));

        return redirect()->route('messages.conversation', $data['receiver_id'])->with('success', 'Message sent successfully.');
    }

    public function show(Message $message)
    {
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        if ($message->receiver_id === Auth::id() && ! $message->read_at) {
            $message->update(['read_at' => now()]);
        }

        $message->load('sender', 'receiver', 'campaign');

        return view('messages.show', compact('message'));
    }

    public function conversation(User $user)
    {
        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->with('sender', 'receiver')->oldest()->get();

        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.conversation', compact('messages', 'user'));
    }
}
