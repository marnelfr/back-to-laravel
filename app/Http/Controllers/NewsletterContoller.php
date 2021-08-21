<?php

namespace App\Http\Controllers;

use App\Services\MailChimpNewsletter;
use App\Services\Newsletter;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterContoller extends Controller
{

    public function __invoke (Newsletter $newsletter): RedirectResponse
    {
        request()->validate(['email' => 'required|email']);


//    $response = $client->lists->getAllLists();

//    $response = $client->lists->getList('707f652308');
//    $response = $client->lists->getListMembersInfo('707f652308');
//    ddd($response);

        try {
            $newsletter->subscribe(request('email'));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'Please provide a meaningful email'
            ]);
        }
        return back()->with('success', "You've been added to our newsletter successfully");

//    $response = $client->lists->updateListMember("707f652308", md5('gmlginolias@gmail.com'), [
//        'status' =>  'unsubscribed'
//    ]);
    }

}
