<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessagesController extends Controller
{
    /**
     * Store the request for future use here.
     *
     * @var Request
     */
    protected $request;

    /**
     * MessagesController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Displays the user's inbox.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inbox()
    {
        $threads = Thread::forUser(Auth::user()->id)->get();

        return view('messenger.inbox', [
            'threads' => $threads,
            'currentUserId' => Auth::user()->id,
        ]);
    }

    /**
     * Returns the view to compose a message.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createView()
    {
        return view('messenger.create');
    }

    /**
     * Post route to create and send the message.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        $thread = Thread::create([
            'subject' => $this->request->subject,
        ]);

        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::user()->id,
            'body' => $this->request->message,
        ]);

        Participant::create([
           'thread_id' => $thread->id,
            'user_id' => Auth::user()->id,
            'last_read' => new Carbon(),
        ]);

        // Get participant ID
        $to = User::where('name', $this->request->to)->firstOrFail();

        $thread->addParticipant([$to->id]);

        return redirect('/account/inbox');
    }

    /**
     * View a message.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function view(int $id)
    {
        try
        {
            $thread = Thread::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            $this->request->session()->flash('alert-danger', ['That message does not exist']);

            return redirect('/account/inbox');
        }

        $thread->markAsRead(Auth::user()->id);

        return view('messenger.view', [
            'thread' => $thread,
        ]);
    }

    /**
     * When responding to a message.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(int $id)
    {
        try
        {
            $thread = Thread::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            $this->request->session()->flash('alert-danger', ['That message does not exist']);

            return redirect('/account/inbox');
        }

        $thread->activateAllParticipants();

        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $this->request->message,
        ]);

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
