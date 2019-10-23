<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seksi_model extends CI_Model
{
    public function getSeksi()
    {
        $query = $this->db->get('seksi');
        return $this->db->query($query)->result_array();
    }
}
