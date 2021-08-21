<?php

namespace App\Services;


use MailchimpMarketing\ApiClient;

class MailChimpNewsletter implements Newsletter {


    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function subscribe ($email, $list = null) {
        $list ??= config('services.mailchimp.lists.subscribers');

        return $this->client->lists->addListMember($list, [
            "email_address" => $email,
            "status" => "subscribed",
        ]);
    }
}
