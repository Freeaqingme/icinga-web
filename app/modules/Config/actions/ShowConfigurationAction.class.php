<?php

class Config_ShowConfigurationAction extends IcingaConfigBaseAction {

    public function getDefaultViewName() {
        return 'Success';
    }

    public function executeRead(AgaviParameterHolder $rd) {
        return $this->getDefaultViewName();
    }

    public function executeWrite(AgaviParameterHolder $rd) {
        return $this->getDefaultViewName();
    }

    public function isSecure() {
        return true;
    }

    public function getCredentials() {
        return array('icinga.user');
    }

    public function handleError(AgaviRequestDataHolder $rd) {
        return $this->getDefaultViewName();
    }

}

?>