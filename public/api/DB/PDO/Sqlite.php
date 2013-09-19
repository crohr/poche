<?php
use Luracast\Restler\RestException;

class DB_PDO_Sqlite
{
    private $db;
    function __construct()
    {
        $file = STORAGE_SQLITE;
        $db_found = file_exists($file);
        $this->db = new PDO('sqlite:' . $file);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // if (!$db_found)
        //     $this->install();
    }
    function get($id)
    {
        $sql = $this->db->prepare('SELECT * FROM entries WHERE id = ?');
        $sql->execute(array($id));
        return $this->id2int($sql->fetch());
    }
    function getAll($user_id, $view, $limit, $start)
    {
        $sql = 'SELECT * FROM entries WHERE user_id=?';
        switch ($view)
        {
            case 'archive':
                $sql = "SELECT * FROM entries WHERE user_id=? AND is_read=? ";
                $params = array($user_id, 1);
                break;
            case 'fav' :
                $sql = "SELECT * FROM entries WHERE user_id=? AND is_fav=? ";
                $params = array($user_id, 1);
                break;
            default:
                $sql = "SELECT * FROM entries WHERE user_id=? AND is_read=? ";
                $params = array($user_id, 0);
                break;
        }

        if ($limit > 0) {
            $sql .= "LIMIT " . $limit . " OFFSET " . $start;
        }

        $query = $this->db->prepare($sql);

        if (!$query->execute($params))
            return FALSE;

        return $this->id2int($query->fetchAll());
    }
    function insert($url, $title, $body, $user_id)
    {
        $query = $this->db->prepare('INSERT INTO entries (title, url, content, user_id) VALUES (?, ?, ?, ?)');
        $params = array($url, $title, $body, $user_id);
        if (!$query->execute($params))
            return FALSE;

        return $this->get($this->db->lastInsertId());
    }
    function update($id, $rec)
    {
        // $sql = $this->db->prepare("UPDATE entries SET url = ?, email = :email WHERE id = :id");
        // if (!$sql->execute(array(':id' => $id, ':name' => $rec['name'], ':email' => $rec['email'])))
        //     return FALSE;
        // return $this->get($id);
    }
    function delete($id)
    {
        $r = $this->get($id);
        if (!$r || !$this->db->prepare('DELETE FROM entries WHERE id = ?')->execute(array($id)))
            return FALSE;
        return $r;
    }

    function getApiById($user_id, $api)
    {
        $query = $this->db->prepare('SELECT count(*) FROM users_config WHERE user_id=? AND value=? AND name = "api"');
        $params = array($user_id, $api);

        if (!$query->execute($params))
            return FALSE;

        if ($query->fetchColumn() == 0)
            return FALSE;

        $query = $this->db->prepare('SELECT value FROM users_config WHERE user_id=? AND name = "role"');
        $params = array($user_id);

        if (!$query->execute($params))
            return FALSE;

        return $query->fetch();
    }

    private function id2int($r)
    {
        if (is_array($r)) {
            if (isset($r['id'])) {
                $r['id'] = intval($r['id']);
            } else {
                foreach ($r as &$r0) {
                    $r0['id'] = intval($r0['id']);
                }
            }
        }
        return $r;
    }
    private function install()
    {
        // $this->db->exec(
        // "CREATE TABLE authors(
        //     'id' INTEGER PRIMARY KEY AUTOINCREMENT,
        //     'name' TEXT,
        //     'email' TEXT
        // )");
        // $this->db->exec(
        // "INSERT INTO authors (name, email) VALUES ('Jac Wright', 'jacwright@gmail.com');
        //  INSERT INTO authors (name, email) VALUES ('Arul Kumaran', 'arul@luracast.com');
        // ");
    }
}

