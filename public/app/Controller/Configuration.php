<?php

namespace app\Controller;

use app\Http\Request\Request;
use app\Http\Response\RedirectBack;
use app\Http\Response\Response;
use app\I18n\I18n;
use app\Storage\Session;

class Configuration
{

    public function __construct(readonly private Session $session, private readonly I18n $i18n)
    {
    }

    public function postAction(Request $request): Response
    {
        $lang = $request->getPayload('lang');
        $languages = $this->i18n->getAvailableLanguages();

        if (array_key_exists($lang, $languages)) {
            $this->session->setOption('lang', $lang);
            $this->session->save();
        }

        return new RedirectBack();
    }
}