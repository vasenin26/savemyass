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
use app\Service\Configuration\WizardCommand\AbstractCommand;
use app\Service\Configuration\WizardCommand\Again;
use app\Service\Configuration\WizardCommand\Next;
use app\Service\Configuration\WizardCommand\ShowPage;
use app\Storage\Payload;
use app\View\LayoutTemplate;

class UploadFiles implements WizardAction
{
    public function __construct(private readonly MainConfiguration $configuration, readonly private Request $request, readonly private Payload $payload)
    {

    }

    public function showForm(): AbstractCommand
    {
        $template = new LayoutTemplate('wizard/upload_files_form', [
            ...$this->configuration->getOptions(),
            'title' => I18n::get('publish_options.title'),
            'errors' => $this->payload->getErrors(),
        ]);

        return new ShowPage(new HtmlPage($template));
    }

    public function saveForm(): AbstractCommand
    {
        $payload = new UploadFilesFormPayload($this->request);

        if ($payload->isFinish()) {
            $this->configuration->setOption(Configuration::PUBLISH_FILES_UPLOADED, 1);
            $this->configuration->save();

            return new Next();
        }

        $file = $payload->getFile();

        move_uploaded_file($file['tmp_name'], 'uploads/' . $file['name']);

        return new Again($payload);
    }
}
