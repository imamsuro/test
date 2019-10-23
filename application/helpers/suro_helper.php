<?php

function isLogin()
{
    $is = get_instance();

    if (!$is->session->userdata('email')) {
        redirect('auth');
    } else {
        $roleid = $is->session->userdata('roleid');
        $menu = $is->uri->segment(1);

        $queryMenu = $is->db->get_where('usermenu', ['menu' => $menu])->row_array();

        $usermenuid = $queryMenu['usermenuid'];

        $userAccess = $is->db->get_where('useraccessmenu', [
            'roleid'        => $roleid,
            'usermenuid'    => $usermenuid
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}


function checkAccess($roleid, $usermenuid)
{
    $is = get_instance();

    $result = $is->db->get_where('useraccessmenu', [
        'roleid'        => $roleid,
        'usermenuid'    => $usermenuid
    ]);

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
