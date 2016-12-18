<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Flags;
use App\Models\Alliance;
use Illuminate\Http\Request;
use App\Models\Nation\Nations;

class AllianceController extends Controller
{
    /**
     * Store the request for later use.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * AllianceController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Route to create the create an alliance page.
     */
    public function create()
    {
        if (Auth::user()->nation->hasAlliance()) // Checking to make sure they don't already have an alliance
            return redirect('/alliance/'.Auth::user()->nation->alliance->id);

        $flags = Flags::all();

        return view('alliance.create', [
            'flags' => $flags,
        ]);
    }

    /**
     * POST: /alliance/create.
     *
     * Creates an alliance
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createPOST()
    {
        if (Auth::user()->nation->hasAlliance()) // Checking to make sure they don't already have an alliance
            return redirect('/alliance/'.Auth::user()->nation->alliance->id);

        $this->validate($this->request, [
            'name' => 'required|unique:alliances|max:25',
            'forumURL' => 'required|url|active_url',
            'irc' => 'required',
            'description' => 'required',
            'flag' => 'required|integer|exists:flags,id',
        ]);

        $alliance = Alliance::create([
            'name' => $this->request->name,
            'description' => $this->request->description,
            'forumURL' => $this->request->forumURL,
            'IRCChan' => $this->request->irc,
            'flagID' => $this->request->flag,
            'discord' => $this->request->discord,
        ]);

        // Set the user's alliance to this newly created one
        Auth::user()->nation->allianceID = $alliance->id;
        Auth::user()->nation->save();

        return redirect("/alliance/$alliance->id");
    }

    /**
     * GET: /alliance/{$alliance}.
     *
     * Gets the alliance and displays the alliance page
     *
     * @param Alliance $alliance
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Alliance $alliance)
    {
        // We could get the members by eager loading, but we want to paginate so gotta do it special
        $nations = Nations::where('allianceID', $alliance->id)->paginate(15);
        $nations->load('user');

        return view('alliance.view', [
            'alliance' => $alliance,
            'nations' => $nations,
        ]);
    }

    /**
     * GET: /alliances.
     *
     * Returns a view with all the alliances in the game with some info about them
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewAll()
    {
        $alliances = Alliance::paginate(25);
        $alliances->load('nations'); // Load this here so we don't have to query for every alliance to get their mem num

        return view('alliance.all', [
            'alliances' => $alliances,
        ]);
    }

    /**
     * PATCH: /alliance/{$alliance}/leave.
     *
     * Allows the user to leave an alliance.
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function leaveAlliance(Alliance $alliance)
    {
        if (! Auth::user()->hasNation)
            abort(403);

        $nation = Auth::user()->nation;

        if ($alliance->id == $nation->allianceID)
        {
            $nation->allianceID = null;
            $nation->save();
            $name = $alliance->name;

            if ($alliance->countMembers() == 0) $alliance->delete();

            $this->request->session()->flash('alert-success', ['You have left your alliance, '.$name.'!']);

            return redirect('/alliances');
        }
        else
        {
            $this->request->session()->flash('alert-warning', ['You are not a member of this alliance!']);

            return redirect('/alliances');
        }

    }

    /**
     * PATCH: /alliance/{$alliance}/join.
     *
     * Allows the user to leave an alliance.
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function joinAlliance(Alliance $alliance)
    {
        if (! Auth::user()->hasNation)
            abort(403);

            $nation = Auth::user()->nation;

            if ($nation->allianceID == $alliance->id)
            {
                $this->request->session()->flash('alert-warning', ['You are already a member of this alliance!']);
            }
            elseif ($nation->allianceID != null)
            {
                $this->request->session()->flash('alert-warning', ['You are already a member of an alliance! Leave that one before joining this one!']);
            }
            else
            {
                $nation->allianceID = $alliance->id;
                $nation->save();
                $this->request->session()->flash('alert-success', ['You have successfully joined '.$alliance->name.'!']);
            }

            return redirect('/alliance/'.$alliance->id);
    }

    /**
     * GET: /alliance/{$alliance}/edit.
     *
     * Shows the edit page of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Alliance $alliance)
    {
        $nations = Nations::where('allianceID', $alliance->id)->paginate(15);
        $nations->load('user');
        $flags = Flags::all();

        return view('alliance.edit', [
                'alliance' => $alliance,
                'nations' => $nations,
                'flags' => $flags,
        ]);
    }

    /**
     * POST: /alliance/{$alliance}/edit/renameAlliance.
     *
     * Changes the name of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function renameAlliance(Alliance $alliance)
    {
        // validate alliance name change, make sure it is unique
        $this->validate($this->request, [
                'name' => 'required|unique:alliances,name|max:255',
        ]);

        // actually change the name
        $alliance->name = $this->request->name;
        $alliance->save();

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', ['Alliance name changed successfully!']);
    }

    /**
     * POST: /alliance/{$alliance}/edit/changeForumURL.
     *
     * Changes the forumURL of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeForum(Alliance $alliance)
    {
        // No verification needed, so just save the new forum URL.
        $alliance->forumURL = $this->request->forumURL;
        $alliance->save();

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', ['Alliance forum changed successfully!']);
    }

    /**
     * POST: /alliance/{$alliance}/edit/changeIRCChannel.
     *
     * Changes the IRC Channel of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeIRC(Alliance $alliance)
    {
        // No verification needed, so just save the new IRC Channel.
        $alliance->IRCChan = $this->request->IRCChan;
        $alliance->save();

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', ['IRC channel changed successfully!']);
    }

    /**
     * POST: /alliance/{$alliance}/edit/changeDiscordServer.
     *
     * Changes the Discord Server of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeDiscord(Alliance $alliance)
    {
        // No verification needed, so just save the new discord server.
        $alliance->discord = $this->request->discord;
        $alliance->save();

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', ['Discord changed successfully!']);
    }

    /**
     * POST: /alliance/{$alliance}/edit/changeAllianceDescription.
     *
     * Changes the description of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeDescription(Alliance $alliance)
    {
        // No verification needed, so just save the new description.
        $alliance->description = $this->request->description;
        $alliance->save();

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', ['Description changed successfully!']);
    }

    /**
     * POST: /alliance/{$alliance}/edit/changeAllianceFlag.
     *
     * Changes the flag of an alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeFlag(Alliance $alliance)
    {
        // verify the flag exists
        $this->validate($this->request, [
                'flag' => 'required|integer|exists:flags,id',
        ]);

        // Save the new flag.
        $alliance->flagID = $this->request->flag;
        $alliance->save();

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', ['Flag changed successfully!']);
    }

    /**
     * PATCH: /alliance/{$alliance}/edit/removeMember.
     *
     * Removes a member from the alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removeMember(Alliance $alliance)
    {
        // Store nation as a variable
        $nationID = $this->request->nation;
        $userNation = Auth::user()->nation;

        // The person using the method can't remove themselves, so check if they are trying to remove themself.
        if ($userNation->id == $nationID)
        {
            return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-warning', ['You cannot remove yourself using this method! Leave the alliance instead!']);
        }

        // get nation from nation ID
        $nation = Nations::find($nationID);

        // Check to see if the two are in the same alliance
        if (Auth::user()->nation->aID != $nation->aID) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['Either the person has been removed already or you do not have the proper permissions.']);

        // Remove them from the alliance
        $nation->allianceID = null;
        $nation->save();
        $name = $nation->user->name;

        return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', [$name.' has been removed from the alliance!']);
    }

    /**
     * DELETE: /alliance/{$alliance}/edit/disband.
     *
     * Disbands an alliance and removes it from the game
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disband(Alliance $alliance)
    {
        // load all the nations in the alliance
        $nations = Nations::where('allianceID', $alliance->id)->paginate(15);
        $nations->load('user');

        // removes everyone
        foreach ($nations as $nation)
        {
            $nation->allianceID = null;
            $nation->save();
        }

        $name = $alliance->name;

        // deletes the alliance
        $alliance->delete();

        return redirect('/alliances')->with('alert-info', [$name.' has been disbanded. :(']);
    }
}
