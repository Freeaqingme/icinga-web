<?php

class Cronks_System_ViewProcSuccessView extends ICINGACronksBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		
		$template_file = sprintf(
			'%s/%s.xml', 
			AgaviConfig::get('de.icinga.web.xml_template_folder'), 
			$rd->getParameter('template')
		);
		
		$template = new IcingaTemplateXmlParser($template_file);
		$template->parseTemplate();
		
		$worker = new IcingaTemplateWorker();
		$worker->setTemplate($template);
		$worker->setApi(AppKitFactories::getInstance()->getFactory('IcingaData')->API());
		
		$layout_class = $template->getSectionParams('option')->getParameter('layout');
		$layout = AppKitClassUtil::createInstance($layout_class);
		
		$layout->setContainer($this->getContainer());
		$layout->setWorker($worker);
		$layout->setParameters($rd);
		
		return $layout->getLayoutContent();
	}
	
	public function executeJson(AgaviRequestDataHolder $rd)
	{
		$template_file = sprintf(
			'%s/%s.xml', 
			AgaviConfig::get('de.icinga.web.xml_template_folder'), 
			$rd->getParameter('template')
		);
		
		$template = new IcingaTemplateXmlParser($template_file);
		$template->parseTemplate();
		
		$data = array ();

		$worker = new IcingaTemplateWorker();
		$worker->setTemplate($template);
		$worker->setApi(AppKitFactories::getInstance()->getFactory('IcingaData')->API());
		$worker->setUser($this->getContext()->getUser()->getNsmUser());
		
		if (is_numeric($rd->getParameter('page_start')) && is_numeric($rd->getParameter('page_limit'))) {
			$worker->setResultLimit($rd->getParameter('page_start'), $rd->getParameter('page_limit'));
		}
		
		if ($rd->getParameter('sort_field', null) !== null) {
			$worker->setOrderColumn($rd->getParameter('sort_field'), $rd->getParameter('sort_dir', 'ASC'));
		}
		
		// Apply the filter to our template worker
		if (is_array($rd->getParameter('f'))) {
			$pm = $this->getContext()->getModel('System.ViewProcFilterParams', 'Cronks');
			$pm->setParams($rd->getParameter('f'));
			$pm->applyToWorker($worker);
		}
		
		$worker->buildAll();

		// var_dump($worker);
		
		$data['resultRows'] = $worker->fetchDataArray();
		$data['resultCount'] = $worker->countResults();
		
		// OK hopefully all done
		$data['resultSuccess'] = true; 

		
		return json_encode($data);
	}
}

?>