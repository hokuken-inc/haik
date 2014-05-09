<?php
class Page extends Eloquent {

    protected $table = 'haik_pages';

    protected $bodyIsParsed = false;
    protected $content = '';

    /**
     * Parse body to HTML
     *
     * @return $this for method chain
     */
    public function parseBody()
    {
        $this->content = Parser::transform($this->body);
        $this->bodyIsParsed = true;
        return $this;
    }

    /**
     * Get parsed content
     *
     * @return string HTML content
     * @throws \RuntimeException when parseBody is not called
     */
    public function getContent()
    {
        if ($this->bodyIsParsed)
        {
            return $this->content;
        }
        throw new \RuntimeException("This page body is not parsed.");
    }

}
