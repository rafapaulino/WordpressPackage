<?php

namespace rafapaulino\WordpressPackage;
use Config;
use WordPress\WordPressFacade;

class WordpressPackage
{
    private $_wp;

    public function __construct()
    {
        $client_id = Config::get('wordpress.client_id');
        $secret = Config::get('wordpress.secret');
        $redirect_url = route('wordpress.create');

        $this->_wp = new WordPressFacade($client_id, $redirect_url, $secret);
    }

    public function getLink()
    {
        $retorno = $this->_wp->getToken();
        
        if ($retorno['url'] !== "")
            return $retorno['url'];
        else 
            return '';
    }

    public function getToken()
    {
        $token = $this->_wp->getToken();
        if ( isset($token["token"]["access_token"]) )
            return $token["token"]["access_token"];
        else 
            return '';
    }

    public function setToken($token)
    {
        $this->_wp->setToken($token);
    }

    public function getSites()
    {
        if ( trim($this->getToken()) !== "") {
            
            $user = $this->_wp->getUserInfo();
            if ( isset($user["sites"]["sites"]) ) {
                
                $info = array();
                foreach($user["sites"]["sites"] as $site) {
                    $id = $site["ID"];
                    $titulo = $site["name"];
                    $url = $site["URL"];
        
                    if ( strpos($url, 'wordpress.com') ) {
                        $info[] = array(
                            'id' => $id,
                            'titulo' => $titulo,
                            'url' => $url
                        );
                    }
                }
            }
        
        } else {
            return array();
        }
    }

    public function addPost($site_id, $title, $content, $excerpt, $image)
    {
        $post = $this->_wp->postAdd(
            $site_id,
            $title,
            $content,
            $excerpt,
            $image
        );

        if ( count($post) > 0 && isset($post['post']['url']) )
            return $post['post']['url'];
        else
            return '';
    }
}