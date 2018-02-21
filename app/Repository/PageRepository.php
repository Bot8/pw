<?php

namespace App\Repository;

use App\Model\Page;
use App\Core\Storage\Database;
use App\Core\Storage\Filesystem;
use App\DAO\Database\PageFactory;

class PageRepository
{
    /** @var PageFactory */
    protected $pageFactory;

    /** @var Database */
    protected $database;

    /** @var Filesystem */
    protected $filesystem;

    /**
     * PageRepository constructor.
     *
     * @param Database    $database
     * @param Filesystem  $filesystem
     * @param PageFactory $pageFactory
     */
    public function __construct(Database $database, Filesystem $filesystem, PageFactory $pageFactory)
    {
        $this->database = $database;
        $this->filesystem = $filesystem;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @param string $link
     *
     * @return Page|null
     */
    public function getByLink(string $link)
    {
        $data = $this->database->selectOneRaw(
            'SELECT `page`.* FROM page JOIN link l ON page.id = l.page_id WHERE link = :link',
            ['link' => $link]
        );

        if (empty($data)) {
            return null;
        }

        return $this->pageFactory->makePage($data);
    }

    public function getByFileName(string $fileName)
    {
        $data = $this->filesystem->find($fileName);

        if (empty($data)) {
            return null;
        }

        return $this->pageFactory->makePage($data);
    }
}