<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MyGuestBook_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function create($data){
        $this->db->insert('myguestbook', $data);
        return TRUE;
    }

    function read($where, $length, $start) {
        $this->db->limit($length, $start);
        $query = $this->db->get_where('myguestbook', $where);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('myguestbook', $data);
        return TRUE;
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('myguestbook');

        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }
}

?>