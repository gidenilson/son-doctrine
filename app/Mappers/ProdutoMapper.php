<?php


namespace Code\Sistema\Mappers;

use Code\Sistema\Entities\Produto;
use Doctrine\ORM\EntityManager;

class ProdutoMapper
{
    private $em;
    /**
     * ProdutoMapper constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(Produto $produto)
    {
        $this->em->persist($produto);
        $this->em->flush();
        return [
            "id" => $produto->getId(),
            "nome" => $produto->getNome(),
            "descricao" => $produto->getDescricao(),
            "valor" => $produto->getValor(),
        ];
    }
    public function delete($id)
    {

        $produto = $this->em->find('Code\Sistema\Entities\Produto', $id);
        if ($produto) {
            $this->em->remove($produto);
            $this->em->flush();
        }

        return ["success" => (true && $produto)];

    }

    public function update($id, $dados)
    {
        $produto = $this->em->find('Code\Sistema\Entities\Produto', $id);
        if ($produto) {
            $produto->setNome($dados['nome']);
            $produto->setDescricao($dados['descricao']);
            $produto->setValor($dados['valor']);
            $this->em->flush();

        }
        return ["success" => (true && $produto)];
    }
}