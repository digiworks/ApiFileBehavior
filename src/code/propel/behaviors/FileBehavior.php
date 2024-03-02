<?php

namespace code\propel\behaviors;

use Propel\Generator\Model\Behavior;

class FileBehavior extends Behavior {

    protected $tableModificationOrder = 40;
    
    // default parameters value
    protected $parameters = array(
        'columns' => [],
    );

    /**
     * @var \Propel\Generator\Behavior\Archivable\FileBehaviorObjectBuilderModifier|null
     */
    protected $objectBuilderModifier;

    /**
     * @return $this|\Propel\Generator\Behavior\Archivable\FileBehaviorObjectBuilderModifier
     */
    public function getObjectBuilderModifier() {
        if ($this->objectBuilderModifier === null) {
            $this->objectBuilderModifier = new FileBehaviorObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }
    
    /**
     * Get the getter of the column of the behavior
     *
     * @return string The related getter, e.g. 'getSlug'
     */
    protected function getColumnGetter($name): string
    {
        return 'get' . $this->table->getColumn($name)->getPhpName();
    }

    /**
     * Get the setter of the column of the behavior
     *
     * @return string The related setter, e.g. 'setSlug'
     */
    protected function getColumnSetter($name): string
    {
        return 'set' . $this->table->getColumn($name)->getPhpName();
    }

}
