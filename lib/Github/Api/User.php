<?php

/**
 * Searching users, getting user information
 * and managing authenticated user account information.
 *
 * @link      http://develop.github.com/p/users.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class Github_Api_User extends Github_Api
{
    /**
     * Search users by username
     * http://developer.github.com/v3/search/#search-users
     *
     * @param   string  $username         the username to search
     * @return  array                     list of users found
     */
    public function search($username)
    {
        $response = $this->get('legacy/user/search/'.urlencode($username));

        return $response['users'];
    }

    /**
     * Search users by email
     * http://developer.github.com/v3/search/#email-search
     *
     * @param   string  $email            the email to search
     * @return  array                     list of users found
     */
    public function searchEmail($email)
    {
        $response = $this->get('legacy/user/email/'.urlencode($email));

        return $response['user'];
    }

    /**
     * Get extended information about a user by its username
     * http://developer.github.com/v3/users/#get-a-single-user
     * http://developer.github.com/v3/users/#get-the-authenticated-user
     *
     * @param   string  $username         the username to show, empty for the authenticated user
     * @return  array                     informations about the user
     */
    public function show($username = '')
    {
        if ($username) {
            $response = $this->get('users/'.urlencode($username));
        } else {
            $response = $this->get('user');
        }

        return $response;
    }

    /**
     * Update user informations. Requires authentication.
     * http://developer.github.com/v3/users/#update-the-authenticated-user
     *
     * @param   array   $data             key=>value user attributes to update.
     *                                    key can be name, email, blog, company, location, hireable or bio
     * @return  array                     informations about the user
     */
    public function update(array $data)
    {
        $response = $this->patch('user', $data);

        return $response;
    }

    /**
     * Request the users that a specific user is following
     * http://developer.github.com/v3/users/followers/#list-users-following-another-user
     *
     * @param   string  $username         the username, empty for the authenticated user
     * @return  array                     list of followed users
     */
    public function getFollowing($username = '')
    {
        if ($username) {
            $response = $this->get('users/'.urlencode($username).'/following');
        } else {
            $response = $this->get('user/following');
        }

        return $response;
    }

    /**
     * Request the users following a specific user
     * http://developer.github.com/v3/users/followers/#list-followers-of-a-user
     *
     * @param   string  $username         the username, empty for the authenticated user
     * @return  array                     list of following users
     */
    public function getFollowers($username = '')
    {
        if ($username) {
            $response = $this->get('users/'.urlencode($username).'/followers');
        } else {
            $response = $this->get('user/followers');
        }

        return $response;
    }

    /**
     * Check if the authenticated user is following a user
     * http://developer.github.com/v3/users/followers/#check-if-you-are-following-a-user
     *
     * @param   string  $username         the username
     * @return  void                      if you are following this user, nothing will return
     *                                    if you are not following this user, it throw an exception with code 404
     */
    public function isFollowing($username)
    {
        return $this->get('user/following/'.urlencode($username));
    }

    /**
     * Make the authenticated user follow the specified user. Requires authentication.
     * http://developer.github.com/v3/users/followers/#follow-a-user
     *
     * @param   string  $username         the username to follow
     * @return  void                      if successfully followed a user
     */
    public function follow($username)
    {
        $response = $this->put('user/following/'.urlencode($username));
    }

    /**
     * Make the authenticated user unfollow the specified user. Requires authentication.
     * http://developer.github.com/v3/users/followers/#unfollow-a-user
     *
     * @param   string  $username         the username to unfollow
     * @return  void                      if successfully unfollowed a user
     */
    public function unFollow($username)
    {
        $response = $this->delete('user/following/'.urlencode($username));
    }

    /**
     * Request the repos that a specific user is watching
     * http://develop.github.com/p/users.html#watched_repos
     *
     * @param   string  $username         the username
     * @return  array                     list of watched repos
     */
    public function getWatchedRepos($username)
    {
        $response = $this->get('users/'.urlencode($username).'/watched');

        return $response;
    }

    /**
     * Get the authenticated user public keys. Requires authentication
     * http://developer.github.com/v3/users/keys/#list-public-keys-for-a-user
     *
     * @return  array                     list of public keys of the user
     */
    public function getKeys()
    {
        $response = $this->get('user/keys');

        return $response;
    }

    /**
     * Get the authenticated user a single public key. Requires authentication
     * http://developer.github.com/v3/users/keys/#get-a-single-public-key
     *
     * @param   integer  $id              the id of a key
     * @return  array                     list the items of the key
     */
    public function getKey($id)
    {
        $response = $this->get('user/keys/'.urlencode($id));

        return $response;
    }

    /**
     * Add a public key to the authenticated user. Requires authentication.
     * http://developer.github.com/v3/users/keys/#create-a-public-key
     *
     * @param string $title
     * @param string $key
     * @return  array                    list of public keys of the user
     */
    public function addKey($title, $key)
    {
        $response = $this->post('user/keys', array('title' => $title, 'key' => $key));

        return $response;
    }

    /**
     * Update a public key. Requires authentication
     * http://developer.github.com/v3/users/keys/#update-a-public-key
     *
     * @param   integer  $id              the id of a key
     * @return  array                     list the items of the key
     */
    public function updateKey($id, $title, $key)
    {
        $response = $this->patch('user/keys/'.urlencode($id), array('title' => $title, 'key' => $key));

        return $response;
    }

    /**
     * Remove a public key from the authenticated user. Requires authentication.
     * http://developer.github.com/v3/users/keys/#delete-a-public-key
     *
     * @param   string  $id             the id of a key
     * @return  void                    if successfully remove the key
     */
    public function removeKey($id)
    {
        $response = $this->delete('user/keys/'.urlencode($id));

        return $response;
    }

    /**
     * Get the authenticated user emails. Requires authentication.
     * http://developer.github.com/v3/users/emails/#list-email-addresses-for-a-user
     *
     * @return  array                     list of authenticated user emails
     */
    public function getEmails()
    {
        $response = $this->get('user/emails');

        return $response;
    }

    /**
     * Add an email to the authenticated user. Requires authentication.
     * http://developer.github.com/v3/users/emails/#add-email-addresses
     *
     * @param   string|array $emails      a single email or an email list
     * @return  array                     list of authenticated user emails
     */
    public function addEmail($emails)
    {
        $response = $this->post('user/emails', $emails);

        return $response;
    }

    /**
     * Remove an email from the authenticated user. Requires authentication.
     * http://developer.github.com/v3/users/emails/#delete-email-addresses
     *
     * @param   string|array $emails      a single email or an email list
     * @return  array                     if successfully removed
     */
    public function removeEmail($emails)
    {
        $response = $this->delete('user/emails', $emails);
    }
}
