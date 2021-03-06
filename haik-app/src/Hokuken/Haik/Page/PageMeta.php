<?php
namespace Hokuken\Haik\Page;

use Page;
use PageMetaFragment;
use Symfony\Component\Yaml\Yaml;
use Hokuken\Haik\Support\FragmentBag;
use Hokuken\Haik\Support\DataBag;

class PageMeta extends FragmentBag implements PageMetaInterface {

    /** @var Page page ORM */
    protected $page;

    /**
     * Constructor
     *
     * @param Page $page page ORM
     * @param boolean $set_data when true then read and set data of the $page. Default is true
     */
    public function __construct(Page $page, $set_data = true)
    {
        $this->container = array();

        $this->removedFragments = new DataBag();
        $this->setModel();
    
        $this->page = $page;
        if ($set_data)
            $this->read();
    }

    /**
     * Set Model class name to $model field
     */
    protected function setModel()
    {
        $this->model = 'PageMetaFragment';
    }

    /**
     * Create instance of model
     */
    protected function createModel()
    {
        $model = $this->model;
        $instance = new $model;
        $page = $this->getPage();
        if ($page->exists)
            $instance->haik_page_id = $page->id;

        return $instance;
    }

    /**
     * Save model
     */
    protected function saveModel($fragment)
    {
        if ($this->getPage()->exists)
            $fragment->save();
    }

    /**
     * Get page
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Read meta data of the page
     *
     * @return $this for method chain
     */
    public function read()
    {
        $this->removeAll();
        $this->removedFragments = new DataBag();

        $model = $this->model;

        $fragments = $model::where('haik_page_id', '=', $this->page->id)->get();

        foreach ($fragments as $fragment)
        {
            $this->setFragment($fragment->key, $fragment);
        }

        return $this;
    }

    /**
     * Set YAML to meta data
     *
     * @param string $yaml yaml
     * @return $this
     */
    public function setYaml($yaml)
    {
        if ($yaml === '') return $this;

        try {
            $this->setAll(Yaml::parse($yaml), true);
        }
        catch (ParseException $e) {
        
        }
        
        return $this;
    }

    /**
     * Get all meta data as YAML
     *
     * @return string meta data formatted YAML
     */
    public function toYaml()
    {
        $data = $this->getAll();
        if (count($data) === 0)
        {
            return '';
        }

        return Yaml::dump($data, 2);
    }

}
