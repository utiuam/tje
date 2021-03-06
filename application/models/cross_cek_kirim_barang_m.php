<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cross_cek_kirim_barang_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getData($sWhere, $sOrder, $sLimit) {
        $result = array();
        $datemin = $this->input->post('date_min');
        $datemax = $this->input->post('date_max');
        //$sWhere = 
        if(empty($sWhere)){
            $sWhere = '';
            $sWhere .= ' WHERE (m_cek_tgl>="'.$datemin.'" AND m_cek_tgl<="'.$datemax.'") ';
        }else{
            $sWhere .= ' AND (m_cek_tgl>="'.$datemin.'" AND m_cek_tgl<="'.$datemax.'") ';
        }
        //$sWhere .= ' AND (m_cek_tgl>="'.$datemin.'" AND m_cek_tgl<="'.$datemax.'") ';
        $query = "SELECT * FROM v_m_cek $sWhere ";
        //echo $query;
        $sqlX = $this->db->query($query);
        $result['total'] = $sqlX->num_rows();

        $sqlY = $this->db->query($query . "$sOrder $sLimit");
        $result['data'] = $sqlY->result_array();

        return $result;
    }

    function getDataKirim($nopol,$edit = false){
        if($edit){
            $where = "WHERE stat >='1' AND NOKIRIM = '$nopol'";
        }else{
            $where = "WHERE stat ='1' AND NOKIRIM = '$nopol'";
        }
        
        
        $query = $this->db->query("SELECT * FROM tt_kirim $where");
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getNopol($query) {
        $query = $this->db->query("SELECT nokirim,nopol,tglkirim FROM m_kirim WHERE stat='1' AND (nopol LIKE '%$query%' OR nokirim LIKE '%$query%') ");
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    
    function getListById($id){
        $this->db->where('m_cek_no', $id);
        $result = $this->db->get('v_m_cek');
        return $result->row();
    }
}
