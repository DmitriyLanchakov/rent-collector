<?php

namespace AppBundle\Model\Filter;

use AppBundle\ODM\Document\Note;
use ODM\DocumentMapper\DataMapperFactory;

class ExternalIdUniqueFilter
{
    private $dm_note;

    /**
     * PreUniqueFilter constructor.
     * @param DataMapperFactory $dm_factory
     */
    public function __construct(DataMapperFactory $dm_factory)
    {
        $this->dm_note = $dm_factory->init(Note::class);
    }

    /**
     * @param Note $note
     * @return bool
     */
    public function isExists(Note $note)
    {
        return null !== $this->dm_note->findOne([
                'external_id' => $note->getExternalId(),
                'source'      => $note->getSource()
            ]);
    }
}