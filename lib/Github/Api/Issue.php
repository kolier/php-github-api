<?php

/**
 * Listing issues, searching, editing and closing your projects issues.
 *
 * @link      http://develop.github.com/p/issues.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class Github_Api_Issue extends Github_Api
{
    /**
     * List issues by username, repo and state
     * http://developer.github.com/v3/issues/#list-issues-for-a-repository
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   array   $parameters       the issue state, milestone, assignee, mentioned, ect.
     * @return  array                     list of issues found
     */
    public function getList($username, $repo, array $parameters = array())
    {
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/issues', $parameters);

        return $response;
    }

    /**
     * Search issues by username, repo, state and search term
     * http://developer.github.com/v3/search/#search-issues
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $state            the issue state, can be open or closed
     * @param   string  $searchTerm       the search term to filter issues by
     * @return  array                     list of issues found
     */
    public function search($username, $repo, $state, $searchTerm)
    {
        $response = $this->get('legacy/issues/search/'.urlencode($username).'/'.urlencode($repo).'/'.urlencode($state).'/'.urlencode($searchTerm));

        return $response;
    }

    /**
     * Search issues by label
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $label            the label to filter issues by
     * @return  array                     list of issues found
     */
    public function searchLabel($username, $repo, $label)
    {
        return $this->getList($username, $repo, $label, array('labels' => $label));
    }

    /**
     * Get extended information about an issue by its username, repo and number
     * http://developer.github.com/v3/issues/#get-a-single-issue
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @return  array                     information about the issue
     */
    public function show($username, $repo, $issueNumber)
    {
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($issueNumber));

        return $response;
    }

    /**
     * Create a new issue for the given username and repo.
     * The issue is assigned to the authenticated user. Requires authentication.
     * http://developer.github.com/v3/issues/#create-an-issue
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueTitle       the new issue title
     * @param   string  $issueBody        the new issue body
     * @return  array                     information about the issue
     */
    public function open($username, $repo, $issueTitle, $issueBody)
    {
        $response = $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/issues', array(
            'title' => $issueTitle,
            'body' => $issueBody
        ));

        return $response;
    }

    /**
     * Close an existing issue by username, repo and issue number. Requires authentication.
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @return  array                     information about the issue
     */
    public function close($username, $repo, $issueNumber)
    {
        return $this->update($username, $repo, $issueNumber, array('state' => 'close'));
    }

    /**
     * Update issue informations by username, repo and issue number. Requires authentication.
     * http://developer.github.com/v3/issues/#edit-an-issue
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @param   array   $data             key=>value user attributes to update.
     *                                    key can be title or body
     * @return  array                     information about the issue
     */
    public function update($username, $repo, $issueNumber, array $data)
    {
        $response = $this->patch('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($issueNumber), $data);

        return $response;
    }

    /**
     * Repoen an existing issue by username, repo and issue number. Requires authentication.
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @return  array                     informations about the issue
     */
    public function reOpen($username, $repo, $issueNumber)
    {
        return $this->update($username, $repo, $issueNumber, array('state' => 'open'));
    }

    /**
     * List an issue comments by username, repo and issue number
     * http://developer.github.com/v3/issues/comments/#list-comments-on-an-issue
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @return  array                     list of issue comments
     */
    public function getComments($username, $repo, $issueNumber)
    {
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($issueNumber).'/comments');

        return $response;
    }

    /**
     * Add a comment to the issue by username, repo and issue number
     * http://developer.github.com/v3/issues/comments/#create-a-comment
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @param   string  $commentBody      the comment body
     * @return  array                     the created comment
     */
    public function addComment($username, $repo, $issueNumber, $commentBody)
    {
        $response = $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($issueNumber).'/comments', array(
            'comment' => $commentBody
        ));

        return $response;
    }

    /**
     * List all project labels by username and repo
     * http://developer.github.com/v3/issues/labels/#list-all-labels-for-this-repository
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @return  array                     list of project labels
     */
    public function getLabels($username, $repo)
    {
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/labels');

        return $response;
    }

    /**
     * Add a label to the issue by username, repo and issue number. Requires authentication.
     * http://developer.github.com/v3/issues/labels/#create-a-label
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @param   string  $labelName        the label name
     * @return  array                     list of issue labels
     */
    public function addLabel($username, $repo, $labelName, $issueNumber)
    {
        $response = $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($issueNumber), array(
            $labelName
        ));

        return $response;
    }

    /**
     * Remove a label from the issue by username, repo, issue number and label name. Requires authentication.
     * http://develop.github.com/p/issues.html#add_and_remove_labels
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $issueNumber      the issue number
     * @param   string  $labelName        the label name
     * @return  array                     list of issue labels
     */
    public function removeLabel($username, $repo, $labelName, $issueNumber)
    {
        $response = $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($issueNumber).'/labels/'.urlencode($labelName));

        return $response;
    }
}
