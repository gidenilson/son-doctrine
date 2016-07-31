<?php


namespace Code\Sistema\Mappers;

use Code\Sistema\Entities\Cliente;

use Doctrine\ORM\EntityManager;

class ClienteMapper
{
    private $em;

    /**
     * ClienteMapper constructor.
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(Cliente $cliente)
    {

        $this->em->persist($cliente);
        $this->em->flush();
        return [
            "success" => true,
            "id" => $cliente->getId(),
            "nome" => $cliente->getNome(),
            "email" => $cliente->getEmail()
        ];
    }

    public function delete($id)
    {

        $cliente = $this->em->find('Code\Sistema\Entities\Cliente', $id);
        if ($cliente) {
            $this->em->remove($cliente);
            $this->em->flush();
        }

        return ["success" => (true && $cliente)];

    }

    public function update($id, $dados)
    {
        $cliente = $this->em->find('Code\Sistema\Entities\Cliente', $id);
        if ($cliente) {
            $cliente->setNome($dados['nome']);
            $cliente->setEmail($dados['email']);
            $this->em->flush();

        }
        return ["success" => (true && $cliente)];
    }

}