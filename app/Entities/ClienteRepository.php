<?php


namespace Code\Sistema\Entities;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;


class ClienteRepository extends EntityRepository
{


    public function search($params)
    {
        // filtra os parâmetros
        $search = (isset($params['s'])) ? $params['s'] : "";
        $limit = isset($params['l']) ? $params['l'] : null;
        $page = isset($params['p']) ? $params['p']  : 1;
        $page = $page >=1 ? $page : 1;
        $offset = ($page -1) * (int) $limit;


        // monta e query para buscar nos campos nome e email (com like)
        $qb = $this->createQueryBuilder('c');
        $qb->where($qb->expr()->orX(
                $qb->expr()->like('c.nome', $qb->expr()->literal("%{$search}%")),
                $qb->expr()->like('c.email', $qb->expr()->literal("%{$search}%"))
            ))
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('c.id', 'ASC');
        // executa a query com o paginator
        $paginator = new Paginator($qb->getQuery(), $fetchJoinCollection = true);

        // calcula quantas páginas
        if($limit){
            $pages = ceil($paginator->count() / $limit );
        }else{
            $pages = 1;
        }
        
        // itera o resultado do paginator para o array $result
        $result = [];
        foreach ($paginator as $cliente) {
          $result[]= ["id"=>$cliente->getId(),
              "nome"=>$cliente->getNome(),
              "email"=>$cliente->getEmail()];
        }

        // monta queryString da paginação
        $pagination = [];

        for($i = 1; $i <= $pages; $i++){
            if($i == $page) {
                $active = true;
            }else{
                $active = false;
            }
            $pagination[$i -1] = ["query"=>"s={$search}&p={$i}&l={$limit}", "active"=>$active];

        }


        // retorna o resultado como array
        return ['key'=>$search,
            'pages'=>$pages,
            'page'=>$page,
            'limit'=>$limit,
            'count'=>$paginator->count(),
            'pagination'=>$pagination,
            'result'=>$result];

    }

}
