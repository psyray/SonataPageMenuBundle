<?php


namespace Skillberto\SonataPageMenuBundle\Entity\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gedmo\Sortable\SortableListener;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Skillberto\SonataPageMenuBundle\Exception\InvalidArgumentException;
use Sonata\PageBundle\Model\Site;

class MenuRepository extends NestedTreeRepository
{
    public function getMaxPositionByParentId($parent = null)
    {

        $qb = $this->createQueryBuilder('e');
        $qb->select('MAX(e.position) as max_position');

        if ($parent != null) {
            $qb->where('e.parent = :parent');
            $qb->setParameter('parent', $parent);
        } else {
            $qb->where('e.parent IS NULL');
        }

        $res = $qb->getQuery()->getResult();

        return $res[0]['max_position'];
    }

    public function getParentChildNumber()
    {
        $qb = $this->createQueryBuilder('m')
        ->select('IDENTITY(m.parent) as parent')
        ->addSelect('COUNT(m) as size')
        ->groupBy('m.parent')
        ->addOrderBy('m.root', 'ASC')
        ->addOrderBy('m.lft', 'ASC')
        ;
        
        return $qb->getQuery()->getResult();
    }
    
    public function getMenus(Site $site, $type)
    {
        $qb = $this->createQueryBuilder('m')
        ->select('m','p','s','mp','mc')
        ->leftJoin('m.parent', 'mp')
        ->leftJoin('m.children', 'mc')
        ->leftJoin('m.page', 'p')
        ->leftJoin('m.site', 's')
        ->where('m.site = :site')
        ->andWhere('m.parent IS NULL')
        ->andWhere('m.type = :type')
        ->setParameter('site', $site)
        ->setParameter('type', $type)
        ->addOrderBy('m.root', 'ASC')
        ->addOrderBy('m.lft', 'ASC')
        ;
        
        return $qb->getQuery()->getResult();
    }
}
