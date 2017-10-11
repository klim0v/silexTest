<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 18:07
 */

namespace App\Repository;

class FeedBackRepository
{
    /** @var \Doctrine\DBAL\Connection $db */
    protected $db;

    /**
     * FeedBackRepository constructor.
     * @param \Silex\Application $application
     */
    public function __construct(\Silex\Application $application)
    {
        $this->db = $application['db'];
    }

    /**
     * @return array
     */
    public function findAll(): ?array
    {
        $sql = "SELECT * FROM feed_back";
        return $this->db->fetchAll($sql) ? : null;
    }

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM feed_back WHERE id = ?";
        return $this->db->fetchAssoc($sql, array((int) $id)) ? : null;
    }

    /**
     * @param array $data
     * @return FeedBackRepository
     */
    public function set(array $data): FeedBackRepository
    {
        if (isset($data['id'])) {
            $this->db->update('feed_back', $data, array ('id' => $data['id']));
        } else {
            $this->db->insert('feed_back', $data);
        }
        return $this;
    }

    /**
     * @param $id
     * @return FeedBackRepository
     */
    public function del($id): FeedBackRepository
    {
        $this->db->delete('feed_back', array ('id' => $id));
        return $this;
    }
}
