<?php

namespace AppBundle\Model\Filter;

use AppBundle\ODM\Document\Note;
use ODM\DocumentMapper\DataMapperFactory;
use Symfony\Component\Yaml\Yaml;

class ContactsBlackListFilter
{
    private $dm_note;
    private $black_list;

    /**
     * DescriptionFilter constructor.
     * @param DataMapperFactory $dm_factory
     * @param                   $file_black_list
     */
    public function __construct(DataMapperFactory $dm_factory, $file_black_list)
    {
        $this->dm_note    = $dm_factory->init(Note::class);
        $this->black_list = Yaml::parse(file_get_contents($file_black_list));
    }

    /**
     * @param Note $note
     * @return bool
     */
    public function isAllow(Note $note)
    {
        $contacts = mb_strtolower(json_encode($note->getContacts()));

        $allow = true;
        foreach ($this->black_list as $str) {
            if (1 === preg_match('/' . $str . '/', $contacts)) {
                $allow = false;
                break;
            }
        }

        return $allow;
    }
}