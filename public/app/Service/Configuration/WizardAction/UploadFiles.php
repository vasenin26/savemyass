<?php

namespace app\Service\Configuration\WizardAction;

use app\Http\Request\Request;
use app\Http\Response\HtmlPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\I18n\I18n;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;
use app\Service\Configuration\Payload\UploadFilesFormPayload;
use app\Storage\Payload;
use app\View\LayoutTemplate;

class UploadFiles implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request, readonly private Payload $payload)
    {

    }

    public function showForm(): HtmlPage
    {
        $template = new LayoutTemplate('wizard/upload_files_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('publish_options.title'),
            'errors' => $this->payload->getErrors(),
        ]);

        return new HtmlPage($template);
    }

    public function saveForm(): Response
    {
        $payload = new UploadFilesFormPayload($this->request);

        if ($payload->isFinish()) {
            $this->configuration->setOption(Configuration::PUBLISH_FILES_UPLOADED, 1);
            $this->configuration->save();

            return new Redirect('/wizard');
        }

        $file = $payload->getFile();

        move_uploaded_file($file['tmp_name'], 'uploads/' . $file['name']);

        return new Redirect('/wizard', $payload);
    }
}