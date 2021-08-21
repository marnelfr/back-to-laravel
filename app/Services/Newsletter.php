<?php

namespace App\Services;


use MailchimpMarketing\ApiClient;

class Newsletter {

    private $_client = null;

    public function subscribe ($email, $list = null) {
        $list ??= config('services.mailchimp.lists.subscribers');

        return $this->client()->lists->addListMember($list, [
            "email_address" => $email,
            "status" => "subscribed",
        ]);
    }

    public function client (): ApiClient
    {
        if ($this->_client === null) {
            $this->_client = new ApiClient();
            $this->_client->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => config('services.mailchimp.server')
            ]);
        }
        return $this->_client;
    }


}
