<?php


namespace Code\Sistema\Services;

use Code\Sistema\Entities\Cliente as ClienteEntity;
use Doctrine\ORM\EntityManager;

class ClienteService
{

    private $em;
    private $repository;
    /**
     * ClienteService constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('Code\Sistema\Entities\Cliente');

    }

    public function insert(array $data)
    {
        $clienteEntity = new ClienteEntity();

        $clienteEntity->setNome($data['nome'])
            ->setEmail($data['email']);

        $this->em->persist($clienteEntity);
        $this->em->flush();
        return ['success'=>true];
    }

    public function update($id, $dados)
    {
        $cliente = $this->em->getReference('Code\Sistema\Entities\Cliente', $id);
        $cliente->setNome($dados['nome'])
            ->setEmail($dados['email']);
        $this->em->persist($cliente);
        $this->em->flush();
        return ['success'=>true];

    }
    public function delete($id)
    {
        $cliente = $this->em->getReference('Code\Sistema\Entities\Cliente', $id);
        $this->em->remove($cliente);
        $this->em->flush();
        return ['success'=>true];

    }
    public function fetchAll(){
        $repo = $this->em->getRepository('Code\Sistema\Entities\Cliente');
        return $repo->findAll();
    }

    public function find($id){
        $repo = $this->em->getRepository('Code\Sistema\Entities\Cliente');
        $cliente = $repo->find($id);
        return $cliente;
    }
    public function search(array $params){
        
        return $this->repository->search($params);
    }


}