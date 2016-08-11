<?php


namespace Code\Sistema\Services;
use Code\Sistema\Entities\Produto as ProdutoEntity;
use Doctrine\ORM\EntityManager;

class ProdutoService
{
    private $em;
    private $repository;
    /**
     * ProdutoService constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('Code\Sistema\Entities\Produto');
    }


    public function insert(array $data)
    {
        $produtoEntity = new ProdutoEntity();

        $produtoEntity->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setValor($data['valor']);

        $this->em->persist($produtoEntity);
        $this->em->flush();
        return ['success'=>true];
    }
    public function delete($id){
        $produto = $this->em->getReference('Code\Sistema\Entities\Produto', $id);
        $this->em->remove($produto);
        $this->em->flush();
        return ['success'=>true];

    }
    public function update($id, $dados){
        $produto = $this->em->getReference('Code\Sistema\Entities\Produto', $id);
        $produto->setNome($dados['nome'])
            ->setDescricao($dados['descricao'])
            ->setValor($dados['valor']);
        $this->em->persist($produto);
        $this->em->flush();
        return ['success'=>true];
    }

    public function fetchAll(){
        $repo = $this->em->getRepository('Code\Sistema\Entities\Produto');
        return $repo->findAll();
    }

    public function find($id){
        $repo = $this->em->getRepository('Code\Sistema\Entities\Produto');
        $produto = $repo->find($id);
        return $produto;
    }

    public function search(array $params){

        return $this->repository->search($params);
    }
}