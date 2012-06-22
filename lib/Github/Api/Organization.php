<?php

/**
 * Searching organizations, getting organization information
 * and managing authenticated organization account information.
 *
 * @link      http://develop.github.com/p/orgs.html
 * @author    Antoine Berranger <antoine at ihqs dot net>
 * @license   MIT License
 */
class Github_Api_Organization extends Github_Api
{
    const ADMIN = "admin";
    const PUSH = "push";
    const PULL = "pull";

    static $PERMISSIONS = array(
        self::ADMIN,
        self::PUSH,
        self::PULL
    );

    /**
     * List all public organizations for a user.
     * http://developer.github.com/v3/orgs/#list
     *
     * @param   string  $username        if not empty, list all public organizations for this user
     *                                   if empty, list public and private organizations for the authenticated user
     * @return  array                    organizations
     */
    public function list($username = '')
    {
        if ($username) {
            $response = $this->get('users/'.urlencode($username).'/orgs');
        } else {
            $response = $this->get('user/orgs');
        }

        return $response;
    }

    /**
     * Get extended information about an organization by its name
     * http://developer.github.com/v3/orgs/#get
     *
     * @param   string  $name             the organization to show
     * @return  array                     informations about the organization
     */
    public function show($name)
    {
        $response = $this->get('orgs/'.urlencode($name));

        return $response;
    }

    /**
     * Edit an organization
     * http://developer.github.com/v3/orgs/#edit
     *
     * @param   string  $name             the organization name
     * @param   array   $data             key => value
     *                                    key can be billing_email, company, email, location or name
     * @return  array                     informations about the organization
     */
    public function update($name, array $data)
    {
        $response = $this->patch('orgs/'.urlencode($name), $data);

        return $response;
    }

    /**
     * List all repositories that you can access of that organizations 
     * http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param   string  $name             the organization name
     * @return  array                     the repositories
     */
    public function getAllRepos($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/repos');

        return $response;
    }

    /**
     * List all public repositories of that organization
     * http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param   string  $name             the organization name
     * @return  array                     the repositories
     */
    public function getPublicRepos($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/repos', array('type' => 'public'));

        return $response;
    }

    /**
     * List all members of that organization
     * http://developer.github.com/v3/orgs/members/#list-members
     *
     * @param   string  $name             the organization name
     * @return  array                     the members
     */
    public function getMembers($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/members');

        return $response;
    }

    /**
     * List all public members of that organization
     * http://developer.github.com/v3/orgs/members/#list-public-members
     *
     * @param   string  $name             the organization name
     * @return  array                     the members
     */
    public function getPublicMembers($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/public_members');

        return $response;
    }

    /**
     * To see if a user is a member of the organization
     * http://developer.github.com/v3/orgs/members/#get-member
     *
     * @param   string  $organization    the organization name
     * @param   string  $username        the user name
     * @return  void                     if the user is a member of the organization, nothing will return
     *                                   if not it throws an exception with code 404
     */
    public function isMember($organization, $username)
    {
        $response = $this->get('orgs/'.urlencode($organization).'/members/'.urlencode($username));
    }

    /**
     * Remove a user from the organization
     * http://developer.github.com/v3/orgs/members/#remove-a-member
     *
     * @param   string  $organization    the organization name
     * @param   string  $username        the user name
     * @return  void
     */
    public function removeMember($organization, $username)
    {
        $response = $this->delete('orgs/'.urlencode($organization).'/members/'.urlencode($username));
    }

    /**
     * Check if a user is a public member
     * http://developer.github.com/v3/orgs/members/#get-if-a-user-is-a-public-member
     *
     * @param   string  $organization    the organization name
     * @param   string  $username        the user name
     * @return  void                     if the user is a public member of the organization, nothing will return
     *                                   if not it throws an exception with code 404
     */
    public function isPublicMember($organization, $username)
    {
        $response = $this->get('orgs/'.urlencode($organization).'/public_members/'.urlencode($username));
    }

    /**
     * Publicize a user's membership
     * http://developer.github.com/v3/orgs/members/#publicize-a-users-membership
     *
     * @param   string  $organization    the organization name
     * @param   string  $username        the user name
     * @return  void
     */
    public function publicizeMembership($organization, $username)
    {
        $response = $this->put('orgs/'.urlencode($organization).'/public_members/'.urlencode($username));
    }

    /**
     * Conceal a user’s membership
     * http://developer.github.com/v3/orgs/members/#conceal-a-users-membership
     *
     * @param   string  $organization    the organization name
     * @param   string  $username        the user name
     * @return  void
     */
    public function concealMembership($organization, $username)
    {
        $response = $this->delete('orgs/'.urlencode($organization).'/public_members/'.urlencode($username));
    }

    /**
     * List all teams of that organization
     * http://developer.github.com/v3/orgs/teams/#list-teams
     *
     * @param   string  $name             the organization name
     * @return  array                     the teams
     */
    public function getTeams($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/teams');

        return $response;
    }

    /**
     * Get information of a team
     * http://developer.github.com/v3/orgs/teams/#get-team
     *
     * @param   integer $id             the team id
     * @return  array                   information about the team
     */
    public function getTeam($id)
    {
        $response = $this->get('teams/'.urlencode($id));

        return $response;
    }

