<?php

namespace rafapaulino\WordpressPackage;
use Config;
use WordPress\WordPressFacade;
use Session;

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
        return session('wordpress_token');
    }

    public function setToken()
    {
        $token = $this->_wp->getToken();
        
        if ( isset($token["token"]["access_token"]) ) {
            Session::put('wordpress_token', $token["token"]["access_token"]);
            $this->_wp->setToken(session('wordpress_token'));
        }
    }

    public function getSites()
    {
        if ( trim($this->getToken()) !== "") {
            
            $this->_wp->setToken(session('wordpress_token'));
            $user = $this->_wp->getUserInfo();

            if ( isset($user["sites"]["sites"]) ) {
                
                $info = array();
                foreach($user["sites"]["sites"] as $site) {
                    $id = $site["ID"];
                    $titulo = $site["name"];
                    $url = $site["URL"];
        
                    if ( strpos($url, 'wordpress.com') ) {
                        $info[] = array(
                            'wordpress_id' => $id,
                            'titulo' => $titulo,
                            'url' => $url
                        );
                    }
                }
                return $info;
            }
        
        } else {
            return array();
        }
    }

    public function addPost($token, $site_id, $title, $content, $excerpt, $image)
    {
        $this->_wp->setToken($token);
        $post = $this->_wp->postAdd(
            $site_id,
            $title,
            $content,
            $excerpt,
            $image
        );

        if ( count($post) > 0 && isset($post['post']['URL']) )
            return $post['post']['URL'];
        else
            return '';
    }
}