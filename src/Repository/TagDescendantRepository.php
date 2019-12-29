<?php

declare(strict_types=1);

namespace Repository;

use Model\TagDescendant;
use Repository\Base\Database;

final class TagDescendantRepository
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function save(TagDescendant $tag_descendant): void
    {
        $stmt = $this->database->mysqli->prepare(
            "INSERT INTO tag_descendant (descendant, ancestor) VALUES (?, ?)");
        $stmt->bind_param("ss", $tag_descendant->tag_descendant, $tag_descendant->tag_ancestor);
        $stmt->execute();
    }
}