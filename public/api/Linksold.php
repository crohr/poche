<?php
use Luracast\Restler\RestException;






/**
 * All methods in this class are protected
 */
class Links
{
//     public $dp;

//     static $FIELDS = array('url');

//     function __construct()
//     {
//         $this->dp = new DB_PDO_Sqlite();
//     }

//     function index()
//     {
//         return $this->dp->getAll();
//     }

//     function get($id)
//     {
//         return $this->dp->get($id);
//     }

//     function post($request_data = NULL)
//     {
//         $url = new Url($request_data['url']);
//         $content = $url->extract();

//         return $this->dp->insert($url->getUrl(), $content['title'], $content['body'], $_GET['user_id']);
//     }

//     function put($id, $request_data = NULL)
//     {
//         return $this->dp->update($id, $this->_validate($request_data));
//     }

//     function delete($id)
//     {
//         return $this->dp->delete($id);
//     }

//     private function _validate($data)
//     {
//         $link = array();
//         foreach (links::$FIELDS as $field) {
// //you may also validate the data here
//             if (!isset($data[$field]))
//                 throw new RestException(400, "$field field missing");
//             $link[$field] = $data[$field];
//         }
//         return $link;
//     }
//     
   public $dp;

    function __construct()
    {
        $this->dp = new DB_PDO_Sqlite();
    }

    function index()
    {
        return $this->dp->getAll();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    function get($id)
    {
        $r = $this->dp->get($id);
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @status 201
     *
     * @param string $url  {@type string} {@from body}
     *
     * @return mixed
     */
    function post($url)
    {
        error_log(print_r($url, true));
        die;
        return $this->dp->insert(compact('url'));
    }

    /**
     * @param string $url  {@type string} {@from body}
     *
     * @return mixed
     */
    function put($url)
    {
        $r = $this->dp->update(compact('url'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param string $url  {@type string} {@from body}
     *
     * @return mixed
     */
    function patch($url = null)
    {
        $patch = $this->dp->get($id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        if (isset($url)) {
            $patch['url'] = $url;
            $modified = true;
        }
        if (!$modified) {
            throw new RestException(304); //not modified
        }
        $r = $this->dp->update($patch);
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    function delete($id)
    {
        return $this->dp->delete($id);
    }
}