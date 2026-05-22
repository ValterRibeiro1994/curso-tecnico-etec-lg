<?php 

class RespostaFuncao {
    public function respostaFuncao(bool $resposta, string $mensagem, array $dados){
        if (!$resposta){ // quando resposta for falsa nunca havera dados para transporte
            return ['status'=>$resposta, 'message'=> $mensagem];
        }

        // se dados for um array vazio, não tem necessidade da chave
        if (count($dados) === 0){
            return ['status'=>$resposta, 'message'=> $mensagem];
        }

        return ['status'=>$resposta, 'message'=>$mensagem, 'dados'=>$dados];
    }
}