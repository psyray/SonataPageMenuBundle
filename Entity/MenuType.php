<?php

namespace Skillberto\SonataPageMenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuType
 * 
 * @ORM\Table(name="skillberto__menu_type")
 * @ORM\Entity
 */
class MenuType
{
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;
    
    /**
     * @var string
     * 
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="type")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $menus;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return (string) $this->getName();
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenus()
    {
        return $this->menus;
    }
    
}