    /**
     * Add a team to that organization
     * http://developer.github.com/v3/orgs/teams/#create-team
     *
     * @param   string  $organization     the organization name
     * @param   string  $team             name of the new team
     * @param   string  $permission       its permission [PULL|PUSH|ADMIN]
     * @param   array   $repositories     (optionnal) its repositories names
     * @return  array                     information about the team
     */
    public function addTeam($organization, $team, $permission, array $repositories = array())
    {
        if (!in_array($permission, self::$PERMISSIONS)) {
            throw new InvalidArgumentException("Invalid value for the permission variable");
        }

        $response = $this->post('orgs/'.urlencode($organization).'/teams', array(
            'name' => $team,
            'permission' => $permission,
            'repo_names' => $repositories
        ));

        return $response;
    }

    /**
     * Edit a team
     * http://developer.github.com/v3/orgs/teams/#edit-team
     *
     * @param   integer $id               id of the team
     * @param   string  $team             name of the new team
     * @param   string  $permission       its permission [PULL|PUSH|ADMIN]
     * @return  array                     information about the team
     */
    public function updateTeam($id, $team, $permission)
    {
        if (!in_array($permission, self::$PERMISSIONS)) {
            throw new InvalidArgumentException("Invalid value for the permission variable");
        }

        $response = $this->patch('teams/'.urlencode($id), array(
            'name' => $team,
            'permission' => $permission,
        ));

        return $response;
    }

    /**
     * Delete a team
     * http://developer.github.com/v3/orgs/teams/#delete-team
     *
     * @param   integer $id               id of the team
     * @return  void
     */
    public function removeTeam($id)
    {
        $response = $this->delete('teams/'.urlencode($id));
    }

    /**
     * List team members
     * http://developer.github.com/v3/orgs/teams/#list-team-members
     *
     * @param   integer $id               id of the team
     * @return  array                     members list
     */
    public function getTeamMembers($id)
    {
        $response = $this->get('teams/'.urlencode($id).'/members');

        return $response;
    }

    /**
     * Check if a user is member of a team
     * http://developer.github.com/v3/orgs/teams/#get-team-member
     *
     * @param   integer $id               id of the team
     * @param   string  $username         the user name
     * @return  void                      if the user is a member of the team, nothing will return
     *                                    if not it throws an exception with code 404
     */
    public function isTeamMember($id, $username)
    {
        $response = $this->get('teams/'.urlencode($id).'/members/'.urlencode($username));
    }

    /**
     * Add team member
     * http://developer.github.com/v3/orgs/teams/#add-team-member
     *
     * @param   integer $id               id of the team
     * @param   string  $username         the user name
     * @return  void                      if the user is a member of the team, nothing will return
     *                                    if you attempt to add an organization to a team, you will get exception with code 422
     */
    public function addTeamMember($id, $username)
    {
        $response = $this->put('teams/'.urlencode($id).'/members/'.urlencode($username));

        return $response;
    }

    /**
     * Remove team member
     * http://developer.github.com/v3/orgs/teams/#remove-team-member
     *
     * @param   integer $id               id of the team
     * @param   string  $username         the user name
     * @return  void
     */
    public function removeTeamMember($id, $username)
    {
        $response = $this->delete('teams/'.urlencode($id).'/members/'.urlencode($username));
    }

    /**
     * List team repos
     * http://developer.github.com/v3/orgs/teams/#list-team-repos
     *
     * @param   integer $id               id of the team
     * @return  array                     repos list
     */
    public function getTeamRepos($id)
    {
        $response = $this->get('teams/'.urlencode($id).'/repos');

        return $response;
    }

    /**
     * Check if a repo is managed by a team
     * http://developer.github.com/v3/orgs/teams/#get-team-repo
     *
     * @param   integer $id               id of the team
     * @param   string  $username         the user name
     * @param   string  $repo             the repo name
     * @return  void                      if the repo is managed by the team, nothing will return
     *                                    if not it throws an exception with code 404
     */
    public function isTeamRepo($id, $username, $repo)
    {
        $response = $this->get('teams/'.urlencode($id).'/repos/'.urlencode($username).'/'.urlencode($repo));
    }

    /**
     * Add a repo to a team
     * http://developer.github.com/v3/orgs/teams/#add-team-repo
     *
     * @param   integer $id               id of the team
     * @param   string  $username         the user name
     * @param   string  $repo             the repo name
     * @return  void                      if successed
     *                                    if you attempt to add a repo to a team that is not owned by the organization, it throws an exception with code 422
     */
    public function addTeamRepo($id, $username, $repo)
    {
        $response = $this->get('teams/'.urlencode($id).'/repos/'.urlencode($username).'/'.urlencode($repo));

        return $response;
    }

    /**
     * Remove a repo from a team
     * http://developer.github.com/v3/orgs/teams/#remove-team-repo
     *
     * @param   integer $id               id of the team
     * @param   string  $username         the user name
     * @param   string  $repo             the repo name
     * @return  void
     */
    public function removeTeamRepo($id, $username, $repo)
    {
        $response = $this->delete('teams/'.urlencode($id).'/repos/'.urlencode($username).'/'.urlencode($repo));
    }
}
