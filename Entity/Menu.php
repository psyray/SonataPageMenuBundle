<?php

namespace Skillberto\SonataPageMenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Menu.
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="skillberto__menu")
 * @ORM\Entity(repositoryClass="Skillberto\SonataPageMenuBundle\Entity\Repository\MenuRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Menu
{
    /**
     * @var int
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
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    protected $icon;

    /**
     * @var bool
     *
     * @ORM\Column(name="clickable", type="boolean", nullable=false)
     */
    protected $clickable = true;

    /**
     * @var int
     *
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer", nullable=false)
     */
    protected $lft;

    /**
     * @var int
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer", nullable=false)
     */
    protected $rgt;

    /**
     * @var int
     *
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    protected $root;

    /**
     * @var int
     *
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer", nullable=false)
     */
    protected $lvl;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="MenuType",inversedBy="menus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    protected $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $children;

    /**
     * @var \App\Application\Sonata\PageBundle\Entity\Page
     *
     * @ORM\ManyToOne(targetEntity="\App\Application\Sonata\PageBundle\Entity\Page")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    protected $page;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * @var \App\Application\Sonata\PageBundle\Entity\Site
     *
     * @ORM\ManyToOne(targetEntity="\App\Application\Sonata\PageBundle\Entity\Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="site_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    protected $site;

    /**
     * @var Menu
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $parent;

    /**
     * @var array
     *
     * @ORM\Column(name="attribute", type="array")
     */
    protected $attribute;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    protected $active = false;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", nullable=true)
     */
    protected $target;

    /**
     * @var bool
     *
     * @ORM\Column(name="user_restricted", type="boolean", nullable=false)
     */
    protected $userRestricted = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="hide_when_userconnected", type="boolean", nullable=false)
     */
    protected $hideWhenUserConnected = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set icon.
     *
     * @param string $icon
     *
     * @return Menu
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set clickable.
     *
     * @param bool $clickable
     *
     * @return Menu
     */
    public function setClickable($clickable)
    {
        $this->clickable = $clickable;

        return $this;
    }

    /**
     * Get clickable.
     *
     * @return bool
     */
    public function getClickable()
    {
        return $this->clickable;
    }

    /**
     * Set lft.
     *
     * @param int $lft
     *
     * @return Menu
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft.
     *
     * @return int
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt.
     *
     * @param int $rgt
     *
     * @return Menu
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt.
     *
     * @return int
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root.
     *
     * @param int $root
     *
     * @return Menu
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root.
     *
     * @return int
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set lvl.
     *
     * @param int $lvl
     *
     * @return Menu
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl.
     *
     * @return int
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Menu
     */
    public function setType($type)
    {
        if (null !== $this->getParent() && $this->getParent()->getType() != $type) {
            $this->type = $this->getParent()->getType();
        } else {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add children.
     *
     * @return Menu
     */
    public function addChild(\Skillberto\SonataPageMenuBundle\Entity\Menu $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children.
     */
    public function removeChild(\Skillberto\SonataPageMenuBundle\Entity\Menu $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set page.
     *
     * @param \App\Application\Sonata\PageBundle\Entity\Page $page
     *
     * @return Menu
     */
    public function setPage(\App\Application\Sonata\PageBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page.
     *
     * @return \App\Application\Sonata\PageBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set site.
     *
     * @param \App\Application\Sonata\PageBundle\Entity\Site $site
     *
     * @return Menu
     */
    public function setSite(\App\Application\Sonata\PageBundle\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return \App\Application\Sonata\PageBundle\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set parent.
     *
     * @param \Skillberto\SonataPageMenuBundle\Entity\Menu $parent
     *
     * @return Menu
     */
    public function setParent(\Skillberto\SonataPageMenuBundle\Entity\Menu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \Skillberto\SonataPageMenuBundle\Entity\Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set attribute.
     *
     * @param array $attribute
     *
     * @return Menu
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute.
     *
     * @return array
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Menu
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set target.
     *
     * @param string $target
     *
     * @return Menu
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Menu
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set user restricted.
     *
     * @param bool $userRestricted
     *
     * @return Menu
     */
    public function setUserRestricted($userRestricted)
    {
        $this->userRestricted = $userRestricted;

        return $this;
    }

    /**
     * Get user restricted.
     *
     * @return bool
     */
    public function getUserRestricted()
    {
        return $this->userRestricted;
    }

    /**
     * Set hide when user connected.
     *
     * @param bool $hideWhenUserConnected
     *
     * @return Menu
     */
    public function setHideWhenUserConnected($hideWhenUserConnected)
    {
        $this->hideWhenUserConnected = $hideWhenUserConnected;

        return $this;
    }

    /**
     * Get hide when user connected.
     *
     * @return bool
     */
    public function getHideWhenUserConnected()
    {
        return $this->hideWhenUserConnected;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Menu
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Menu
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function createdAt()
    {
        $this->setCreatedAt(new \DateTime('now'));
        $this->setUpdatedAt(new \DateTime('now'));
    }

    /**
     * @ORM\PostPersist
     */
    public function updateAt()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }
}
