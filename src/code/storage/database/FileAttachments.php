<?php

namespace code\storage\database;

use code\applications\ApiAppFactory;
use code\attachments\AttachmentsInterface;
use code\service\ServiceTypes;

trait FileAttachments {

    /**
     * 
     * @param string $name
     */
    protected function addAttachmentField(string $name): void {
        $this->attachment_fields[] = $name;
    }

    /**
     * 
     * @param array $names
     */
    protected function setAttachmentFields(array $names): void {
        $this->attachment_fields = $names;
    }

    /**
     * 
     * @return void
     */
    protected function saveUploadFiles($isInsert, $con): void {
        if (ApiAppFactory::getApp()->isWeb()) {
            /** @var AttachmentsInterface $service */
            $service = ApiAppFactory::getApp()->getService(ServiceTypes::ATTACHMENTS);
            $controller = ApiAppFactory::getApp()->getController();
            $uploadedFiles = $controller->getRequest()->getUploadedFiles();
            foreach ($uploadedFiles as $key => $file) {
                if (in_array($key, $this->attachment_fields)) {
                    if ($file->getError() === UPLOAD_ERR_OK) {
                        $method = "set" . $key;
                        $this->{$method}($service->saveFile($file));
                    }
                }
            }
        }
    }
}
