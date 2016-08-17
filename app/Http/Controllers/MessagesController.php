<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class MessagesController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function inbox()
    {
        $threads = Thread::forUser(Auth::user()->id)->get();

        return view("messenger.inbox", [
            "threads" => $threads,
            "currentUserId" => Auth::user()->id,
        ]);
    }

    public function createView()
    {
        return view("messenger.create");
    }

    public function create()
    {
        $thread = Thread::create([
            'subject' => $this->request->subject,
        ]);

        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::user()->id,
            'body' => $this->request->message
        ]);

        Participant::create([
           'thread_id' => $thread->id,
            'user_id' => Auth::user()->id,
            'last_read' => new Carbon()
        ]);

        // Get participant ID
        $to = User::where("name", $this->request->to)->firstOrFail();

        $thread->addParticipant([$to->id]);

        return redirect("/account/inbox");
    }
    
    public function view(int $id)
    {
        try
        {
            $thread = Thread::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            $this->request->session()->flash("alert-danger", ["That message does not exist"]);

            return redirect("/account/inbox");
        }

        $thread->markAsRead(Auth::user()->id);

        return view("messenger.view", [
            "thread" => $thread
        ]);
    }

    public function update(int $id)
    {
        try
        {
            $thread = Thread::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            $this->request->session()->flash("alert-danger", ["That message does not exist"]);

            return redirect("/account/inbox");
        }

        $thread->activateAllParticipants();

        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $this->request->message,
        ]);

        /* This is done in the documentation but I don't think it needs to be done
            So I'll leave it commented out here while I figure out if it's needed*/
        // Add replier as a participant
        $participant = Participant::firstOrCreate([
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
        ]);
        $participant->last_read = new Carbon;
        $participant->save();


        return redirect("account/messages/$id");
    }
}
