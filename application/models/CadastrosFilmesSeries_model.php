<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CadastrosFilmesSeries_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->table = 'cadastros_filmes_series';
    }

    public function inserir($dados){
        try{
            return $this->db->insert($this->table, $dados);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function voto($id){
        try{
            $where  = ['id' => $id];
            $resp = $this->db->select('votos')
                            ->from($this->table)
                            ->where($where)
                            ->get()
                            ->row();
            $voto = $resp->votos;

            $voto = $voto + 1;

            $update = ['votos' => $voto];

            $resul = $this->db->update($this->table, $update, $where);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function atualizar($dados, $where){
        try{

            if(empty($where)){
                throw new Exception("Update sem where");
            }

            $this->db->update($this->table, $dados, $where);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function deletar($id_item){
        try{
            $dados = ['id' => $id_item['id']];
            $this->db->delete($this->table, $dados);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function buscar($where = array()){
        try{
            $resul = $this->db->select("cfs.id, cfs.nome, t.nome_tipo AS tipo")
                            ->from($this->table . " as cfs")
                            ->join("tipo as t", "cfs.tipo = t.id", "inner")
                            ->where($where)
                            ->get();

            if($resul->num_rows() > 0){
                return $resul->result_array();
            }
            else{
                return array();
            }
        }catch(Exception $e){
            throw $e;
        }
	}

    private function atualizaExpiracaoToken(){
        try{
            //Pegar token ativo e adicionar tempo para expiracao;
        }catch(Exception $e){
            throw $e;
        }
    }
}