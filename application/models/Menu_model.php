<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT `usm`.*, `um`.`menu`
                    FROM `usersubmenu` `usm`, `usermenu` `um`
                   WHERE `usm`.`usermenuid` = `um`.`usermenuid`
                    ";

        return $this->db->query($query)->result_array();
    }

    public function deleteMenu($usermenuid)
    {
        $this->db->where('usermenuid', $usermenuid);
        $this->db->delete('usermenu');
    }
}
