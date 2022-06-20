<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->table = 'token';
    }

    public function busca_token_ativo($where){
        try{
            $resul = $this->db->select('*')
                                ->from($this->table)
                                ->where($where)
                                ->get();
        
            if($resul->num_rows() > 0){
                return $resul->result_array()[0];
            }else{
                return [];
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function inativa_tokens(){
        try{
            $this->db->update($this->table, ['ativo' => 0], ['data_expiracao' < date('Y-m-d H:i:s')]);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function insere_token($dados){
        try{
            return $this->db->insert($this->table, $dados);
        }catch(Exception $e){
            throw $e;
        }
    }
}