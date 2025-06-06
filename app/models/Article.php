<?php

class Article extends Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM clanky ORDER BY datum DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
