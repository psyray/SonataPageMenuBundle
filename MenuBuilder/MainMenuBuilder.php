<?php
namespace Skillberto\SonataPageMenuBundle\MenuBuilder;

use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Skillberto\SonataPageMenuBundle\Entity\Menu;
use Sonata\PageBundle\Entity\PageManager;
use Sonata\PageBundle\Route\CmsPageRouter;
use Sonata\PageBundle\Site\SiteSelectorInterface;
use Symfony\Cmf\Component\Routing\ChainedRouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Skillberto\SonataPageMenuBundle\Entity\MenuType;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Matcher\Voter\UriVoter;

class MainMenuBuilder implements MenuBuilderInterface
{
    protected $menuEntity;
    protected $factoryInterface;
    protected $managerRegistry;
    protected $routerInterface;
    protected $siteSelectorInterface;
    protected $currentMenuName = null;
    protected $rendered = false;
    protected $mainMenu;
    protected $request;
    protected $authorizationChecker;

    public function __construct($menuEntity, FactoryInterface $factoryInterface, ManagerRegistry $managerRegistry, RequestStack $requestStack, ChainedRouterInterface $routerInterface, 
                                SiteSelectorInterface $siteSelectorInterface, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->menuEntity               = $menuEntity;
        $this->factoryInterface         = $factoryInterface;
        $this->managerRegistry          = $managerRegistry;
        $this->request                  = $requestStack->getCurrentRequest();
        $this->routerInterface          = $routerInterface;
        $this->siteSelectorInterface    = $siteSelectorInterface;
        $this->authorizationChecker     = $authorizationChecker;
    }
    
    public function getMenu(array $options)
    {
        $menuType = $this->managerRegistry->getRepository('SkillbertoSonataPageMenuBundle:MenuType')->findOneById($options['type']);
        if(null === $menuType) {
            return;
        }
        $this->renderMenu($menuType);


        return $this->mainMenu;
    }

    public function getCurrentMenuName()
    {
        return $this->currentMenuName;
    }

    
    protected function renderMenu(MenuType $menuType)
    {
        $site    = $this->siteSelectorInterface->retrieve();

        //$menus   = $this->managerRegistry->getRepository($this->menuEntity)->findBy(array("site" => $site->getId(), "parent" => null), array("root" => "ASC", "lft" => "ASC"));
        $menus   = $this->managerRegistry->getRepository($this->menuEntity)->getMenus($site, $menuType);

        if (count($menus) == 0) {
            $this->mainMenu = $this->factoryInterface->createItem('root');

            return;
        }

        $this->createMenuStructure($menus);
    }

    protected function createMenuStructure($menus, ItemInterface $root = null)
    {
        foreach ($menus as $menu) {
            $this->createMenu($menu, $root);
        }
    }

    protected function createMenu(Menu $menu, ItemInterface $root = null)
    {
        if((null !== $menu->getParent() && $menu->getParent()->getUserRestricted() || $menu->getUserRestricted()) && 
            !$this->authorizationChecker->isGranted('ROLE_USER')) {
            return false;
        }

        if($menu->getHideWhenUserConnected() && $this->authorizationChecker->isGranted('ROLE_USER')) {
            return false;
        }
        
        $currentItem = $this->createMenuItem($menu);

        $level = $menu->getLvl();

        if ($level == 0) {
            $this->mainMenu = $currentItem;
        } else {
            $currentMenu = $root->addChild($currentItem);
            if (null !== $menu->getIcon()) {
                $currentMenu->setExtra('icon', $menu->getIcon());
            }
            if ($level == 1 && $menu->getChildren()->count() > 0) {
                $currentMenu->setExtra('dropdown', true);
            }
        }

        if (count($menu->getChildren()) > 0 && ($menu->getActive() or $level == 0)) {
            if ($level == 0) {
                $this->putRootAttributes($currentItem);
            } else {
                $this->putChildAttributes($currentItem);
            }

            $this->createMenuStructure($menu->getChildren(), $currentItem);
        }
    }

    protected function createMenuItem(Menu $menu)
    {
        $current = $this->factoryInterface->createItem($menu->getName(), array('label' => $menu->getName()));

        if ($menu->getClickable() && null !== $menu->getPage()) {
            $this->createLink($current, $menu);
        }

        $matcher = new Matcher();
        $matcher->addVoter(new UriVoter($_SERVER['REQUEST_URI']));
        if ($matcher->isCurrent($current)) {
            $current->setCurrent(true);
            $this->currentMenuName = $menu->getName();
        }

        return $current;
    }

    protected function createLink(ItemInterface $itemInterface, Menu $menu)
    {
        $uri = $this->routerInterface->generate($menu->getPage());

        $itemInterface->setUri($uri);
    }

    protected function putRootAttributes(ItemInterface $itemInterface)
    {
        $itemInterface->setChildrenAttribute("class", "nav navbar-nav");
    }

    protected function putChildAttributes(ItemInterface $itemInterface)
    {
        $itemInterface->setAttribute("class", "");
    }
}
