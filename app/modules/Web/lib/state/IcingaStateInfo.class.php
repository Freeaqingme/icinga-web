<?php
/**
 * Generic status class to wrap id's into messages and html
 * @author mhein
 */
abstract class IcingaStateInfo {
	
	const WRAP_LEFT		= '';
	const WRAP_RIGHT	= '';
	const UNKNOWN_TEXT	= 'NOT RECOGNIZED';
	
	/**
	 * The current state
	 * @var integer
	 */
	protected $current_state = null;
	
	/**
	 * Array of status text messages
	 * @var array
	 */
	protected $state_list = array (
	
	);
	
	/**
	 * Generic constructor to create this object
	 * @param mixed	$type	The current status
	 * @return none
	 */
	public function __construct($type) {
		if (is_numeric($type)) {
			$this->setStateById((int) $type);
		}			
	}
	
	/**
	 * Sets the state by an integer value
	 * @param integer $id
	 * @return boolean	always true
	 */
	public function setStateById($id) {
		$this->current_state = $id;
		return true;
	}
	
	/**
	 * Returns the current state as integer value
	 * @return integer
	 */
	public function getCurrentState() {
		return $this->current_state;
	}
	
	/**
	 * Returns the current state as textual message
	 * @return string
	 */
	public function getCurrentStateAsText() {
		return $this->getWrappedText($this->getStateText($this->getCurrentState()));
	}
	
	/**
	 * Creates a generic html format and returns an stringable xml node
	 * @return AppKitXmlTag
	 */
	public function getCurrentStateAsHtml() {
		$span = AppKitXmlTag::create('span', $this->getCurrentStateAsText());
		$div = AppKitXmlTag::create('div', $span)->addAttribute(
			'class', sprintf('icinga-status icinga-status-%s', strtolower($this->getStateText($this->getCurrentState())))
		);
		
		return $div;
	}
	
	/**
	 * Wrapps the text into a specific format
	 * @param string $text
	 * @return string
	 */
	protected function getWrappedText($text) {
		return sprintf('%s%s%s', self::WRAP_LEFT, $text, self::WRAP_RIGHT);
	}
	
	/**
	 * Returns a text from an integer state
	 * @param integer $state
	 * @return string
	 */
	protected function getStateText($state) {
		if (array_key_exists($state, $this->state_list)) {
			
			return $this->state_list[$state];
		}
		return self::UNKNOWN_TEXT;
	}

	public function getStateList() {
		return $this->state_list;
	}
	
}

?>