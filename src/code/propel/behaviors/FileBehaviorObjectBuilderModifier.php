<?php

namespace code\propel\behaviors;

use Propel\Generator\Behavior\Archivable\ArchivableBehavior;
use Propel\Generator\Builder\Om\AbstractOMBuilder;
use Propel\Generator\Model\Table;

class FileBehaviorObjectBuilderModifier {

    /**
     * @var ArchivableBehavior
     */
    protected $behavior;

    /**
     * @var Table
     */
    protected $table;

    /**
     * @var AbstractOMBuilder
     */
    protected $builder;

    /**
     * 
     * @var array
     */
    protected $attachments = [];

    /**
     * @param FileBehavior $behavior
     */
    public function __construct(FileBehavior $behavior) {
        $this->behavior = $behavior;
        $this->table = $behavior->getTable();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    protected function getParameter(string $key) {
        return $this->behavior->getParameter($key);
    }

    /**
     * @param AbstractOMBuilder $builder
     *
     * @return string the PHP code to be added to the builder
     */
    public function preSave(AbstractOMBuilder $builder): string {
        $script = "";
        $script = "\$this->saveUploadFiles(\$isInsert, \$con);";
        return $script;
    }

    /**
     * 
     * @param AbstractOMBuilder $builder
     * @return string
     */
    public function objectAttributes(AbstractOMBuilder $builder): string {
        foreach (explode(',', $this->getParameter('columns')) as $column) {
            $this->attachments[] = "'" . trim($column) . "'";
        }
        $script = '';
        $script = "protected \$attachment_fields = [" . implode(",", $this->attachments) . "];\n";
        $script .= "use  \\code\\storage\\database\\FileAttachments;";
        return $script;
    }

    /**
     * @param \Propel\Generator\Builder\Om\AbstractOMBuilder $builder
     *
     * @return string the PHP code to be added to the builder
     */
    public function objectMethods(AbstractOMBuilder $builder): string {
        $this->builder = $builder;
        $script = '';
        $this->addSetFields($script);

        return $script;
    }

    /**
     * 
     * @param Astring $script
     * @return void
     */
    public function addSetFields(string &$script): void {
        $fields_name = implode(",", $this->attachments);
        $script .= "
        /**
         *
         */
        public function setFields()
        {
            \$this->attachment_fields = [{$fields_name}];
        }
        ";
    }

}
