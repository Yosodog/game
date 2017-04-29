<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Role;
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

        $leader = Role::create([
                'name' => 'Leader',
                'alliance_id' => $alliance->id,
                'canChangeName' => true,
                'canRemoveMember' => true,
                'canDisbandAlliance' => true,
                'canChangeCosmetics' => true,
                'canCreateRoles' => true,
                'canEditRoles' => true,
                'canRemoveRoles' => true,
                'canReadAnnouncements' => true,
                'isDefaultRole' => false,
        		'canAssignRoles' => true,
        ]);
        $leader->save();

        $applicant = Role::create([
                'name' => 'Applicant',
                'alliance_id' => $alliance->id,
                'canChangeName' => false,
                'canRemoveMember' => false,
                'canDisbandAlliance' => false,
                'canChangeCosmetics' => false,
                'canCreateRoles' => false,
                'canEditRoles' => false,
                'canRemoveRoles' => false,
                'canReadAnnouncements' => false,
                'isDefaultRole' => true,
        		'canAssignRoles' => false,
        ]);
        $applicant->save();

        // Set the user's alliance to this newly created one
        Auth::user()->nation->allianceID = $alliance->id;
        Auth::user()->nation->role_id = $leader->id;
        Auth::user()->nation->save();
        
        // set Applicant id to default role id
        $alliance->default_role_id = $applicant->id;
        $alliance->save();

        // set Applicant id to default role id
        $alliance->default_role_id = $applicant->id;
        $alliance->save();

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
        $nations->load('user', 'role');

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
            $nation->role_id = null;
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
                $nation->role_id = $alliance->default_role_id;
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
        $roles = $alliance->role;

        return view('alliance.edit', [
                'alliance' => $alliance,
                'nations' => $nations,
                'flags' => $flags,
        		'roles' => $roles,
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
    	// if the user doesn't have permission to change the name, stop them from actually doing so
    	if (! Auth::user()->nation->role->canChangeName) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    	
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

    	// if the user doesn't have permission to change the forum, stop them from actually doing so
    	if (! Auth::user()->nation->role->canChangeCosmetics) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);

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
    	// if the user doesn't have permission to change the IRC channel, stop them from actually doing so
    	if (! Auth::user()->nation->role->canChangeCosmetics) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    	
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
    	// if the user doesn't have permission to change the Discord, stop them from actually doing so
    	if (! Auth::user()->nation->role->canChangeCosmetics) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);

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
    	// if the user doesn't have permission to change the description, stop them from actually doing so
    	if (! Auth::user()->nation->role->canChangeCosmetics) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    	
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
    	// if the user doesn't have permission to change the flag, stop them from actually doing so
    	if (! Auth::user()->nation->role->canChangeCosmetics) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    	
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
    	// if the user doesn't have permission to kick people, stop them from actually doing so
    	if (! Auth::user()->nation->role->canRemoveMember) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);

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
        $nation->role_id = null;
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
    	// if the user doesn't have permission to disband, stop them from actually doing so
    	if (! Auth::user()->nation->role->canDisbandAlliance) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    	
        // load all the nations in the alliance
        $nations = Nations::where('allianceID', $alliance->id)->paginate(15);
        $nations->load('user');

        // removes everyone
        foreach ($nations as $nation)
        {
            $nation->allianceID = null;
            $nation->role_id = null;
            $nation->save();
        }
        
        // gets rid of any lingering roles
        $alliance->default_role_id = null;
        $alliance->save();
        
        $roles = $alliance->role;
        
        // deletes roles for this alliance
        foreach ($roles as $role)
        {
    		$role->delete();
        }

        // gets rid of any lingering roles
        $alliance->default_role_id = null;
        $alliance->save();

        $name = $alliance->name;

        // deletes the alliance
        $alliance->delete();

        return redirect('/alliances')->with('alert-info', [$name.' has been disbanded. :(']);
    }
    
    /**
     * PATCH: /alliance/{$alliance}/edit/removeRole.
     *
     * Removes role from the alliance.
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removeRole(Alliance $alliance)
    {
    	// if the user doesn't have permission to remove roles, stop them from actually doing so
    	if (! Auth::user()->nation->role->canRemoveRoles) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    
    	// store role to be deleted
    	$role = Role::find($this->request->role);
    	
    	// If this role is the default, do not remove
    	if ($role->isDefaultRole)
    	{
    		return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-warning', ['This is the default role for this alliance, and cannot be removed.']);
    	}
    
    	// get users with this role
    	$nations = Nations::where('role_id', $role->id)->paginate(15);
    	
    	// If this role is the default, do not remove
    	if (count($nations) > 0)
    	{
    		return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-warning', ['This role currently has people masked to it, and cannot be removed.']);
    	}
    
    	// delete the role from the alliance
    	$role->delete();
    
    	return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', [$role->name.' has been deleted from the alliance!']);
    }
    
    /**
     * PATCH: /alliance/{$alliance}/edit/assignRole.
     *
     * Assigns role to member
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function assignRole(Alliance $alliance)
    {
    	// if the user doesn't have permission to assign roles, stop them from actually doing so
    	if (! Auth::user()->nation->role->canAssignRoles) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    
    	// store nation and role
    	$nation = Nations::find($this->request->nation);
    	$role = $this->request->role;
    	$name = Role::find($role)->name;
    
		$nation->role_id = $role;
		$nation->save();
    
    	return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', [$nation->user->name.' has been moved to '.$name]);
    }
    
    /**
     * PATCH: /alliance/{$alliance}/edit/createRole.
     *
     * Creates role for alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createRole(Alliance $alliance)
    {
    	// if the user doesn't have permission to create roles, stop them from actually doing so
    	if (! Auth::user()->nation->role->canCreateRoles) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    
    	// set the booleans manually, because fuck checkboxes
    	if (strlen($this->request->nameChange) != 2) $this->request->nameChange = false;
    	else $this->request->nameChange = true;
    	
    	if (strlen($this->request->userRemove) != 2) $this->request->userRemove = false;
    	else $this->request->userRemove = true;
    	 
    	if (strlen($this->request->disband) != 2) $this->request->disband = false;
    	else $this->request->disband = true;
    	 
    	if (strlen($this->request->cosmetics) != 2) $this->request->cosmetics = false;
    	else $this->request->cosmetics = true;
    	 
    	if (strlen($this->request->roleCreate) != 2) $this->request->roleCreate = false;
    	else $this->request->roleCreate = true;
    	 
    	if (strlen($this->request->roleEdit) != 2) $this->request->roleEdit = false;
    	else $this->request->roleEdit = true;
    	 
    	if (strlen($this->request->roleRemove) != 2) $this->request->roleRemove = false;
    	else $this->request->roleRemove = true;
    	 
    	if (strlen($this->request->announcements) != 2) $this->request->announcements = false;
    	else $this->request->announcements = true;
    	 
    	if (strlen($this->request->roleAssign) != 2) $this->request->roleAssign = false;
    	else $this->request->roleAssign = true;
    	 
    	// create new role
    	$role = Role::create([
    			'name' => $this->request->name,
    			'alliance_id' => $alliance->id,
    			'canChangeName' => $this->request->nameChange,
    			'canRemoveMember' => $this->request->userRemove,
    			'canDisbandAlliance' => $this->request->disband,
    			'canChangeCosmetics' => $this->request->cosmetics,
    			'canCreateRoles' => $this->request->roleCreate,
    			'canEditRoles' => $this->request->roleEdit,
    			'canRemoveRoles' => $this->request->roleRemove,
    			'canReadAnnouncements' => $this->request->announcements,
    			'isDefaultRole' => false,
    			'canAssignRoles' => $this->request->roleAssign,
    	]);
    
    	return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', [$this->request->name.' has been created!']);
    }
    
    /**
     * PATCH: /alliance/{$alliance}/edit/editRole.
     *
     * Edits role for alliance
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editRole(Alliance $alliance)
    {
    	// if the user doesn't have permission to edit roles, stop them from actually doing so
    	if (! Auth::user()->nation->role->canEditRoles) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-danger', ['You do not have permission to do that.']);
    	
    	// get role from role ID
    	$role = Role::find($this->request->role);
    	
    	// stop them from editing the default Applicant role
    	if ($role->isDefaultRole) return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-warning', ['This is the default Applicant role, and cannot be edited.']);
    
    	// set the booleans manually, because fuck checkboxes
    	if (strlen($this->request->nameChange) != 2) $this->request->nameChange = false;
    	else $this->request->nameChange = true;
    	 
    	if (strlen($this->request->userRemove) != 2) $this->request->userRemove = false;
    	else $this->request->userRemove = true;
    	
    	if (strlen($this->request->disband) != 2) $this->request->disband = false;
    	else $this->request->disband = true;
    	
    	if (strlen($this->request->cosmetics) != 2) $this->request->cosmetics = false;
    	else $this->request->cosmetics = true;
    	
    	if (strlen($this->request->roleCreate) != 2) $this->request->roleCreate = false;
    	else $this->request->roleCreate = true;
    	
    	if (strlen($this->request->roleEdit) != 2) $this->request->roleEdit = false;
    	else $this->request->roleEdit = true;
    	
    	if (strlen($this->request->roleRemove) != 2) $this->request->roleRemove = false;
    	else $this->request->roleRemove = true;
    	
    	if (strlen($this->request->announcements) != 2) $this->request->announcements = false;
    	else $this->request->announcements = true;
    	
    	if (strlen($this->request->roleAssign) != 2) $this->request->roleAssign = false;
    	else $this->request->roleAssign = true;
		
		// set all the roles manually
		$role->name = $this->request->name;
		$role->canChangeName = $this->request->nameChange;
		$role->canRemoveMember = $this->request->userRemove;
		$role->canDisbandAlliance = $this->request->disband;
		$role->canChangeCosmetics = $this->request->cosmetics;
		$role->canCreateRoles = $this->request->roleCreate;
		$role->canEditRoles = $this->request->roleEdit;
		$role->canRemoveRoles = $this->request->roleRemove;
		$role->canReadAnnouncements = $this->request->announcements;
		$role->canAssignRoles = $this->request->roleAssign;
		
		// save the edited role
		$role->save();
    
    	return redirect('/alliance/'.$alliance->id.'/edit')->with('alert-success', [$role->name.' has been edited!']);
    }
}
