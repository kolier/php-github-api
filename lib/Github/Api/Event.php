<?php

/**
 * List events of users, orgs or repos
 *
 * @link      http://developer.github.com/v3/events/
 * @author    Json Fu <fujson at gmail dot com>
 * @license   MIT License
 */
class Github_Api_Event extends Github_Api
{
    /**
     * List public events
     * http://developer.github.com/v3/events/#list-public-events
     *
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getPublicEvents($page = 1)
    {
        $response = $this->get('events', array('page' => $page));

        return $response;
    }

    /**
     * List repository events
     * http://developer.github.com/v3/events/#list-repository-events
     *
     * @param   string  $username         username of repository
     * @param   string  $repository       repository name
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getRepoEvents($username, $repository, $page = 1)
    {
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/events', array('page' => $page));

        return $response;
    }

    /**
     * List issue events for a repository
     * http://developer.github.com/v3/events/#list-issue-events-for-a-repository
     *
     * @param   string  $username         username of repository
     * @param   string  $repository       repository name
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getIssueEvents($username, $repository, $page = 1)
    {
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/issues/events', array('page' => $page));

        return $response;
    }

    /**
     * List public events for a network of repositories
     * http://developer.github.com/v3/events/#list-public-events-for-a-network-of-repositories
     *
     * @param   string  $username         username of repository
     * @param   string  $repository       repository name
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getNetworkEvents($username, $repository, $page = 1)
    {
        $response = $this->get('networks/'.urlencode($username).'/'.urlencode($repository).'/events', array('page' => $page));

        return $response;
    }

    /**
     * List public events for an organization
     * http://developer.github.com/v3/events/#list-public-events-for-an-organization
     *
     * @param   string  $organization      organization name
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getOrganizationPublicEvents($organization, $page = 1)
    {
        $response = $this->get('orgs/'.urlencode($organization).'/events', array('page' => $page));

        return $response;
    }

    /**
     * List events that a user has received
     * http://developer.github.com/v3/events/#list-events-that-a-user-has-received
     *
     * @param   string  $username         username
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getUserReceivedEvents($username, $page = 1)
    {
        $response = $this->get('users/'.urlencode($username).'/received_events', array('page' => $page));

        return $response;
    }

    /**
     * List public events that a user has received
     * http://developer.github.com/v3/events/#list-public-events-that-a-user-has-received
     *
     * @param   string  $username         username
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getUserReceivedPublicEvents($username, $page = 1)
    {
        $response = $this->get('users/'.urlencode($username).'/received_events/public', array('page' => $page));

        return $response;
    }

    /**
     * List events performed by a user
     * http://developer.github.com/v3/events/#list-events-performed-by-a-user
     *
     * @param   string  $username         username
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getUserEvents($username, $page = 1)
    {
        $response = $this->get('users/'.urlencode($username).'/events', array('page' => $page));

        return $response;
    }

    /**
     * List public events performed by a user
     * http://developer.github.com/v3/events/#list-public-events-performed-by-a-user
     *
     * @param   string  $username         username
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getUserPublicEvents($username, $page = 1)
    {
        $response = $this->get('users/'.urlencode($username).'/events/public', array('page' => $page));

        return $response;
    }

    /**
     * List events for an organization
     * This is the user’s organization dashboard. You must be authenticated as the user to view this.
     * http://developer.github.com/v3/events/#list-events-for-an-organization
     *
     * @param   string  $username         username
     * @param   string  $organization     organization name
     * @param   integer $page
     * @return  array                     list of events
     */
    public function getOrganizationEvents($username, $organization, $page = 1)
    {
        $response = $this->get('users/'.urlencode($username).'/events/orgs/'.urlencode($organization), array('page' => $page));

        return $response;
    }
}
