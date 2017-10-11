<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 16:20
 */

namespace App\Entity;

class FeedBack
{
    /**
     * @var int $id
     */
    protected $id;
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
