<?php

class IcingaMenuExtender extends AppKitEventHandler implements AppKitEventHandlerInterface {

	public function checkObjectType(AppKitEvent &$e) {
		if (!$e->getObject() instanceof AppKit_NavigationContainerModel) {
			throw new AppKitEventException('Object should be AppKit_NavigationContainerModel');
		}
			
		return true;
	}

	public function handleEvent(AppKitEvent &$event) {

		$nav = $event->getObject();

		$user = $nav->getContext()->getUser();

		if ($user->hasCredential('icinga.user')) {
			
			
				// Throws exception if the admin is not there ...
				if ($nav->getNavItemByName('appkit.admin')) {
					// Navigation for "icinga"
					$icinga = $nav->getContainer()->addItemBefore('appkit.admin', AppKitNavItem::create('icinga', 'icinga')
					->setCaption('Monitoring')
					);
				}
				else {
					$icinga = $nav->getContainer()->addItem(AppKitNavItem::create('icinga', 'icinga')
					->setCaption('Monitoring'));
				}
				
				
				
				
				$icinga->addSubItem(AppKitNavItem::create('icinga.portalView', 'icinga.portalView')
				->setCaption('Portal')
				);
		}
		
		return true;

	}

}

?>