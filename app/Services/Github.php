<?php
namespace App\Services;

use GuzzleHttp\Client;

class Github
{
    protected $client   = null;
    protected $endpoint = 'https://api.github.com';

    public function __construct()
    {
        $accessToken  = config('services.github.token');
        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'headers'  => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);
    }

    public function get($path)
    {
        $ret = $this->client->get($path);
        return json_decode($ret->getBody());
    }

    public function post($path, $payload)
    {
        $ret = $this->client->post($path, [
            'json' => $payload,
        ]);
        return json_decode($ret->getBody());
    }

    public function destroy($path)
    {
        $ret = $this->client->delete($path);
        return json_decode($ret->getBody());
    }

    public function create($name, $description, $homepage, $private=false, $has_issues=true, $has_projects=true, $has_wiki=true){
        return $this->post('user/repos', json_encode([
            "name" => $name,
            "description" => $description,
            "homepage" => $homepage,
            "private" => $private,
            "has_issues" => $has_issues,
            "has_projects" => $has_projects,
            "has_wiki" => $has_wiki,
        ]));
    }

    public function issue($package, $title, $body, $labels=[]){
        return $this->post('repos/'.$package.'/issues', json_encode([
            "title" => $title,
            "body" => $body,
            "labels" => $labels,
        ]));
    }

    public function deleteRepository($package){
        return $this->destroy('repos/'. $package);
    }

    public function user(){
        return $this->get('user');
    }

    public function repositories(){
        return $this->get('user/repos');
    }

    public function repository($package){
        return $this->get('repos/' . $package);
    }

    public function release($package){
        return $this->get('repos/' . $package . '/releases');
    }
}
