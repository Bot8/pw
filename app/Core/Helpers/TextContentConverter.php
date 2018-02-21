<?php

namespace App\Core\Helpers;

class TextContentConverter
{
    protected $content;

    protected $exploded;

    const URL_REGEX = '/(https?:\/\/\S+)/';
    const EMAIL_REGEX = '/(\S+@\S+)/';
    const HEADER_UNDERLING = '/^[=-]+$/';

    const TAG_PARAGRAPH_OPEN = '<p>';
    const TAG_PARAGRAPH_CLOSE = '</p>';
    const TAG_LIST_OPEN = '<ul>';
    const TAG_LIST_CLOSE = '</ul>';

    const TYPE_HEADER = '#';
    const TYPE_LIST_ITEM = '*';

    protected $paragraphOpened = false;
    protected $listOpened      = false;

    /**
     * TextContentConverter constructor.
     *
     * @param $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function convert(string $content)
    {
        return (new self($content))
            ->convertEmails()
            ->convertUrls()
            ->explode()
            ->implode()
            ->getContent();
    }

    public function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        return $this->getContent();
    }

    protected function convertUrls()
    {
        $this->content = preg_replace(self::URL_REGEX, '<a target="_blank" href="${1}">${1}</a>', $this->content);

        return $this;
    }

    protected function convertEmails()
    {
        $this->content = preg_replace(self::EMAIL_REGEX, '<a href="mailto:${1}">${1}</a>', $this->content);

        return $this;
    }

    protected function explode()
    {
        $fp = fopen("php://memory", 'r+');
        fputs($fp, $this->content);
        rewind($fp);

        while ($line = fgets($fp)) {
            $line = trim($line);

            if (empty($line)) {
                $this->processEmptyLine();
                continue;
            }

            if ($this->isHeaderLine($line)) {
                $this->processHeaderLine($line);
                continue;
            }

            if ($this->isListItem($line)) {
                $this->processListItem($line);
                continue;
            }

            if ($this->isHeaderUnderling($line)) {
                $this->processHeader();
                continue;
            }

            $this->exploded[] = "{$line}<br/>";
        }

        fclose($fp);

        return $this;
    }

    protected function implode()
    {
        $this->content = implode(PHP_EOL, $this->exploded);

        return $this;
    }

    protected function isHeaderUnderling(string $line)
    {
        return preg_match(self::HEADER_UNDERLING, $line);
    }

    protected function lastExploded()
    {
        return count($this->exploded) - 1;
    }

    protected function processHeader()
    {
        $last = $this->lastExploded();

        $this->exploded[$last] = "<h1>{$this->exploded[$last]}</h1>";
    }

    protected function changeLastExploded(string $string)
    {
        $last = $this->lastExploded();

        if (self::TAG_PARAGRAPH_OPEN == $this->exploded[$last]) {
            $this->paragraphOpened = false;
            $this->exploded[$last] = $string;

            return;
        }

        $this->exploded[] = $string;
    }

    protected function processHeaderLine(string $line)
    {
        $n = 0;

        while (self::TYPE_HEADER === $line{$n}) {
            $n++;
        }

        $line = substr($line, $n);

        $this->changeLastExploded("<h{$n}>{$line}</h{$n}>");
    }

    protected function openParagraph()
    {
        $this->exploded[] = self::TAG_PARAGRAPH_OPEN;
        $this->paragraphOpened = true;
    }

    protected function closeParagraph()
    {
        $this->exploded[] = self::TAG_PARAGRAPH_CLOSE;
        $this->paragraphOpened = false;
    }

    protected function openList()
    {
        $this->exploded[] = self::TAG_LIST_OPEN;
        $this->listOpened = true;
    }

    protected function closeList()
    {
        $this->exploded[] = self::TAG_LIST_CLOSE;
        $this->listOpened = true;
    }

    protected function processEmptyLine()
    {
        if ($this->listOpened) {
            $this->closeList();

            return;
        }

        if ($this->paragraphOpened) {
            $this->closeParagraph();
        }

        $this->openParagraph();
    }

    protected function isHeaderLine(string $line)
    {
        return 0 === strpos($line, self::TYPE_HEADER);
    }

    protected function isListItem(string $line)
    {
        return 0 === strpos($line, self::TYPE_LIST_ITEM);
    }

    protected function processListItem(string $line)
    {
        if (!$this->listOpened) {
            $this->changeLastExploded('');
            $this->openList();
        }

        $line = trim(substr($line, 1));

        $this->exploded[] = "<li>{$line}</li>";
    }
}