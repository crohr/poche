<?php
/**
 * All methods in this class are protected
 * @access protected
 */
class Links
{
    public $dp;

    static $FIELDS = array('url');

    function __construct()
    {
        $this->dp = new DB_PDO_Sqlite();
    }

    function index($request_data = NULL)
    {
        $view = isset($_GET['view']) ? $_GET['view'] : '';
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        return $this->dp->getAll($_GET['user_id'], $view, $limit, $start);
    }

    /**
     * [get description]
     * @param  int $id [description]
     * @return [type]     [description]
     */
    function get($id)
    {
        return $this->dp->get($id);
    }

    function post($request_data = NULL)
    {
        $url = new Url($request_data['url']);
        $content = $url->extract();

        return $this->dp->insert($url->getUrl(), $content['title'], $content['body'], $_GET['user_id']);
    }

    function put($id, $request_data = NULL)
    {
        return $this->dp->update($id, $this->_validate($request_data));
    }

    function delete($id)
    {
        return $this->dp->delete($id);
    }

    private function _validate($data)
    {
        $link = array();
        foreach (links::$FIELDS as $field) {
//you may also validate the data here
            if (!isset($data[$field]))
                throw new RestException(400, "$field field missing");
            $link[$field] = $data[$field];
        }
        return $link;
    }
}

