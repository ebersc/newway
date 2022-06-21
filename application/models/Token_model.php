<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->table = 'token';
        $this->load->helper('date');
        
        $this->inativa_tokens();
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

    public function inativa_tokens($where = ''){
        try{
            $data = date("Y-m-d H:i:s", strtotime(now('America/Sao_Paulo')));

            $condicao = empty($where) ? 'data_expiracao' < $data : $where;

            $this->db->update($this->table, ['ativo' => 0], $condicao);
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

    public function buscar($where){
        try{
            $resul = $this->db->select('*')
                            ->from($this->table)
                            ->where($where)
                            ->get();
            return $resul->num_rows() > 0 ? TRUE : FALSE;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function atualizaExpiracaoToken(){
        try{
            $id_token = $this->db->select('id_token')
                        ->from($this->table)
                        ->where(['ativo' => 1, 'id_usuario' => $this->session->user_id])
                        ->get()
                        ->row();
            // $id_token = ;
            $data_expiracao = date('Y-m-d H:i:s', strtotime('+15 minutes',now('America/Sao_Paulo')));
            // $data_expiracao = date('Y-m-d H:i:s', strtotime('+30 minutes', now('America/Sao_Paulo')));

            $this->db->update($this->table, ['data_expiracao' => $data_expiracao], ['id_token' => $id_token->id_token]);
        }catch(Exception $e){
            throw $e;
        }
    }
}